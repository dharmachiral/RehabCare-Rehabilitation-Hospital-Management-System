@extends('setting::layouts.master')
@section('title', 'Payment Details')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Payment #{{ $payment->id }}</h3>
                <div class="card-tools">
                    <a href="{{ route('payments.receipt', $payment->id) }}" class="btn btn-sm btn-success" target="_blank">
                        <i class="fa fa-receipt"></i> Generate Receipt
                    </a>
                </div>
            </div>
            <div class="card-body">
                
                <!-- ====== PAYMENT SUMMARY CARD ====== -->
                <div class="card bg-light mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-chart-bar"></i> Payment Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Due Before Payment -->
                            <div class="col-md-3 mb-3">
                                <div class="border rounded p-3 text-center bg-white">
                                    <h6 class="text-muted mb-2">Due Before Payment</h6>
                                    <h4 class="text-danger mb-1">Rs. {{ number_format($dueBeforePayment['total'] ?? 0, 2) }}</h4>
                                    <small class="text-muted">
                                        Fees: Rs. {{ number_format($dueBeforePayment['fees'] ?? 0, 2) }}<br>
                                        Expenses: Rs. {{ number_format($dueBeforePayment['expenses'] ?? 0, 2) }}
                                    </small>
                                </div>
                            </div>
                            
                            <!-- This Payment -->
                            <div class="col-md-3 mb-3">
                                <div class="border rounded p-3 text-center bg-white">
                                    <h6 class="text-muted mb-2">This Payment</h6>
                                    <h4 class="text-success mb-1">Rs. {{ number_format($payment->total_amount, 2) }}</h4>
                                    <small class="text-muted">
                                        To Dues: Rs. {{ number_format($amountAppliedToDues, 2) }}<br>
                                        To Advance: Rs. {{ number_format($advanceAdded, 2) }}
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Advance Used -->
                            @if($advanceUsed > 0)
                            <div class="col-md-3 mb-3">
                                <div class="border rounded p-3 text-center bg-warning text-dark">
                                    <h6 class="mb-2">Advance Used</h6>
                                    <h4 class="mb-1">Rs. {{ number_format($advanceUsed, 2) }}</h4>
                                    <small>
                                        From advance balance
                                    </small>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Remaining After Payment -->
                            <div class="col-md-3 mb-3">
                                <div class="border rounded p-3 text-center bg-white">
                                    <h6 class="text-muted mb-2">Remaining After Payment</h6>
                                    <h4 class="{{ $remainingAfterPayment['total'] > 0 ? 'text-warning' : 'text-success' }} mb-1">
                                        Rs. {{ number_format($remainingAfterPayment['total'], 2) }}
                                    </h4>
                                    <small class="text-muted">
                                        @if($remainingAfterPayment['total'] > 0)
                                            Still Due
                                        @else
                                            All Cleared ✅
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Advance Balance Summary -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info mb-0">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Advance Balance:</strong> 
                                            Rs. {{ number_format($remainingAfterPayment['advance_balance'], 2) }}
                                        </div>
                                        <div class="col-md-4">
                                            @if($advanceUsed > 0)
                                                <strong>Advance Used:</strong> 
                                                Rs. {{ number_format($advanceUsed, 2) }}
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            @if($advanceAdded > 0)
                                                <strong>New Advance Added:</strong> 
                                                Rs. {{ number_format($advanceAdded, 2) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><strong>Student:</strong> {{ $payment->student->full_name }}</h5>
                        <p><strong>Class:</strong> {{ $payment->student->classModel->class_name ?? 'N/A' }}</p>
                        <p><strong>Date:</strong> {{ date('d M Y, h:i A', strtotime($payment->payment_date)) }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p><strong>Method:</strong> <span class="badge badge-info">{{ ucfirst($payment->payment_method) }}</span></p>
                        <p><strong>Total Amount:</strong> <span class="text-success">Rs. {{ number_format($payment->total_amount, 2) }}</span></p>
                        <p><strong>Status:</strong> <span class="badge badge-success">{{ ucfirst($payment->status) }}</span></p>
                    </div>
                </div>

                @if($payment->remarks)
                <div class="alert alert-secondary">
                    <strong>Remarks:</strong> {{ $payment->remarks }}
                </div>
                @endif

                <!-- ====== PAYMENT BREAKDOWN ====== -->
                <h5><i class="fas fa-list-alt"></i> Payment Breakdown</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Period/Date</th>
                                <th class="text-right">Original Amount (Rs)</th>
                                <th class="text-right">Paid Amount (Rs)</th>
                                <th class="text-right">Remaining (Rs)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $totalPaid = 0;
                                $totalOriginal = 0;
                                $totalRemaining = 0;
                            @endphp
                            
                            @foreach($payment->paymentItems as $index => $item)
                                @php 
                                    $totalPaid += $item->paid_amount;
                                    
                                    // Calculate original amount and remaining
                                    if ($item->is_advance) {
                                        $originalAmount = 0;
                                        $remainingAmount = 0;
                                    } elseif ($item->studentFee) {
                                        $originalAmount = $item->studentFee->amount;
                                        $remainingAmount = $originalAmount - $item->studentFee->paid_amount;
                                        $totalOriginal += $originalAmount;
                                        $totalRemaining += $remainingAmount;
                                    } elseif ($item->expense) {
                                        $originalAmount = $item->expense->amount;
                                        $remainingAmount = $originalAmount - $item->expense->paid_amount;
                                        $totalOriginal += $originalAmount;
                                        $totalRemaining += $remainingAmount;
                                    } else {
                                        $originalAmount = $item->paid_amount;
                                        $remainingAmount = 0;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($item->is_advance)
                                            <span class="badge badge-warning">Advance</span>
                                        @elseif($item->isAdmissionFee())
                                            <span class="badge badge-success">Admission</span>
                                        @elseif($item->student_fee_id)
                                            <span class="badge badge-primary">Monthly Fee</span>
                                        @elseif($item->expense_id)
                                            <span class="badge badge-info">Expense</span>
                                        @else
                                            <span class="badge badge-secondary">Other</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_advance)
                                            <strong>Advance Payment</strong>
                                            <br><small class="text-muted">For future payments</small>
                                        @elseif($item->studentFee && $item->studentFee->feeType)
                                            <strong>{{ $item->studentFee->feeType->name }}</strong>
                                            @if($item->isAdmissionFee())
                                                <br><small class="text-muted">One-time admission fee</small>
                                            @else
                                                <br><small class="text-muted">Monthly fee payment</small>
                                            @endif
                                        @elseif($item->expense && $item->expense->expenseType)
                                            <strong>{{ $item->expense->expenseType->name }}</strong>
                                            @if($item->expense->description)
                                                <br><small class="text-muted">{{ $item->expense->description }}</small>
                                            @endif
                                        @else
                                            <strong>Payment Item</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_advance)
                                            <small class="text-muted">-</small>
                                        @elseif($item->studentFee && $item->studentFee->month && $item->studentFee->year)
                                            <small class="text-muted">
                                                {{ date('F Y', mktime(0, 0, 0, $item->studentFee->month, 1, $item->studentFee->year)) }}
                                            </small>
                                        @elseif($item->expense && $item->expense->expense_date)
                                            <small class="text-muted">
                                                {{ date('d M Y', strtotime($item->expense->expense_date)) }}
                                            </small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if(!$item->is_advance)
                                            {{ number_format($originalAmount, 2) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-right text-success">
                                        + {{ number_format($item->paid_amount, 2) }}
                                    </td>
                                    <td class="text-right">
                                        @if(!$item->is_advance)
                                            @if($remainingAmount > 0)
                                                <span class="text-warning"><strong>{{ number_format($remainingAmount, 2) }}</strong></span>
                                            @else
                                                <span class="text-success"><strong>0.00</strong></span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_advance)
                                            <span class="badge badge-warning">Advance</span>
                                        @elseif($remainingAmount > 0)
                                            <span class="badge badge-warning">Partial</span>
                                        @else
                                            <span class="badge badge-success">Paid</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            
                            @if(count($payment->paymentItems) === 0)
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">
                                        <i class="fas fa-info-circle"></i> No payment items found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-right">Totals:</th>
                                <th class="text-right">Rs. {{ number_format($totalOriginal, 2) }}</th>
                                <th class="text-right text-success">Rs. {{ number_format($totalPaid, 2) }}</th>
                                <th class="text-right {{ $totalRemaining > 0 ? 'text-warning' : 'text-success' }}">
                                    Rs. {{ number_format($totalRemaining, 2) }}
                                </th>
                                <th>
                                    @if($totalRemaining > 0)
                                        <span class="badge badge-warning">Partial</span>
                                    @else
                                        <span class="badge badge-success">Paid</span>
                                    @endif
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- ====== CURRENT STATUS SUMMARY ====== -->
                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="card-title mb-0"><i class="fas fa-info-circle"></i> Current Status After This Payment</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="border rounded p-3">
                                    <h5 class="text-primary">Advance Balance</h5>
                                    <h3 class="text-info">Rs. {{ number_format($remainingAfterPayment['advance_balance'], 2) }}</h3>
                                    <small class="text-muted">Available for future payments</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="border rounded p-3">
                                    <h5 class="text-primary">Remaining Due</h5>
                                    <h3 class="{{ $remainingAfterPayment['total'] > 0 ? 'text-warning' : 'text-success' }}">
                                        Rs. {{ number_format($remainingAfterPayment['total'], 2) }}
                                    </h3>
                                    <small class="text-muted">
                                        @if($remainingAfterPayment['total'] > 0)
                                            Fees: Rs. {{ number_format($remainingAfterPayment['fees'], 2) }}<br>
                                            Expenses: Rs. {{ number_format($remainingAfterPayment['expenses'], 2) }}
                                        @else
                                            All dues cleared ✅
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="border rounded p-3">
                                    <h5 class="text-primary">Payment Effectiveness</h5>
                                    @if($dueBeforePayment['total'] > 0)
                                        @php
                                            $reductionPercent = (($dueBeforePayment['total'] - $remainingAfterPayment['total']) / $dueBeforePayment['total']) * 100;
                                        @endphp
                                        <h3 class="text-success">{{ number_format($reductionPercent, 1) }}%</h3>
                                        <small class="text-muted">
                                            Due reduction<br>
                                            Rs. {{ number_format($dueBeforePayment['total'] - $remainingAfterPayment['total'], 2) }}
                                        </small>
                                    @else
                                        <h3 class="text-success">100%</h3>
                                        <small class="text-muted">Advance payment added</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($payment->image)
                <div class="mt-4">
                    <h5>Receipt Image</h5>
                    <img src="{{ asset('storage/'.$payment->image) }}" alt="Receipt" class="img-fluid rounded shadow-sm" style="max-width:400px;">
                </div>
                @endif

                <div class="text-end mt-4">
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Payments
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa !important;
        font-weight: 600;
    }
    .badge {
        font-size: 0.75em;
    }
    .card-header {
        border-bottom: 1px solid #dee2e6;
    }
    .border-rounded {
        border-radius: 10px !important;
    }
</style>
@endpush