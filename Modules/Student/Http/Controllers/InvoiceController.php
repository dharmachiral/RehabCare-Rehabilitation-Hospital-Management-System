<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Student\Entities\Invoice;
use Modules\Student\Entities\InvoiceItem;
use Modules\Student\Entities\Payment;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['student', 'items'])
            ->latest()
            ->paginate(20);
            
        return view('student::invoices.index', compact('invoices'));
    }

    public function show($id)
    {
        $invoice = Invoice::with([
            'student.classModel',
            'items.feeType',
            'items.studentFee'
        ])->findOrFail($id);

        // Get related payments for this invoice
        $relatedPayments = Payment::whereHas('paymentItems.studentFee.invoiceItems', function($query) use ($id) {
            $query->where('invoice_id', $id);
        })->with(['paymentItems.studentFee.feeType'])->get();

        return view('student::invoices.show', compact('invoice', 'relatedPayments'));
    }

    public function print($id)
    {
        $invoice = Invoice::with([
            'student.classModel',
            'items.feeType',
            'items.studentFee'
        ])->findOrFail($id);

        $relatedPayments = Payment::whereHas('paymentItems.studentFee.invoiceItems', function($query) use ($id) {
            $query->where('invoice_id', $id);
        })->with(['paymentItems.studentFee.feeType'])->get();

        return view('student::invoices.show', compact('invoice', 'relatedPayments'))->with('print', true);
    }

    /**
     * Generate receipt for payment
     */
    public function generateReceipt($payment_id)
    {
        $payment = Payment::with([
            'student.classModel', 
            'paymentItems.studentFee.feeType',
            'paymentItems.expense.expenseType'
        ])->findOrFail($payment_id);

        return view('student::payments.receipt', compact('payment'));
    }
}