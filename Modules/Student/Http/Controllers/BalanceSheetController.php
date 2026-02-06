<?php

namespace Modules\Student\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Student\Entities\Payment;
use Modules\Student\Entities\Expense;
use Modules\Student\Entities\Deposit;

class BalanceSheetController extends Controller
{
   public function index()
{
    $totalCash = Payment::where('payment_method', 'cash')->sum('total_amount');
    $totalExpenses = Expense::sum('amount');
    $totalDeposits = Deposit::sum('amount');
    $cashInHand = $totalCash - $totalExpenses - $totalDeposits;

    $deposits = Deposit::latest()->get(); // 👈 added

    return view('student::balancesheet.index', compact(
        'totalCash',
        'totalExpenses',
        'cashInHand',
        'totalDeposits',
        'deposits'
    ));
}

    public function storeDeposit(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'deposited_by' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'receipt' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('receipt')) {
            $data['receipt'] = $request->file('receipt')->store('receipts', 'public');
        }

        Deposit::create($data);

        return redirect()->back()->with('success', 'Cash successfully deposited to bank.');
    }
}
