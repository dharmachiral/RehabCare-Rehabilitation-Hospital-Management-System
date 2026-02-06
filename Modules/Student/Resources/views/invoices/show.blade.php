@extends('setting::layouts.master')

@section('title', 'Invoice')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoices</a></li>
                        <li class="breadcrumb-item active">#{{ $invoice->invoice_no }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Invoice Details</h3>
                        <div class="card-tools">
                            <button onclick="window.print()" class="btn btn-sm btn-secondary">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Invoice Header --}}
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h2 class="m-0">
                                    <i class="fas fa-receipt"></i> INVOICE
                                </h2>
                                <p class="text-muted">#{{ $invoice->invoice_no }}</p>
                            </div>
                            <div class="col-sm-6 text-right">
                                <p class="mb-1"><strong>Date:</strong> {{ date('d M Y', strtotime($invoice->invoice_date)) }}</p>
                                <span class="badge 
                                    @if($invoice->status == 'paid') badge-success
                                    @elseif($invoice->status == 'partial') badge-warning
                                    @else badge-secondary @endif">
                                    {{ strtoupper($invoice->status) }}
                                </span>
                            </div>
                        </div>

                        {{-- Student Information --}}
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h5>Bill To:</h5>
                                <address>
                                    <strong>{{ $invoice->student->full_name }}</strong><br>
                                    @if($invoice->student->parent_name)
                                        Parent: {{ $invoice->student->parent_name }}<br>
                                    @endif
                                    @if($invoice->student->phone)
                                        Phone: {{ $invoice->student->phone }}<br>
                                    @endif
                                    Class: {{ $invoice->student->classModel->class_name ?? 'N/A' }}<br>
                                    Roll No: {{ $invoice->student->roll_no ?? 'N/A' }}
                                </address>
                            </div>
                            <div class="col-sm-6 text-right">
                                <h5>Payment Summary:</h5>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Total Amount:</strong></td>
                                        <td class="text-right">Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Paid Amount:</strong></td>
                                        <td class="text-right text-success">Rs. {{ number_format($invoice->paid_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Due Amount:</strong></td>
                                        <td class="text-right text-danger">Rs. {{ number_format($invoice->due_amount, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- Invoice Items --}}
                        <div class="table-responsive">
                            <h5>Invoice Items</h5>
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Fee Type</th>
                                        <th>Description</th>
                                        <th class="text-right">Amount (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($invoice->items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->feeType->name ?? 'N/A' }}</td>
                                            <td>{{ $item->description ?? 'Fee Payment' }}</td>
                                            <td class="text-right">{{ number_format($item->amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No invoice items found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th colspan="3" class="text-right">Total Amount:</th>
                                        <th class="text-right">Rs. {{ number_format($invoice->total_amount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-right">Paid Amount:</th>
                                        <th class="text-right text-success">Rs. {{ number_format($invoice->paid_amount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-right">Due Amount:</th>
                                        <th class="text-right text-danger">Rs. {{ number_format($invoice->due_amount, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Related Payments --}}
                        @php
                            // Get payments related to this invoice through payment items
                            $relatedPayments = \Modules\Student\Entities\Payment::whereHas('paymentItems.studentFee', function($query) use ($invoice) {
                                $query->whereHas('invoiceItems', function($q) use ($invoice) {
                                    $q->where('invoice_id', $invoice->id);
                                });
                            })->with(['paymentItems.studentFee.feeType'])->get();
                        @endphp

                        @if($relatedPayments->count() > 0)
                        <div class="mt-5">
                            <h5>Payment History</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Payment Date</th>
                                            <th>Payment Method</th>
                                            <th>Receipt No</th>
                                            <th>Description</th>
                                            <th class="text-right">Amount (Rs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($relatedPayments as $payment)
                                            @foreach($payment->paymentItems as $index => $paymentItem)
                                                @if($paymentItem->studentFee && $paymentItem->studentFee->invoiceItems->where('invoice_id', $invoice->id)->count() > 0)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ date('d M Y', strtotime($payment->payment_date)) }}</td>
                                                    <td>
                                                        <span class="badge badge-info">
                                                            {{ ucfirst($payment->payment_method) }}
                                                        </span>
                                                    </td>
                                                    <td>#{{ $payment->id }}</td>
                                                    <td>
                                                        {{ $paymentItem->studentFee->feeType->name ?? 'Fee Payment' }}
                                                        @if($payment->remarks)
                                                            <br><small class="text-muted">{{ $payment->remarks }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-right text-success">
                                                        + {{ number_format($paymentItem->paid_amount, 2) }}
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-right">Total Paid:</th>
                                            <th class="text-right text-success">
                                                Rs. {{ number_format($invoice->paid_amount, 2) }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        @endif

                        {{-- Payment Instructions --}}
                        <div class="mt-4">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Payment Instructions</h6>
                                <p class="mb-1">
                                    <strong>Payment Methods:</strong> Cash, Bank Transfer, Cheque, Online Payment<br>
                                    <strong>Due Date:</strong> Please make payment by {{ date('d M Y', strtotime('+15 days', strtotime($invoice->invoice_date))) }}<br>
                                    <strong>Contact:</strong> For payment queries, please contact the administration office.
                                </p>
                            </div>
                        </div>

                        {{-- Terms and Conditions --}}
                        <div class="mt-4 pt-4 border-top">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h6>Terms & Conditions:</h6>
                                    <ul class="small text-muted pl-3 mb-0">
                                        <li>Payments are due within 15 days of invoice date</li>
                                        <li>Late payments may incur additional charges</li>
                                        <li>Receipts will be issued upon payment completion</li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <p class="mb-1"><strong>Generated On:</strong> {{ date('d M Y, h:i A') }}</p>
                                    <p class="small text-muted mb-0">Thank you for your business!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Card Footer --}}
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-6">
                                @if($invoice->due_amount > 0)
                                    <a href="{{ route('payments.create.for.student', $invoice->student_id) }}" 
                                       class="btn btn-success">
                                        <i class="fas fa-credit-card"></i> Make Payment
                                    </a>
                                @else
                                    <span class="text-success">
                                        <i class="fas fa-check-circle"></i> This invoice is fully paid
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="{{ route('invoices.index') }}" class="btn btn-default">
                                    <i class="fas fa-arrow-left"></i> Back to Invoices
                                </a>
                                <button onclick="window.print()" class="btn btn-primary">
                                    <i class="fas fa-print"></i> Print Invoice
                                </button>
                                @if($invoice->due_amount > 0)
                                    <a href="{{ route('invoices.send.reminder', $invoice->id) }}" class="btn btn-info">
                                        <i class="fas fa-envelope"></i> Send Reminder
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .card-header, .card-footer, .btn, .alert {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .card-body {
            padding: 0 !important;
        }
        .table {
            border-collapse: collapse !important;
        }
        .table th, .table td {
            border: 1px solid #dee2e6 !important;
            padding: 8px !important;
        }
        .badge {
            border: 1px solid #000 !important;
            color: #000 !important;
            background: transparent !important;
        }
    }
    
    .invoice-header {
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    
    address {
        font-style: normal;
        line-height: 1.6;
    }
    
    .table th {
        background-color: #f8f9fa !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add print functionality
        window.printInvoice = function() {
            window.print();
        };
        
        // Auto-print if needed (you can add a parameter to trigger this)
        @if(request()->has('print'))
            window.print();
        @endif
    });
</script>
@endpush