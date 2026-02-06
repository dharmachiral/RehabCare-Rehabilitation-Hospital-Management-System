<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Modules\Student\Entities\Student;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 7) { // Student role
            try {
                $student = Student::with([
                    'user', 
                    'classModel', 
                    'expenses' => function($query) {
                        $query->orderBy('expense_date', 'desc');
                    },
                    'expenses.expenseType',
                    'payments' => function($query) {
                        $query->orderBy('payment_date', 'desc');
                    },
                    'payments.paymentItems'
                ])->where('user_id', $user->id)
                  ->firstOrFail();

                // Calculate comprehensive fee details using the same logic as profile view
                $feeDetails = $this->calculateFeeDetails($student);

                // Get ordered records
                $expenses = $this->getOrderedExpenses($student);
                $payments = $this->getOrderedPayments($student);

                // Additional student metrics
                $pendingExpenses = $student->expenses->where('payment_status', 'pending')->count();
                $completedPayments = $student->payments->where('status', 'completed')->count();

                return view('setting::studentdash', [
                    'student' => $student,
                    'totalExpenses' => $feeDetails['total_expenses'],
                    'totalPayments' => $feeDetails['total_payments'],
                    'balanceDue' => $feeDetails['remaining_money'] > 0 ? 0 : abs($feeDetails['remaining_money']),
                    'expenses' => $expenses,
                    'payments' => $payments,
                    'pendingExpenses' => $pendingExpenses,
                    'completedPayments' => $completedPayments,
                    'feeDetails' => $feeDetails,
                    'stats' => [
                        'total_expenses' => $feeDetails['total_expected_income'],
                        'total_paid' => $feeDetails['total_payments'],
                        'balance_due' => $feeDetails['remaining_money'] > 0 ? 0 : abs($feeDetails['remaining_money']),
                        'pending_count' => $pendingExpenses,
                        'completed_count' => $completedPayments,
                        'total_admission_fee' => $feeDetails['total_admission_fee'],
                        'total_monthly_fee' => $feeDetails['total_monthly_fee'],
                    ]
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                Log::error('Student not found for user: ' . $user->id);
                return redirect()->route('profile.edit')->with('error', 'Student profile not found. Please complete your profile.');
            } catch (\Exception $e) {
                Log::error('Dashboard error for user ' . $user->id . ': ' . $e->getMessage());
                return redirect()->route('home')->with('error', 'Unable to load dashboard. Please try again.');
            }
        } else {
            return view('setting::index');
        }
    }

    /**
     * Calculate comprehensive fee details (same as profile view)
     */
    private function calculateFeeDetails($student)
    {
        $admissionFee = $student->admission_fee ?? 0;
        $monthlyFee = $student->monthly_fee ?? 0;
        
        $admissionDate = Carbon::parse($student->admission_date);
        
        // Set end date - if recover date exists, use it, otherwise use today
        $endDate = $student->recover_date ? Carbon::parse($student->recover_date) : Carbon::now();
        
        // Calculate monthly fees - pass student object to check recover_date
        $monthlyFeesBreakdown = $this->calculateMonthlyFees($admissionDate, $endDate, $monthlyFee, $student->recover_date);
        
        // Get expenses
        $totalExpenses = $student->expenses->sum('amount');
        $totalPaidExpenses = $student->expenses->sum('paid_amount');
        $totalDueExpenses = $student->expenses->sum('due_amount');
        
        // Calculate total expected income
        $totalAdmissionFee = $admissionFee;
        $totalMonthlyFee = $monthlyFeesBreakdown['total_monthly_fee'];
        $totalExpectedIncome = $totalAdmissionFee + $totalMonthlyFee + $totalExpenses;
        
        // Get actual payments
        $totalPayments = $student->payments->sum('total_amount');
        
        // Calculate remaining/due money
        $remainingMoney = $totalPayments - $totalExpectedIncome;
        
        return [
            'admission_fee' => $admissionFee,
            'monthly_fee' => $monthlyFee,
            'admission_date' => $student->admission_date,
            'recover_date' => $student->recover_date,
            'calculation_end_date' => $endDate->format('Y-m-d'),
            'total_months' => $monthlyFeesBreakdown['total_months'],
            'monthly_breakdown' => $monthlyFeesBreakdown['breakdown'],
            'total_admission_fee' => $totalAdmissionFee,
            'total_monthly_fee' => $totalMonthlyFee,
            'total_expenses' => $totalExpenses,
            'total_paid_expenses' => $totalPaidExpenses,
            'total_due_expenses' => $totalDueExpenses,
            'total_expected_income' => $totalExpectedIncome,
            'total_payments' => $totalPayments,
            'remaining_money' => $remainingMoney,
            'remaining_status' => $remainingMoney >= 0 ? 'positive' : 'negative',
        ];
    }

    /**
     * Calculate monthly fees (same as profile view)
     */
    private function calculateMonthlyFees($startDate, $endDate, $monthlyFee, $recoverDate = null)
    {
        $breakdown = [];
        $totalMonthlyFee = 0;
        $current = $startDate->copy();
        
        // Determine if we have a recover date (more reliable than date comparison)
        $hasRecoverDate = !is_null($recoverDate);
        
        while ($current <= $endDate) {
            $monthStart = $current->copy()->startOfMonth();
            $monthEnd = $current->copy()->endOfMonth();
            
            // Adjust start date for calculation
            $periodStart = $current->greaterThan($monthStart) ? $current : $monthStart;
            
            // Check if this is the current month
            $isCurrentMonth = $current->format('Y-m') == Carbon::now()->format('Y-m');
            
            // Only use full month for current month when no specific recover date is set
            if ($isCurrentMonth && !$hasRecoverDate) {
                // No recover date - use full current month
                $periodEnd = $monthEnd;
                $daysCovered = $monthStart->daysInMonth;
            } else {
                // Has recover date or not current month - calculate proportional
                $periodEnd = $endDate->lessThan($monthEnd) ? $endDate : $monthEnd;
                $daysCovered = $periodStart->diffInDays($periodEnd) + 1;
            }
            
            $daysInMonth = $monthStart->daysInMonth;
            $monthlyFeeProportion = ($daysCovered / $daysInMonth) * $monthlyFee;
            
            $breakdown[] = [
                'month' => $current->format('M Y'),
                'period' => $periodStart->format('d M') . ' - ' . $periodEnd->format('d M'),
                'days_covered' => $daysCovered,
                'days_in_month' => $daysInMonth,
                'monthly_fee' => $monthlyFeeProportion,
                'is_full_month' => $daysCovered == $daysInMonth
            ];
            
            $totalMonthlyFee += $monthlyFeeProportion;
            $current = $monthStart->copy()->addMonth()->startOfMonth();
        }
        
        return [
            'breakdown' => $breakdown,
            'total_monthly_fee' => $totalMonthlyFee,
            'total_months' => count($breakdown)
        ];
    }

    /**
     * Get ordered expenses with proper column name detection
     */
    private function getOrderedExpenses($student)
    {
        try {
            // Try different possible column names for expenses date
            $expenseColumns = ['expenses_date', 'expense_date', 'date', 'created_at'];
            
            foreach ($expenseColumns as $column) {
                if (Schema::hasColumn('expenses', $column)) {
                    return $student->expenses()
                        ->orderBy($column, 'desc')
                        ->get();
                }
            }
            
            // Fallback: order by ID if no date column found
            return $student->expenses()
                ->orderBy('id', 'desc')
                ->get();
                
        } catch (\Exception $e) {
            Log::warning('Expenses ordering failed: ' . $e->getMessage());
            return $student->expenses; // Return unordered collection as fallback
        }
    }

    /**
     * Get ordered payments with proper column name detection
     */
    private function getOrderedPayments($student)
    {
        try {
            // Try different possible column names for payment date
            $paymentColumns = ['payment_date', 'date', 'created_at'];
            
            foreach ($paymentColumns as $column) {
                if (Schema::hasColumn('payments', $column)) {
                    return $student->payments()
                        ->orderBy($column, 'desc')
                        ->get();
                }
            }
            
            // Fallback: order by ID if no date column found
            return $student->payments()
                ->orderBy('id', 'desc')
                ->get();
                
        } catch (\Exception $e) {
            Log::warning('Payments ordering failed: ' . $e->getMessage());
            return $student->payments; // Return unordered collection as fallback
        }
    }

    /**
     * Get financial summary for API or additional views
     */
    public function financialSummary()
    {
        $user = Auth::user();
        
        if ($user->role_id != 7) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $student = Student::with(['expenses', 'payments'])
                ->where('user_id', $user->id)
                ->firstOrFail();

            $feeDetails = $this->calculateFeeDetails($student);

            return response()->json([
                'total_expected_income' => $feeDetails['total_expected_income'],
                'total_paid' => $feeDetails['total_payments'],
                'balance_due' => $feeDetails['remaining_money'] > 0 ? 0 : abs($feeDetails['remaining_money']),
                'total_admission_fee' => $feeDetails['total_admission_fee'],
                'total_monthly_fee' => $feeDetails['total_monthly_fee'],
                'total_expenses' => $feeDetails['total_expenses'],
                'currency' => 'USD'
            ]);

        } catch (\Exception $e) {
            Log::error('Financial summary error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch financial data'], 500);
        }
    }

    /**
     * Get recent activity for dashboard
     */
    public function recentActivity()
    {
        $user = Auth::user();
        
        if ($user->role_id != 7) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $student = Student::where('user_id', $user->id)->firstOrFail();
            
            $recentExpenses = $this->getOrderedExpenses($student)->take(5);
            $recentPayments = $this->getOrderedPayments($student)->take(5);

            return response()->json([
                'recent_expenses' => $recentExpenses,
                'recent_payments' => $recentPayments
            ]);

        } catch (\Exception $e) {
            Log::error('Recent activity error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch recent activity'], 500);
        }
    }
}