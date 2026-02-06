@extends('setting::layouts.master')
@section('title', 'Record Payment')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Record Payment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Payment</h3>
                </div>

                <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        {{-- ====== Student Info ====== --}}
                        @if (isset($student))
                            <div class="alert alert-secondary">
                                <strong>Student:</strong> {{ $student->full_name }}<br>
                                <strong>Class:</strong> {{ $student->classModel->class_name ?? 'N/A' }}<br>
                                <strong>Admission Date:</strong>
                                {{ $student->admission_date ? date('d M Y', strtotime($student->admission_date)) : 'N/A' }}<br>
                                <strong>Admission Fee:</strong> Rs. {{ number_format($student->admission_fee, 2) }}<br>
                                <strong>Monthly Fee:</strong> Rs. {{ number_format($student->monthly_fee, 2) }}/month
                                @if ($student->recover_date)
                                    <br><strong>Recover Date:</strong>
                                    {{ date('d M Y', strtotime($student->recover_date)) }}
                                @endif
                            </div>
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                        @else
                            <div class="mb-3">
                                <label>Select Student</label>
                                <select name="student_id" class="form-control" required>
                                    <option value="">-- Select Student --</option>
                                    @foreach ($students as $s)
                                        <option value="{{ $s->id }}">{{ $s->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        {{-- ====== Student Balance ====== --}}
                        @if (isset($student))
                            <div class="alert alert-info">
                                <strong>Current Balance:</strong>
                                {{ $student->balance >= 0
                                    ? '+ ' . number_format($student->balance, 2) . ' (Credit)'
                                    : number_format($student->balance, 2) . ' (Due)' }}
                            </div>
                        @endif

                        {{-- ====== Available Credit Balance ====== --}}
                        @if (isset($student) && $student->balance > 0 && $totalDueAmount > 0)
                            <div class="alert alert-success">
                                <h6><i class="fas fa-piggy-bank"></i> Available Credit Balance</h6>
                                <p class="mb-2">
                                    This student has <strong>Rs. {{ number_format($student->balance, 2) }}</strong> in
                                    advance payment.
                                    You can use this to pay dues without making a new payment.
                                </p>
                                <div class="text-center">
                                    <a href="{{ route('payments.use.advance.only', $student->id) }}"
                                        class="btn btn-outline-success btn-sm"
                                        onclick="return confirm('Use Rs. {{ number_format(min($student->balance, $totalDueAmount), 2) }} from advance to pay dues?')">
                                        <i class="fas fa-credit-card"></i> Use Advance Balance Only
                                    </a>
                                    <small class="d-block text-muted mt-1">
                                        This will use Rs. {{ number_format(min($student->balance, $totalDueAmount), 2) }}
                                        from advance to pay dues
                                    </small>
                                </div>
                            </div>
                        @endif

                        {{-- ====== EXPENSES TABLE ====== --}}
                        {{-- ====== EXPENSES TABLE ====== --}}
                        @if (isset($expenses) && $expenses->count())
                            <div class="table-responsive mb-4">
                                <h5 class="text-primary"><i class="fas fa-wallet"></i> Unpaid / Pending Expenses</h5>
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Expense Type</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th class="text-right">Original Amount (Rs.)</th>
                                            <th class="text-right">Paid Amount (Rs.)</th>
                                            <th class="text-right">Remaining Amount (Rs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $i => $exp)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $exp->expenseType->name ?? 'Other' }}</td>
                                                <td>{{ date('d M Y', strtotime($exp->expense_date)) }}</td>
                                                <td>{{ $exp->description ?? '-' }}</td>
                                                <td class="text-right">{{ number_format($exp->amount, 2) }}</td>
                                                <td class="text-right text-success">
                                                    {{ number_format($exp->paid_amount, 2) }}</td>
                                                <td class="text-right text-danger">
                                                    <strong>{{ number_format($exp->remaining_amount ?? $exp->amount - $exp->paid_amount, 2) }}</strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light">
                                            <td colspan="5" class="text-right"><strong>Total:</strong></td>
                                            <td class="text-right text-success">
                                                <strong>Rs. {{ number_format($expenses->sum('paid_amount'), 2) }}</strong>
                                            </td>
                                            <td class="text-right text-danger">
                                                <strong>Rs. {{ number_format($totalExpenses, 2) }}</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                        
                        {{-- ====== FEES TABLE ====== --}}
                        @if (isset($fees) && $fees->count())
                            <div class="table-responsive mb-4">
                                <h5 class="text-primary"><i class="fas fa-money-check-alt"></i> Pending Fees
                                    (Auto-distribution)</h5>
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Fee Type</th>
                                            <th>Period</th>
                                            <th>Stay Period</th>
                                            <th class="text-right">Original Amount (Rs.)</th>
                                            <th class="text-right">Paid Amount (Rs.)</th>
                                            <th class="text-right">Remaining Amount (Rs.)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- In the fees table --}}
                                        @foreach ($fees->where('fee_type_id', $admissionFeeType?->id) as $i => $admission)
                                            @php
                                                $remainingAmount =
                                                    $admission->remaining_amount ??
                                                    $admission->amount - $admission->paid_amount;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $admission->feeType->name }}</td>
                                                <td>One-time</td>
                                                <td>-</td>
                                                <td class="text-right">{{ number_format($admission->amount, 2) }}</td>
                                                <td class="text-right text-success">
                                                    {{ number_format($admission->paid_amount, 2) }}</td>
                                                <td class="text-right text-danger">
                                                    <strong>{{ number_format($remainingAmount, 2) }}</strong>
                                                </td>
                                                <td class="text-center">
                                                    @if ($admission->paid_amount >= $admission->amount)
                                                        <span class="badge badge-success">Paid</span>
                                                    @elseif($admission->paid_amount > 0)
                                                        <span class="badge badge-warning">Partial</span>
                                                    @else
                                                        <span class="badge badge-danger">Unpaid</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                       {{-- Monthly Fees (Individual) with Pro-rata --}}
@foreach ($fees->where('fee_type_id', $monthlyFeeType?->id) as $i => $monthlyFee)
    @php
        $proRataData = $monthlyFeeDetails[$monthlyFee->id] ?? [
            'amount' => $student->monthly_fee,
            'days_stayed' => Carbon::create($monthlyFee->year, $monthlyFee->month, 1)->daysInMonth,
            'total_days' => Carbon::create($monthlyFee->year, $monthlyFee->month, 1)->daysInMonth,
            'is_pro_rata' => false,
            'stay_period' => 'Full month',
        ];
        
        // FIXED: Use pro-rata amount for remaining calculation
        $proRataAmount = $proRataData['amount'];
        $remainingAmount = max(0, $proRataAmount - $monthlyFee->paid_amount);
    @endphp
    <tr>
        <td>{{ $fees->where('fee_type_id', $admissionFeeType?->id)->count() + $loop->iteration }}</td>
        <td>{{ $monthlyFee->feeType->name }}</td>
        <td>{{ date('F Y', mktime(0, 0, 0, $monthlyFee->month, 1, $monthlyFee->year)) }}</td>
        <td>
            @if ($proRataData['is_pro_rata'])
                <small class="text-info">
                    <i class="fas fa-calculator"></i>
                    {{ $proRataData['stay_period'] }}<br>
                    ({{ $proRataData['days_stayed'] }}/{{ $proRataData['total_days'] }} days)
                </small>
            @else
                <small class="text-muted">Full month</small>
            @endif
        </td>
        <td class="text-right">
            {{ number_format($proRataAmount, 2) }}
            @if ($proRataData['is_pro_rata'])
                <br><small class="text-muted">
                    <s>Rs. {{ number_format($student->monthly_fee, 2) }}</s>
                </small>
            @endif
        </td>
        <td class="text-right text-success">
            {{ number_format($monthlyFee->paid_amount, 2) }}
        </td>
        <td class="text-right text-danger">
            <strong>{{ number_format($remainingAmount, 2) }}</strong>
        </td>
        <td class="text-center">
            @if ($monthlyFee->paid_amount >= $proRataAmount)
                <span class="badge badge-success">Paid</span>
            @elseif($monthlyFee->paid_amount > 0)
                <span class="badge badge-warning">Partial</span>
            @else
                <span class="badge badge-danger">Unpaid</span>
            @endif
        </td>
    </tr>
@endforeach

@if ($fees->where('fee_type_id', $monthlyFeeType?->id)->count() > 0)
    @php
        // FIXED: Calculate totals using pro-rata amounts
        $totalMonthlyProRataAmount = 0;
        $totalMonthlyPaidAmount = $fees->where('fee_type_id', $monthlyFeeType?->id)->sum('paid_amount');
        $totalMonthlyRemainingAmount = 0;
        
        foreach ($fees->where('fee_type_id', $monthlyFeeType?->id) as $monthlyFee) {
            $proRataData = $monthlyFeeDetails[$monthlyFee->id] ?? ['amount' => $student->monthly_fee];
            $proRataAmount = $proRataData['amount'];
            $totalMonthlyProRataAmount += $proRataAmount;
            $totalMonthlyRemainingAmount += max(0, $proRataAmount - $monthlyFee->paid_amount);
        }
        
        // Calculate what the total would have been without pro-rata
        $totalWithoutProRata = $fees->where('fee_type_id', $monthlyFeeType?->id)->count() * $student->monthly_fee;
        $proRataAdjustment = $totalWithoutProRata - $totalMonthlyProRataAmount;
    @endphp
    
    
@endif

                                        {{-- Other Fees --}}
                                        @foreach ($fees->whereNotIn('fee_type_id', [$admissionFeeType?->id, $monthlyFeeType?->id]) as $i => $otherFee)
                                            @php
                                                $remainingAmount =
                                                    $otherFee->remaining_amount ??
                                                    $otherFee->amount - $otherFee->paid_amount;
                                            @endphp
                                            <tr>
                                                <td>{{ $fees->whereIn('fee_type_id', [$admissionFeeType?->id, $monthlyFeeType?->id])->count() + $loop->iteration }}
                                                </td>
                                                <td>{{ $otherFee->feeType->name }}</td>
                                                <td>One-time</td>
                                                <td>-</td>
                                                <td class="text-right">{{ number_format($otherFee->amount, 2) }}</td>
                                                <td class="text-right text-success">
                                                    {{ number_format($otherFee->paid_amount, 2) }}</td>
                                                <td class="text-right text-danger">
                                                    <strong>{{ number_format($remainingAmount, 2) }}</strong>
                                                </td>
                                                <td class="text-center">
                                                    @if ($otherFee->paid_amount > 0)
                                                        <span class="badge badge-warning">Partial</span>
                                                    @else
                                                        <span class="badge badge-danger">Unpaid</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    @if ($fees->where('fee_type_id', $monthlyFeeType?->id)->count() > 0)
                                        <tfoot>
        <tr class="bg-light">
            <td colspan="4" class="text-right">
                <strong>Total Monthly Fees
                    ({{ $fees->where('fee_type_id', $monthlyFeeType?->id)->count() }} months):</strong>
            </td>
            <td class="text-right">
                <strong>Rs. {{ number_format($totalMonthlyProRataAmount, 2) }}</strong>
            </td>
            <td class="text-right text-success">
                <strong>Rs. {{ number_format($totalMonthlyPaidAmount, 2) }}</strong>
            </td>
            <td class="text-right text-danger">
                <strong>Rs. {{ number_format($totalMonthlyRemainingAmount, 2) }}</strong>
            </td>
            <td></td>
        </tr>
        
        @if ($proRataAdjustment > 0)
            <tr class="bg-light">
                <td colspan="5" class="text-right text-info">
                    <small><i class="fas fa-info-circle"></i> Pro-rata Adjustment:</small>
                </td>
                <td colspan="3" class="text-right text-info">
                    <small>- Rs. {{ number_format($proRataAdjustment, 2) }}</small>
                    <br>
                    <small class="text-muted">
                        (Original: Rs. {{ number_format($totalWithoutProRata, 2) }})
                    </small>
                </td>
            </tr>
        @endif
    </tfoot>
                                    @endif
                                </table>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Pro-rata Calculation:</strong> Monthly fees are calculated based on actual stay
                                    period considering admission date and recover date.
                                </div>
                            </div>
                        @endif

                        {{-- ====== FEE SUMMARY ====== --}}
                        @if (isset($feeSummary) && count($feeSummary) > 0)
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <i class="fas fa-calculator"></i> Fee Summary (Remaining Amounts)
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        {{-- Admission Fee Summary --}}
                                        @if ($feeSummary['admission'] > 0)
                                            <div class="col-md-4 mb-2">
                                                <strong>Admission Fee:</strong>
                                                <span class="float-right">Rs.
                                                    {{ number_format($feeSummary['admission'], 2) }}</span>
                                                <br>
                                                <small class="text-muted">
                                                    Remaining of Rs. {{ number_format($student->admission_fee, 2) }}
                                                </small>
                                            </div>
                                        @endif

                                        {{-- Monthly Fee Summary --}}
                                        @if ($feeSummary['monthly'] > 0)
                                            <div class="col-md-4 mb-2">
                                                <strong>Monthly Fees:</strong>
                                                <span class="float-right">Rs.
                                                    {{ number_format($feeSummary['monthly'], 2) }}</span>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $fees->where('fee_type_id', $monthlyFeeType?->id)->count() }} months
                                                    (Pro-rata applied)
                                                </small>
                                            </div>
                                        @endif

                                        {{-- Other Fees Summary --}}
                                        @if ($feeSummary['other'] > 0)
                                            <div class="col-md-4 mb-2">
                                                <strong>Other Fees:</strong>
                                                <span class="float-right">Rs.
                                                    {{ number_format($feeSummary['other'], 2) }}</span>
                                            </div>
                                        @endif

                                        {{-- Expenses Summary --}}
                                        @if (isset($totalExpenses) && $totalExpenses > 0)
                                            <div class="col-md-4 mb-2">
                                                <strong>Other Expenses:</strong>
                                                <span class="float-right">Rs.
                                                    {{ number_format($totalExpenses, 2) }}</span>
                                            </div>
                                        @endif

                                        {{-- Total Summary --}}
                                        <div class="col-12 mt-2 pt-2 border-top">
                                            <h5 class="mb-0">
                                                <strong>Total Due Amount:</strong>
                                                <span class="float-right text-danger">Rs.
                                                    {{ number_format($totalDueAmount, 2) }}</span>
                                            </h5>
                                            @if (isset($student) && $student->balance > 0)
                                                <div class="mt-1">
                                                    <strong>After Credit (Rs.
                                                        {{ number_format($student->balance, 2) }}):</strong>
                                                    <span class="float-right text-warning">Rs.
                                                        {{ number_format(max(0, $totalDueAmount - $student->balance), 2) }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Pro-rata Information --}}
                                        @if ($monthlyFeeAmount > 0)
                                            <div class="col-12 mt-2 pt-2 border-top">
                                                <h6 class="mb-2"><i class="fas fa-info-circle"></i> Pro-rata Information
                                                </h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small class="text-muted">
                                                            <strong>Monthly Rate:</strong> Rs.
                                                            {{ number_format($student->monthly_fee, 2) }}/month
                                                        </small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted">
                                                            <strong>Calculation:</strong> Based on actual stay days
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- ====== Notes / Description ====== --}}
                        <div class="mb-3">
                            <label>Notes / Description</label>
                            <textarea name="remarks" class="form-control" rows="2"
                                placeholder="Optional description of payment items (e.g., cheque number, transaction ID)">{{ old('remarks') }}</textarea>
                        </div>

                        {{-- ====== Payment Fields ====== --}}
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Total Payment Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="total_amount" class="form-control"
                                    placeholder="Enter payment amount" required min="0.01"
                                    value="{{ old('total_amount') }}" id="payment_amount">
                                <small class="form-text text-muted">
                                    Due Amount: Rs. {{ number_format($totalDueAmount, 2) }}
                                    @if (isset($student) && $student->balance > 0)
                                        <br>Available Credit: Rs. {{ number_format($student->balance, 2) }}
                                        <br>Effective Due: Rs.
                                        {{ number_format(max(0, $totalDueAmount - $student->balance), 2) }}
                                    @endif
                                </small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-control" required>
                                    <option value="">-- Select Method --</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                    <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank
                                        Transfer</option>
                                    <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>
                                        Cheque</option>
                                    <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>
                                        Online Payment</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Receipt Image (optional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="form-text text-muted">
                                    Accepted formats: JPEG, PNG, JPG (Max: 2MB)
                                </small>
                            </div>
                        </div>

                        {{-- ====== Payment Preview ====== --}}
                        <div class="alert alert-info" id="payment_preview" style="display: none;">
                            <h6><i class="fas fa-calculator"></i> Payment Breakdown</h6>
                            <div id="preview_content"></div>
                        </div>

                        {{-- ====== Payment Distribution Info ====== --}}
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle"></i> Important</h6>
                            <p class="mb-0">
                                The system will automatically use your available credit first, then apply your new payment
                                to remaining dues.
                                Any excess amount will be saved as advance payment for future use.
                            </p>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-success" id="submit_btn">
                            <i class="fas fa-credit-card"></i> Process Payment
                        </button>
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
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

        .alert-secondary {
            background-color: #e9ecef;
            border-color: #d6d8db;
        }

        .text-danger {
            font-weight: 600;
        }

        #payment_preview {
            border-left: 4px solid #17a2b8;
        }

        .alert-success {
            border-left: 4px solid #28a745;
        }

        .alert-warning {
            border-left: 4px solid #ffc107;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalAmountInput = document.getElementById('payment_amount');
            const paymentPreview = document.getElementById('payment_preview');
            const previewContent = document.getElementById('preview_content');
            const submitBtn = document.getElementById('submit_btn');
            const totalDueAmount = {{ $totalDueAmount ?? 0 }};
            const studentBalance = {{ $student->balance ?? 0 }};

            const creditToUse = Math.min(studentBalance, totalDueAmount);
            const remainingAfterCredit = Math.max(0, totalDueAmount - creditToUse);

            if (totalAmountInput.value) {
                updatePaymentPreview(parseFloat(totalAmountInput.value));
            }

            if (totalAmountInput) {
                totalAmountInput.addEventListener('input', function() {
                    const enteredAmount = parseFloat(this.value) || 0;
                    updatePaymentPreview(enteredAmount);
                });

                totalAmountInput.addEventListener('change', function() {
                    const enteredAmount = parseFloat(this.value) || 0;
                    if (enteredAmount <= 0) {
                        alert('Payment amount must be greater than 0.');
                        this.value = '';
                        paymentPreview.style.display = 'none';
                        return;
                    }
                    updatePaymentPreview(enteredAmount);
                });

                totalAmountInput.focus();
            }

          function updatePaymentPreview(enteredAmount) {
    if (enteredAmount <= 0) {
        paymentPreview.style.display = 'none';
        return;
    }

    let breakdown = '';
    
    // Corrected calculation - SIMPLIFIED
    const creditToUse = Math.min(studentBalance, totalDueAmount);
    const remainingDueAfterCredit = Math.max(0, totalDueAmount - creditToUse);
    const amountForDues = Math.min(enteredAmount, remainingDueAfterCredit);
    const newAdvance = enteredAmount - amountForDues; // FIXED: Simple subtraction
    const remainingCredit = studentBalance - creditToUse + newAdvance;

    breakdown += `<div class="row"><div class="col-md-6">`;
    breakdown += `<p><strong>New Payment:</strong><br>Rs. ${enteredAmount.toFixed(2)}</p>`;
    breakdown += `<p><strong>Available Credit:</strong><br>Rs. ${studentBalance.toFixed(2)}</p>`;
    breakdown += `</div><div class="col-md-6">`;
    breakdown += `<p><strong>Credit Used:</strong><br>Rs. ${creditToUse.toFixed(2)}</p>`;

    if (newAdvance > 0) {
        breakdown += `<p class="text-success"><strong>New Advance:</strong><br>Rs. ${newAdvance.toFixed(2)}</p>`;
    }
    breakdown += `</div></div>`;

    breakdown += `<div class="mt-2 p-2 bg-light rounded">`;
    if (creditToUse > 0) {
        breakdown += `<p class="mb-1"><i class="fas fa-credit-card"></i> <strong>Rs. ${creditToUse.toFixed(2)}</strong> will be used from your advance balance</p>`;
    }
    if (amountForDues > 0) {
        breakdown += `<p class="mb-1"><i class="fas fa-money-bill-wave"></i> <strong>Rs. ${amountForDues.toFixed(2)}</strong> from new payment will cover remaining dues</p>`;
    }
    if (newAdvance > 0) {
        breakdown += `<p class="mb-1 text-success"><i class="fas fa-piggy-bank"></i> <strong>Rs. ${newAdvance.toFixed(2)}</strong> will be added to your advance balance</p>`;
    }
    breakdown += `<p class="mb-0"><i class="fas fa-balance-scale"></i> <strong>Final Advance Balance:</strong> Rs. ${remainingCredit.toFixed(2)}</p>`;
    breakdown += `</div>`;

    // Check if payment covers all dues
    const totalCovered = creditToUse + amountForDues;
    if (totalCovered < totalDueAmount) {
        breakdown += `<div class="mt-2 p-2 bg-warning rounded">`;
        breakdown += `<p class="text-warning mb-0"><i class="fas fa-exclamation-triangle"></i> <strong>Partial Payment:</strong> This will not cover all due amounts. Remaining due: Rs. ${(totalDueAmount - totalCovered).toFixed(2)}</p>`;
        breakdown += `</div>`;
    }

    if (totalCovered >= totalDueAmount) {
        breakdown += `<div class="mt-2 p-2 bg-success rounded">`;
        breakdown += `<p class="text-success mb-0"><i class="fas fa-check-circle"></i> This payment will fully cover all due amounts</p>`;
        breakdown += `</div>`;
    }

    previewContent.innerHTML = breakdown;
    paymentPreview.style.display = 'block';
}

            const paymentMethodSelect = document.querySelector('select[name="payment_method"]');
            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', function() {
                    if (this.value === 'cheque') {
                        const remarks = document.querySelector('textarea[name="remarks"]');
                        if (remarks && !remarks.value) {
                            remarks.placeholder =
                                "Please enter cheque number, bank name, and cheque date...";
                        }
                    } else if (this.value === 'online') {
                        const remarks = document.querySelector('textarea[name="remarks"]');
                        if (remarks && !remarks.value) {
                            remarks.placeholder =
                            "Please enter transaction ID, bank reference, and date...";
                        }
                    }
                });
            }

          const paymentForm = document.querySelector('form');
if (paymentForm) {
    paymentForm.addEventListener('submit', function(e) {
        const totalAmount = parseFloat(totalAmountInput.value) || 0;
        const paymentMethod = paymentMethodSelect.value;

        if (totalAmount <= 0) {
            e.preventDefault();
            alert('Please enter a valid payment amount.');
            totalAmountInput.focus();
            return;
        }

        if (!paymentMethod) {
            e.preventDefault();
            alert('Please select a payment method.');
            paymentMethodSelect.focus();
            return;
        }

        if ((paymentMethod === 'cheque' || paymentMethod === 'online') && !document
            .querySelector('textarea[name="remarks"]').value.trim()) {
            e.preventDefault();
            alert(`Please enter details in the remarks section for ${paymentMethod} payment.`);
            document.querySelector('textarea[name="remarks"]').focus();
            return;
        }

        // FIXED: Correct calculation for confirmation message
        const creditToUse = Math.min(studentBalance, totalDueAmount);
        const remainingDueAfterCredit = Math.max(0, totalDueAmount - creditToUse);
        const amountForDues = Math.min(totalAmount, remainingDueAfterCredit);
        const newAdvance = totalAmount - amountForDues;
        const finalBalance = studentBalance - creditToUse + newAdvance;

        let confirmMessage = `Payment Summary:\n\n`;
        confirmMessage += `• New Payment: Rs. ${totalAmount.toFixed(2)}\n`;
        confirmMessage += `• Credit Used: Rs. ${creditToUse.toFixed(2)}\n`;
        confirmMessage += `• Applied to Dues: Rs. ${amountForDues.toFixed(2)}\n`;

        if (newAdvance > 0) {
            confirmMessage += `• New Advance: Rs. ${newAdvance.toFixed(2)}\n`;
        }

        confirmMessage += `• Final Advance Balance: Rs. ${finalBalance.toFixed(2)}\n\n`;
        confirmMessage += `Continue?`;

        if (!confirm(confirmMessage)) {
            e.preventDefault();
            return;
        }

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing Payment...';
        submitBtn.disabled = true;

        const formElements = paymentForm.elements;
        for (let i = 0; i < formElements.length; i++) {
            formElements[i].disabled = true;
        }
    });
}

            function suggestPaymentAmount() {
                if (remainingAfterCredit > 0) {
                    const suggestedAmount = Math.ceil(remainingAfterCredit / 100) * 100;
                    totalAmountInput.placeholder = `e.g., ${suggestedAmount.toFixed(2)}`;
                } else {
                    totalAmountInput.placeholder = 'Enter amount for advance payment';
                }
            }

            suggestPaymentAmount();
        });
    </script>
@endpush
