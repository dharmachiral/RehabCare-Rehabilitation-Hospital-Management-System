<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Student\Entities\Student;
use Modules\Student\Entities\StudentFee;
use Modules\Student\Entities\Payment;
use Modules\Student\Entities\PaymentItem;
use Modules\Student\Entities\Invoice;
use Modules\Student\Entities\InvoiceItem;
use Modules\Student\Entities\FeeType;
use Modules\Student\Entities\Expense;
use Carbon\Carbon;
use Modules\Student\Entities\FeeStructure;
use Illuminate\Support\Facades\Log;

class GlobalPaymentController extends Controller
{
    /**
     * Show global payment form with student selection
     */
    public function create()
    {
        $students = Student::with('classModel')->get();
        return view('student::payments.form2', compact('students'));
    }

    /**
     * Show payment form for selected student
     */
    public function showStudentForm(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id'
        ]);

        $student = Student::findOrFail($request->student_id);

        // Ensure all pending fees are created in the database with pro-rata calculation
        $this->createPendingFeesInDatabase($student);

        // ==============================
        //  FETCH FEES (SORTED BY YEAR + MONTH)
        // ==============================
        $fees = StudentFee::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->with(['feeType', 'paymentItems'])
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($fee) {
                $totalPaid = $fee->paymentItems->sum('paid_amount');
                $fee->paid_amount = $totalPaid;
                $fee->remaining_amount = $fee->amount - $totalPaid;
                return $fee;
            });

        // ==============================
        //  FETCH EXPENSES
        // ==============================
        $expenses = Expense::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->with('expenseType')
            ->get()
            ->map(function ($expense) {
                $expense->remaining_amount = $expense->amount - $expense->paid_amount;
                return $expense;
            });

        // ==============================
        //  FEE TYPES
        // ==============================
        $admissionFeeType = FeeType::where('name', 'LIKE', '%admission%')->first();
        $monthlyFeeType = FeeType::where('name', 'LIKE', '%monthly%')->first();
        $otherFeeTypes = FeeType::whereNotIn('id', [$admissionFeeType?->id, $monthlyFeeType?->id])->get();

        // ==============================
        //  INITIAL VARIABLES
        // ==============================
        $feeSummary = [
            'admission' => 0,
            'monthly' => 0,
            'other' => 0,
        ];

        $monthlyFeeDetails = [];
        $admissionFeeAmount = 0;
        $monthlyFeeAmount = 0;

        // ==============================
        //  TOTAL EXPENSES (REMAINING)
        // ==============================
        $totalExpenses = $expenses->sum('remaining_amount');

        // ==============================
        //  ADMISSION FEES (REMAINING)
        // ==============================
        if ($admissionFeeType) {
            $admissionFees = $fees->where('fee_type_id', $admissionFeeType->id);
            $admissionFeeAmount = $admissionFees->sum('remaining_amount');
        }

        // ==============================
        //  MONTHLY FEES (PRO-RATA + REMAINING)
        // ==============================
        if ($monthlyFeeType) {
            $monthlyFees = $fees->where('fee_type_id', $monthlyFeeType->id);

            foreach ($monthlyFees as $monthlyFee) {
                $calculatedAmount = $this->calculateProRataMonthlyFee($student, $monthlyFee);
                $monthlyFeeDetails[$monthlyFee->id] = $calculatedAmount;
                
                // Use pro-rata amount for remaining calculation
                $proRataAmount = $calculatedAmount['amount'];
                $remainingAmount = max(0, $proRataAmount - $monthlyFee->paid_amount);
                $monthlyFeeAmount += $remainingAmount;
            }
        }

        // ==============================
        //  OTHER FEES (REMAINING)
        // ==============================
        $otherFeesAmount = $fees
            ->whereNotIn('fee_type_id', [$admissionFeeType?->id, $monthlyFeeType?->id])
            ->sum('remaining_amount');

        // ==============================
        //  TOTALS & SUMMARY
        // ==============================
        $totalFees = $admissionFeeAmount + $monthlyFeeAmount + $otherFeesAmount;
        $totalDueAmount = $totalFees + $totalExpenses;

        $feeSummary['admission'] = $admissionFeeAmount;
        $feeSummary['monthly'] = $monthlyFeeAmount;
        $feeSummary['other'] = $otherFeesAmount;

        $allFeeTypes = FeeType::all();

        $students = Student::with('classModel')->get();

        // ==============================
        //  RETURN TO VIEW
        // ==============================
        return view('payments.global.create', compact(
            'student',
            'students',
            'fees',
            'expenses',
            'allFeeTypes',
            'feeSummary',
            'totalDueAmount',
            'totalExpenses',
            'monthlyFeeDetails',
            'admissionFeeType',
            'monthlyFeeType',
            'admissionFeeAmount',
            'monthlyFeeAmount',
            'otherFeesAmount'
        ));
    }

    /**
     * Calculate pro-rata monthly fee considering both admission date and recover date
     */
    private function calculateProRataMonthlyFee($student, $monthlyFee)
    {
        $month = $monthlyFee->month;
        $year = $monthlyFee->year;
        
        // Get the month start and end dates
        $monthStart = Carbon::create($year, $month, 1)->startOfMonth();
        $monthEnd = Carbon::create($year, $month, 1)->endOfMonth();
        
        // Calculate actual stay period
        $stayStart = $monthStart;
        $stayEnd = $monthEnd;
        
        $isProRata = false;
        $reason = 'Full month';
        
        // If admission date is in this month, adjust start date
        $admissionDate = Carbon::parse($student->admission_date);
        if ($admissionDate->between($monthStart, $monthEnd)) {
            $stayStart = $admissionDate;
            $isProRata = true;
            $reason = 'Admission in middle of month';
        }
        
        // If recover date is in this month, adjust end date
        if ($student->recover_date) {
            $recoverDate = Carbon::parse($student->recover_date);
            
            // If student recovered during this month
            if ($recoverDate->between($monthStart, $monthEnd)) {
                $stayEnd = $recoverDate;
                $isProRata = true;
                $reason = 'Recovery in middle of month';
            } 
            // If student recovered before this month started
            elseif ($recoverDate->lt($monthStart)) {
                return [
                    'amount' => 0,
                    'days_stayed' => 0,
                    'total_days' => $monthStart->daysInMonth,
                    'daily_rate' => 0,
                    'is_pro_rata' => true,
                    'stay_period' => 'No stay (recovered before month)',
                    'reason' => 'Recovered before month start'
                ];
            }
        }
        
        // If admission date is after recover date (edge case)
        if ($student->recover_date && $admissionDate->gt(Carbon::parse($student->recover_date))) {
            return [
                'amount' => 0,
                'days_stayed' => 0,
                'total_days' => $monthStart->daysInMonth,
                'daily_rate' => 0,
                'is_pro_rata' => true,
                'stay_period' => 'No stay (admission after recovery)',
                'reason' => 'Admission after recovery date'
            ];
        }
        
        // Calculate days stayed
        $daysStayed = $stayStart->diffInDays($stayEnd) + 1; // Include both start and end days
        $totalDaysInMonth = $monthStart->daysInMonth;
        
        // Ensure days stayed doesn't exceed month bounds
        if ($daysStayed > $totalDaysInMonth) {
            $daysStayed = $totalDaysInMonth;
        }
        
        // Calculate pro-rata amount
        $dailyRate = $student->monthly_fee / $totalDaysInMonth;
        $proRataAmount = round($dailyRate * $daysStayed, 2);
        
        // Build stay period description
        $stayPeriod = "Full month";
        if ($isProRata) {
            if ($stayStart->eq($monthStart) && !$stayEnd->eq($monthEnd)) {
                // Only recovery case (e.g., recovered on 20th)
                $stayPeriod = $monthStart->format('d M') . ' - ' . $stayEnd->format('d M Y');
            } elseif (!$stayStart->eq($monthStart) && $stayEnd->eq($monthEnd)) {
                // Only admission case (e.g., admitted on 20th)
                $stayPeriod = $stayStart->format('d M Y') . ' - ' . $monthEnd->format('d M');
            } else {
                // Both admission and recovery in same month
                $stayPeriod = $stayStart->format('d M Y') . ' - ' . $stayEnd->format('d M Y');
            }
        }
        
        return [
            'amount' => $proRataAmount,
            'days_stayed' => $daysStayed,
            'total_days' => $totalDaysInMonth,
            'daily_rate' => $dailyRate,
            'is_pro_rata' => $isProRata,
            'stay_period' => $stayPeriod,
            'reason' => $reason
        ];
    }

    /**
     * Create pending fees in database with pro-rata calculation
     */
    private function createPendingFeesInDatabase($student)
    {
        // Get fees from student table
        $admissionFee = $student->admission_fee;
        $monthlyFee = $student->monthly_fee;
        
        $admissionFeeType = FeeType::where('name', 'LIKE', '%admission%')->first();
        $monthlyFeeType = FeeType::where('name', 'LIKE', '%monthly%')->first();
        
        // Create admission fee if not exists and amount > 0
        if ($admissionFeeType && $admissionFee > 0) {
            $existingAdmissionFee = StudentFee::where('student_id', $student->id)
                ->where('fee_type_id', $admissionFeeType->id)
                ->first();
                
            if (!$existingAdmissionFee) {
                StudentFee::create([
                    'student_id' => $student->id,
                    'fee_type_id' => $admissionFeeType->id,
                    'amount' => $admissionFee,
                    'status' => 'unpaid',
                    'due_date' => $student->admission_date,
                ]);
            }
        }
        
        // Create monthly fees for pending months with pro-rata calculation
        if ($monthlyFeeType && $monthlyFee > 0) {
            $this->createPendingMonthlyFees($student, $monthlyFeeType, $monthlyFee);
        }
    }

    /**
     * Create pending monthly fees with pro-rata calculation
     */
    private function createPendingMonthlyFees($student, $monthlyFeeType, $monthlyFeeAmount)
    {
        $admissionDate = Carbon::parse($student->admission_date);
        $currentDate = Carbon::now();
        
        // Determine end date for fee creation
        $endDate = $currentDate;
        if ($student->recover_date) {
            $recoverDate = Carbon::parse($student->recover_date);
            // Use the earlier of current date or recover date
            $endDate = $recoverDate->lt($currentDate) ? $recoverDate : $currentDate;
        }
        
        // Start from admission month
        $currentMonth = $admissionDate->copy()->startOfMonth();
        
        while ($currentMonth <= $endDate) {
            // Check if monthly fee already exists for this month
            $existingFee = StudentFee::where('student_id', $student->id)
                ->where('fee_type_id', $monthlyFeeType->id)
                ->where('year', $currentMonth->year)
                ->where('month', $currentMonth->month)
                ->first();
                
            // Calculate pro-rata amount for this month
            $proRataData = $this->calculateProRataMonthlyFee($student, (object)[
                'month' => $currentMonth->month,
                'year' => $currentMonth->year
            ]);
            
            if (!$existingFee) {
                // Only create fee if amount > 0 (student actually stayed during this month)
                if ($proRataData['amount'] > 0) {
                    StudentFee::create([
                        'student_id' => $student->id,
                        'fee_type_id' => $monthlyFeeType->id,
                        'amount' => $proRataData['amount'],
                        'status' => 'unpaid',
                        'due_date' => $currentMonth->endOfMonth(),
                        'year' => $currentMonth->year,
                        'month' => $currentMonth->month,
                        'pro_rata_data' => json_encode($proRataData)
                    ]);
                    
                    Log::info("Created monthly fee for student {$student->id}, {$currentMonth->format('M Y')}: Rs. {$proRataData['amount']} ({$proRataData['days_stayed']}/{$proRataData['total_days']} days)");
                }
            } else {
                // UPDATE EXISTING FEE with correct pro-rata amount
                if ($existingFee->amount != $proRataData['amount']) {
                    $existingFee->update([
                        'amount' => $proRataData['amount'],
                        'pro_rata_data' => json_encode($proRataData)
                    ]);
                    
                    Log::info("Updated monthly fee for student {$student->id}, {$currentMonth->format('M Y')}: Rs. {$proRataData['amount']} ({$proRataData['days_stayed']}/{$proRataData['total_days']} days)");
                }
            }
            
            $currentMonth->addMonth();
        }
    }

    /**
     * Use only advance balance to pay dues
     */
    public function useAdvanceOnly($student_id)
    {
        try {
            DB::beginTransaction();

            $student = Student::findOrFail($student_id);
            
            // Ensure fees are created in database
            $this->createPendingFeesInDatabase($student);
            
            $totalDueBefore = $this->calculateTotalDueAmount($student);
            
            Log::info("Advance Only - Student: {$student->id}, Balance: {$student->balance}, Due: {$totalDueBefore}");

            if ($student->balance <= 0) {
                return redirect()->back()->with('error', 'No advance balance available to use.');
            }

            if ($totalDueBefore <= 0) {
                return redirect()->back()->with('error', 'No due amounts to pay.');
            }

            // Calculate how much credit we can use
            $creditToUse = min($student->balance, $totalDueBefore);

            // Create a zero-amount payment record for tracking
            $payment = Payment::create([
                'student_id' => $student->id,
                'payment_date' => now(),
                'total_amount' => 0,
                'payment_method' => 'advance',
                'remarks' => 'Used advance balance to pay dues: Rs. ' . number_format($creditToUse, 2),
                'image' => null,
                'status' => 'completed'
            ]);

            // Use advance to pay dues
            $creditUsed = $this->applyCreditToDues($student, $creditToUse, $payment->id);
            
            // Update student balance
            $student->balance -= $creditUsed;
            $student->save();

            // Create or update invoice with payment details
            $invoice = $this->createInvoiceForPayment($student, $payment, $creditUsed);

            DB::commit();

            // Redirect to invoice page with success message
            return redirect()->route('global.payments.show', $payment->id)
                ->with('success', "Successfully used Rs. " . number_format($creditUsed, 2) . 
                       " from advance balance to pay dues. Remaining advance: Rs. " . number_format($student->balance, 2));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Advance payment failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Failed to use advance balance: ' . $e->getMessage());
        }
    }

    /**
     * Store global payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'total_amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $student = Student::findOrFail($request->student_id);
            
            // Ensure fees are created in database with pro-rata amounts
            $this->createPendingFeesInDatabase($student);
            
            $paymentAmount = $request->total_amount;
            $totalDueBefore = $this->calculateTotalDueAmount($student);
            
            Log::info("=== GLOBAL PAYMENT PROCESSING START ===");
            Log::info("Student: {$student->id}, Payment: {$paymentAmount}, Balance: {$student->balance}, Due: {$totalDueBefore}");

            // Upload image if available
            $imagePath = $request->hasFile('image')
                ? $request->file('image')->store('uploads/receipts', 'public')
                : null;

            // Create Payment Record
            $payment = Payment::create([
                'student_id' => $student->id,
                'payment_date' => now(),
                'total_amount' => $paymentAmount,
                'payment_method' => $request->payment_method,
                'image' => $imagePath,
                'status' => 'completed'
            ]);

            $totalAppliedToDue = 0;
            $newAdvanceAmount = 0;

            // === 1️⃣ First, use available credit (existing advance) to pay dues ===
            $availableCredit = $student->balance;
            $creditToUse = min($availableCredit, $totalDueBefore);
            
            Log::info("Step 1 - Credit Usage: Available: {$availableCredit}, To Use: {$creditToUse}");
            
            if ($creditToUse > 0) {
                $creditUsed = $this->applyCreditToDues($student, $creditToUse, $payment->id);
                $totalAppliedToDue += $creditUsed;
                $availableCredit -= $creditUsed;
                Log::info("Credit Applied: {$creditUsed}, Remaining Credit: {$availableCredit}");
            }

            // === 2️⃣ Calculate remaining due after using credit ===
            $remainingDueAfterCredit = max(0, $totalDueBefore - $creditToUse);
            Log::info("Step 2 - Remaining Due After Credit: {$remainingDueAfterCredit}");
            
            // === 3️⃣ Use new payment to cover remaining dues ===
            $amountForDues = min($paymentAmount, $remainingDueAfterCredit);
            Log::info("Step 3 - Amount for Dues: {$amountForDues}");
            
            if ($amountForDues > 0) {
                $paymentApplied = $this->applyPaymentToDues($student, $amountForDues, $payment->id);
                $totalAppliedToDue += $paymentApplied;
                Log::info("Payment Applied to Dues: {$paymentApplied}");
            }

            // === 4️⃣ Any remaining payment amount becomes new advance ===
            $newAdvanceAmount = $paymentAmount - $amountForDues;
            Log::info("Step 4 - New Advance: {$newAdvanceAmount} (Payment: {$paymentAmount} - Dues: {$amountForDues})");

            if ($newAdvanceAmount > 0) {
                PaymentItem::create([
                    'payment_id' => $payment->id,
                    'student_fee_id' => null,
                    'expense_id' => null,
                    'paid_amount' => $newAdvanceAmount,
                    'is_advance' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                Log::info("Advance Payment Item Created: {$newAdvanceAmount}");
            }

            // === 5️⃣ Update Student Balance ===
            $oldBalance = $student->balance;
            $student->balance = $availableCredit + $newAdvanceAmount;
            $student->save();

            Log::info("Step 5 - Balance Update: Old: {$oldBalance}, Available Credit: {$availableCredit}, New Advance: {$newAdvanceAmount}, Final: {$student->balance}");

            // === 6️⃣ Update payment remarks with final breakdown ===
            $payment->update([
                'remarks' => $this->generateRemarks($request->remarks, $creditToUse, $amountForDues, $newAdvanceAmount)
            ]);

            // === 7️⃣ Create Invoice for this payment ===
            $invoice = $this->createInvoiceForPayment($student, $payment, $totalAppliedToDue);

            DB::commit();

            Log::info("=== GLOBAL PAYMENT PROCESSING COMPLETE ===");
            Log::info("Credit Used: {$creditToUse}, Payment to Dues: {$amountForDues}, New Advance: {$newAdvanceAmount}, Final Balance: {$student->balance}");

            // Success message
            $successMessage = $this->generateSuccessMessage($creditToUse, $amountForDues, $newAdvanceAmount, $student->balance);

            // Redirect to invoice page
            return redirect()->route('global.payments.show', $payment->id)
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Global payment processing failed: ' . $e->getMessage());
            Log::error('Global payment error trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Payment failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Apply payment amount to due amounts
     */
    private function applyPaymentToDues(Student $student, $paymentAmount, $paymentId)
    {
        $totalApplied = 0;
        $remainingAmount = $paymentAmount;

        // Get REAL student fees from database (these should have pro-rata amounts)
        $realStudentFees = StudentFee::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->with(['feeType', 'paymentItems'])
            ->get();

        // Apply to expenses first
        $expenses = Expense::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->orderBy('expense_date', 'asc')
            ->get();

        foreach ($expenses as $expense) {
            if ($remainingAmount <= 0) break;

            $due = $expense->amount - $expense->paid_amount;
            $payAmount = min($due, $remainingAmount);

            if ($payAmount > 0) {
                $expense->paid_amount += $payAmount;
                $expense->status = ($expense->paid_amount >= $expense->amount) ? 'paid' : 'partial';
                $expense->save();

                PaymentItem::create([
                    'payment_id' => $paymentId,
                    'expense_id' => $expense->id,
                    'student_fee_id' => null,
                    'paid_amount' => $payAmount,
                    'is_advance' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $remainingAmount -= $payAmount;
                $totalApplied += $payAmount;
                
                Log::info("Applied payment to expense: {$expense->id}, Amount: {$payAmount}");
            }
        }

        // Apply to admission fee
        $admissionFeeType = FeeType::where('name', 'LIKE', '%admission%')->first();
        if ($admissionFeeType && $remainingAmount > 0) {
            $admissionFee = $realStudentFees
                ->where('fee_type_id', $admissionFeeType->id)
                ->whereIn('status', ['unpaid', 'partial'])
                ->first();

            if ($admissionFee) {
                $alreadyPaid = $admissionFee->paymentItems->sum('paid_amount');
                $due = $admissionFee->amount - $alreadyPaid;
                $payAmount = min($due, $remainingAmount);

                if ($payAmount > 0) {
                    // Create payment item first
                    PaymentItem::create([
                        'payment_id' => $paymentId,
                        'student_fee_id' => $admissionFee->id,
                        'expense_id' => null,
                        'paid_amount' => $payAmount,
                        'is_advance' => false,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // Then update the student fee paid amount and status
                    $admissionFee->updatePaidAmount();

                    $remainingAmount -= $payAmount;
                    $totalApplied += $payAmount;
                    
                    Log::info("Applied payment to admission fee: {$admissionFee->id}, Amount: {$payAmount}");
                }
            }
        }

        // Apply to monthly fees (oldest first) - THESE NOW HAVE PRO-RATA AMOUNTS
        $monthlyFeeType = FeeType::where('name', 'LIKE', '%monthly%')->first();
        if ($monthlyFeeType && $remainingAmount > 0) {
            $monthlyFees = $realStudentFees
                ->where('fee_type_id', $monthlyFeeType->id)
                ->whereIn('status', ['unpaid', 'partial'])
                ->sortBy(function($fee) {
                    return $fee->year * 100 + $fee->month;
                });

            foreach ($monthlyFees as $fee) {
                if ($remainingAmount <= 0) break;

                $alreadyPaid = $fee->paymentItems->sum('paid_amount');
                $due = $fee->amount - $alreadyPaid; // This now uses pro-rata amount
                $payAmount = min($due, $remainingAmount);

                if ($payAmount > 0) {
                    // Create payment item
                    PaymentItem::create([
                        'payment_id' => $paymentId,
                        'student_fee_id' => $fee->id,
                        'expense_id' => null,
                        'paid_amount' => $payAmount,
                        'is_advance' => false,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // Update student fee
                    $fee->updatePaidAmount();

                    $remainingAmount -= $payAmount;
                    $totalApplied += $payAmount;
                    
                    Log::info("Applied payment to monthly fee: {$fee->id}, Month: {$fee->month}/{$fee->year}, Pro-rata Amount: {$fee->amount}, Paid: {$payAmount}, Due: {$due}");
                }
            }
        }

        // Apply to other fees
        $otherFees = $realStudentFees
            ->whereNotIn('fee_type_id', [$admissionFeeType?->id, $monthlyFeeType?->id])
            ->whereIn('status', ['unpaid', 'partial']);

        foreach ($otherFees as $fee) {
            if ($remainingAmount <= 0) break;

            $alreadyPaid = $fee->paymentItems->sum('paid_amount');
            $due = $fee->amount - $alreadyPaid;
            $payAmount = min($due, $remainingAmount);

            if ($payAmount > 0) {
                // Create payment item
                PaymentItem::create([
                    'payment_id' => $paymentId,
                    'student_fee_id' => $fee->id,
                    'expense_id' => null,
                    'paid_amount' => $payAmount,
                    'is_advance' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update student fee
                $fee->updatePaidAmount();

                $remainingAmount -= $payAmount;
                $totalApplied += $payAmount;
                
                Log::info("Applied payment to other fee: {$fee->id}, Amount: {$payAmount}");
            }
        }

        Log::info("Total applied to dues: {$totalApplied}, Remaining: {$remainingAmount}");
        return $totalApplied;
    }

    /**
     * Apply available credit to due amounts
     */
    private function applyCreditToDues(Student $student, $availableCredit, $paymentId)
    {
        $totalCreditUsed = 0;
        $remainingCredit = $availableCredit;

        // Get REAL student fees from database with payment items (these have pro-rata amounts)
        $realStudentFees = StudentFee::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->with(['feeType', 'paymentItems'])
            ->get();

        // Apply credit to expenses first
        $expenses = Expense::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->orderBy('expense_date', 'asc')
            ->get();

        foreach ($expenses as $expense) {
            if ($remainingCredit <= 0) break;

            $due = $expense->amount - $expense->paid_amount;
            $payAmount = min($due, $remainingCredit);

            if ($payAmount > 0) {
                $expense->paid_amount += $payAmount;
                $expense->status = ($expense->paid_amount >= $expense->amount) ? 'paid' : 'partial';
                $expense->save();

                PaymentItem::create([
                    'payment_id' => $paymentId,
                    'expense_id' => $expense->id,
                    'student_fee_id' => null,
                    'paid_amount' => $payAmount,
                    'is_advance' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $remainingCredit -= $payAmount;
                $totalCreditUsed += $payAmount;
                
                Log::info("Applied credit to expense: {$expense->id}, Amount: {$payAmount}");
            }
        }

        // Apply credit to admission fee
        $admissionFeeType = FeeType::where('name', 'LIKE', '%admission%')->first();
        if ($admissionFeeType && $remainingCredit > 0) {
            $admissionFee = $realStudentFees
                ->where('fee_type_id', $admissionFeeType->id)
                ->whereIn('status', ['unpaid', 'partial'])
                ->first();

            if ($admissionFee) {
                $alreadyPaid = $admissionFee->paymentItems->sum('paid_amount');
                $due = $admissionFee->amount - $alreadyPaid;
                $payAmount = min($due, $remainingCredit);

                if ($payAmount > 0) {
                    // Create payment item first
                    PaymentItem::create([
                        'payment_id' => $paymentId,
                        'student_fee_id' => $admissionFee->id,
                        'expense_id' => null,
                        'paid_amount' => $payAmount,
                        'is_advance' => false,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // Then update the student fee
                    $admissionFee->updatePaidAmount();

                    $remainingCredit -= $payAmount;
                    $totalCreditUsed += $payAmount;
                    
                    Log::info("Applied credit to admission fee: {$admissionFee->id}, Amount: {$payAmount}");
                }
            }
        }

        // Apply credit to monthly fees (oldest first) - THESE NOW HAVE PRO-RATA AMOUNTS
        $monthlyFeeType = FeeType::where('name', 'LIKE', '%monthly%')->first();
        if ($monthlyFeeType && $remainingCredit > 0) {
            $monthlyFees = $realStudentFees
                ->where('fee_type_id', $monthlyFeeType->id)
                ->whereIn('status', ['unpaid', 'partial'])
                ->sortBy(function($fee) {
                    return $fee->year * 100 + $fee->month;
                });

            foreach ($monthlyFees as $fee) {
                if ($remainingCredit <= 0) break;

                $alreadyPaid = $fee->paymentItems->sum('paid_amount');
                $due = $fee->amount - $alreadyPaid; // This now uses pro-rata amount
                $payAmount = min($due, $remainingCredit);

                if ($payAmount > 0) {
                    // Create payment item
                    PaymentItem::create([
                        'payment_id' => $paymentId,
                        'student_fee_id' => $fee->id,
                        'expense_id' => null,
                        'paid_amount' => $payAmount,
                        'is_advance' => false,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // Update student fee
                    $fee->updatePaidAmount();

                    $remainingCredit -= $payAmount;
                    $totalCreditUsed += $payAmount;
                    
                    Log::info("Applied credit to monthly fee: {$fee->id}, Month: {$fee->month}/{$fee->year}, Pro-rata Amount: {$fee->amount}, Paid: {$payAmount}, Due: {$due}");
                }
            }
        }

        // Apply credit to other fees
        $otherFees = $realStudentFees
            ->whereNotIn('fee_type_id', [$admissionFeeType?->id, $monthlyFeeType?->id])
            ->whereIn('status', ['unpaid', 'partial']);

        foreach ($otherFees as $fee) {
            if ($remainingCredit <= 0) break;

            $alreadyPaid = $fee->paymentItems->sum('paid_amount');
            $due = $fee->amount - $alreadyPaid;
            $payAmount = min($due, $remainingCredit);

            if ($payAmount > 0) {
                // Create payment item
                PaymentItem::create([
                    'payment_id' => $paymentId,
                    'student_fee_id' => $fee->id,
                    'expense_id' => null,
                    'paid_amount' => $payAmount,
                    'is_advance' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update student fee
                $fee->updatePaidAmount();

                $remainingCredit -= $payAmount;
                $totalCreditUsed += $payAmount;
                
                Log::info("Applied credit to other fee: {$fee->id}, Amount: {$payAmount}");
            }
        }

        Log::info("Total credit used: {$totalCreditUsed}, Remaining: {$remainingCredit}");
        return $totalCreditUsed;
    }

    /**
     * Calculate total due amount for student
     */
    private function calculateTotalDueAmount(Student $student)
    {
        // Calculate fees due (remaining amounts) - these now use pro-rata amounts
        $fees = StudentFee::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->with('paymentItems')
            ->get();
        
        $totalFeesDue = $fees->sum(function($fee) {
            $paidAmount = $fee->paymentItems->sum('paid_amount');
            return $fee->amount - $paidAmount; // This uses pro-rata amount
        });
        
        // Calculate expenses due (remaining amounts)
        $expenses = Expense::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->get();
        
        $totalExpensesDue = $expenses->sum(function($expense) {
            return $expense->amount - $expense->paid_amount;
        });
        
        $totalDue = $totalFeesDue + $totalExpensesDue;
        
        Log::info("Due calculation - Student: {$student->id}, Fees Due: {$totalFeesDue}, Expenses Due: {$totalExpensesDue}, Total Due: {$totalDue}");
        
        return $totalDue;
    }

    /**
     * Create invoice for payment
     */
    private function createInvoiceForPayment(Student $student, Payment $payment, $appliedAmount)
    {
        // Create or get active invoice
        $invoice = Invoice::where('student_id', $student->id)
            ->where('status', 'unpaid')
            ->first();

        if (!$invoice) {
            $invoice = Invoice::create([
                'invoice_no' => 'INV-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'student_id' => $student->id,
                'invoice_date' => now(),
                'total_amount' => 0,
                'paid_amount' => 0,
                'due_amount' => 0,
                'status' => 'unpaid'
            ]);
        }

        // Get all paid fees from this payment
        $paidFees = PaymentItem::where('payment_id', $payment->id)
            ->where('is_advance', false)
            ->whereNotNull('student_fee_id')
            ->with('studentFee.feeType')
            ->get();

        // Add invoice items for paid fees
        foreach ($paidFees as $paymentItem) {
            if ($paymentItem->studentFee) {
                // Check if invoice item already exists
                $existingItem = InvoiceItem::where('invoice_id', $invoice->id)
                    ->where('student_fee_id', $paymentItem->student_fee_id)
                    ->first();

                if (!$existingItem) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'student_fee_id' => $paymentItem->student_fee_id,
                        'fee_type_id' => $paymentItem->studentFee->fee_type_id,
                        'amount' => $paymentItem->studentFee->amount, // This is the pro-rata amount
                        'description' => $paymentItem->studentFee->feeType->name . 
                            ($paymentItem->studentFee->month ? 
                                ' (' . date('M Y', mktime(0, 0, 0, $paymentItem->studentFee->month, 1, $paymentItem->studentFee->year)) . ')' 
                                : '')
                    ]);
                }
            }
        }

        // Update invoice amounts
        $totalAmount = InvoiceItem::where('invoice_id', $invoice->id)->sum('amount');
        $paidAmount = $invoice->paid_amount + $appliedAmount;
        $dueAmount = max(0, $totalAmount - $paidAmount);

        $invoice->update([
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'due_amount' => $dueAmount,
            'status' => $dueAmount <= 0 ? 'paid' : ($paidAmount > 0 ? 'partial' : 'unpaid')
        ]);

        return $invoice;
    }

    /**
     * Generate remarks based on payment breakdown
     */
    private function generateRemarks($originalRemarks, $creditUsed, $paymentForDues, $newAdvance)
    {
        $remarks = $originalRemarks ?: '';
        
        if ($creditUsed > 0) {
            $remarks .= ($remarks ? ' | ' : '') . "Used advance: Rs. " . number_format($creditUsed, 2);
        }
        
        if ($paymentForDues > 0) {
            $remarks .= ($remarks ? ' | ' : '') . "Payment for dues: Rs. " . number_format($paymentForDues, 2);
        }
        
        if ($newAdvance > 0) {
            $remarks .= ($remarks ? ' | ' : '') . "New advance: Rs. " . number_format($newAdvance, 2);
        }
        
        return $remarks;
    }

    /**
     * Generate success message
     */
    private function generateSuccessMessage($creditUsed, $paymentForDues, $newAdvance, $finalBalance)
    {
        $message = 'Payment processed successfully!';
        
        if ($creditUsed > 0) {
            $message .= " Used Rs. " . number_format($creditUsed, 2) . " from advance balance.";
        }
        
        if ($paymentForDues > 0) {
            $message .= " Rs. " . number_format($paymentForDues, 2) . " applied to dues.";
        }
        
        if ($newAdvance > 0) {
            $message .= " Rs. " . number_format($newAdvance, 2) . " saved as new advance.";
        }
        
        $message .= " Final advance balance: Rs. " . number_format($finalBalance, 2);
        
        return $message;
    }

    /**
     * Show a single global payment
     */
    public function show($id)
    {
        $payment = Payment::with([
            'student.classModel',
            'paymentItems.studentFee.feeType',
            'paymentItems.expense.expenseType'
        ])->findOrFail($id);

        // Simple calculations
        $advanceAdded = $payment->paymentItems->where('is_advance', true)->sum('paid_amount');
        $amountAppliedToDues = $payment->paymentItems->where('is_advance', false)->sum('paid_amount');
        
        // Estimate advance used from remarks
        $advanceUsed = 0;
        if ($payment->remarks && (str_contains($payment->remarks, 'advance') || str_contains($payment->remarks, 'Advance'))) {
            preg_match('/Rs?\.[\s]*([0-9,]+(\.[0-9]{2})?)/', $payment->remarks, $matches);
            if (isset($matches[1])) {
                $advanceUsed = (float) str_replace(',', '', $matches[1]);
            }
        }
        
        // Calculate current remaining amounts
        $remainingAfterPayment = $this->calculateRemainingAfterPayment($payment);
        
        // Estimate due before payment (current remaining + this payment's dues amount)
        $dueBeforePayment = [
            'fees' => $remainingAfterPayment['fees'] + $payment->paymentItems->where('student_fee_id', '!=', null)->sum('paid_amount'),
            'expenses' => $remainingAfterPayment['expenses'] + $payment->paymentItems->where('expense_id', '!=', null)->sum('paid_amount'),
            'total' => $remainingAfterPayment['total'] + $amountAppliedToDues,
            'advance_balance' => $payment->student->balance + $advanceUsed - $advanceAdded
        ];
        
        return view('payments.global.show', compact(
            'payment',
            'dueBeforePayment',
            'remainingAfterPayment',
            'amountAppliedToDues',
            'advanceAdded',
            'advanceUsed'
        ));
    }

    /**
     * Calculate remaining amounts after this payment
     */
    private function calculateRemainingAfterPayment(Payment $payment)
    {
        $student = $payment->student;
        
        // Get current due amounts (remaining amounts for unpaid/partial items)
        $currentFeesDue = StudentFee::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->get()
            ->sum(function($fee) {
                return $fee->amount - $fee->paid_amount; // This uses pro-rata amount
            });
        
        $currentExpensesDue = Expense::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->get()
            ->sum(function($expense) {
                return $expense->amount - $expense->paid_amount;
            });
        
        return [
            'fees' => $currentFeesDue,
            'expenses' => $currentExpensesDue,
            'total' => $currentFeesDue + $currentExpensesDue,
            'advance_balance' => $student->balance
        ];
    }
}