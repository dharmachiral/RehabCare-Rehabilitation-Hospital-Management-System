<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Student\Entities\Payment;
use Modules\Student\Entities\Expense;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class FinanceSummaryController extends Controller
{
    public function index(Request $request)
    {
        // Default filter: today
        $filter = $request->get('filter', 'today');

        $startDate = null;
        $endDate = null;

        // Apply date filters
        switch ($filter) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::now();
                break;

            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;

            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;

            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;

            case 'custom':
                $startDate = Carbon::parse($request->start_date);
                $endDate = Carbon::parse($request->end_date);
                break;

            default:
                $startDate = Carbon::today();
                $endDate = Carbon::now();
                break;
        }

        // Fetch data
        $payments = Payment::whereBetween('payment_date', [$startDate, $endDate])->get();
        $expenses = Expense::whereBetween('expense_date', [$startDate, $endDate])->get();

        // Calculate totals
        $totalIncome = $payments->sum('total_amount');
        $totalExpense = $expenses->sum('amount');
        $remaining = $totalIncome - $totalExpense;

        return view('student::finance.summary', compact(
            'filter',
            'startDate',
            'endDate',
            'payments',
            'expenses',
            'totalIncome',
            'totalExpense',
            'remaining'
        ));
    }
}
