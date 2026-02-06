<!-- Fee Calculation & Balance Sheet Section -->
<section class="content mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calculator mr-2"></i>Financial Calculation & Balance Sheet
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Expected Income Calculation -->
                            <div class="col-md-6">
                                <div class="card card-light">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <i class="fas fa-money-bill-wave mr-2"></i>Expected Income Calculation
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td><strong>Admission Date:</strong></td>
                                                <td class="text-right">
                                                    {{ \Carbon\Carbon::parse($feeDetails['admission_date'])->format('d M Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Calculation End Date:</strong></td>
                                                <td class="text-right">
                                                    {{ \Carbon\Carbon::parse($feeDetails['calculation_end_date'])->format('d M Y') }}
                                                    @if ($student->recover_date)
                                                        <span class="badge badge-success ml-1">Recovered</span>
                                                    @else
                                                        <span class="badge badge-info ml-1">Current</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Period:</strong></td>
                                                <td class="text-right">{{ $feeDetails['total_months'] }} month(s)</td>
                                            </tr>
                                        </table>

                                        <!-- Income Components -->
                                        <div class="mt-3 p-3 border rounded bg-light">
                                            <h6 class="text-center mb-3"><strong>Income Components</strong></h6>
                                            <table class="table table-sm table-borderless">
                                                <tr class="table-warning">
                                                    <td><strong>Admission Fee:</strong></td>
                                                    <td class="text-right">Rs
                                                        {{ number_format($feeDetails['admission_fee'], 2) }}</td>
                                                </tr>

                                                <!-- Monthly Fee Breakdown -->
                                                @if (count($feeDetails['monthly_breakdown']) > 0)
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Monthly Fees:</strong>
                                                            <div class="mt-2">
                                                                <div class="table-responsive"
                                                                    style="max-height: 150px; overflow-y: auto;">
                                                                    <table class="table table-sm table-bordered mb-2">
                                                                        <thead class="bg-light">
                                                                            <tr>
                                                                                <th>Month</th>
                                                                                <th>Period</th>
                                                                                <th>Days</th>
                                                                                <th>Amount</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($feeDetails['monthly_breakdown'] as $month)
                                                                                <tr>
                                                                                    <td>{{ $month['month'] }}</td>
                                                                                    <td>{{ $month['period'] }}</td>
                                                                                    <td>{{ $month['days_covered'] }}/{{ $month['days_in_month'] }}
                                                                                    </td>
                                                                                    <td>Rs
                                                                                        {{ number_format($month['monthly_fee'], 2) }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr class="table-warning">
                                                    <td><strong>Total Monthly Fee:</strong></td>
                                                    <td class="text-right">Rs
                                                        {{ number_format($feeDetails['total_monthly_fee'], 2) }}</td>
                                                </tr>

                                                <tr class="table-danger">
                                                    <td><strong>Total Expenses:</strong></td>
                                                    <td class="text-right">Rs
                                                        {{ number_format($feeDetails['total_expenses'], 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <!-- Total Expected Income -->
                                        <table class="table table-sm table-borderless mt-3">
                                            <tr class="table-success">
                                                <td><strong>Total Expected Income:</strong></td>
                                                <td class="text-right"><strong>Rs
                                                        {{ number_format($feeDetails['total_expected_income'], 2) }}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Summary -->
                            <div class="col-md-6">
                                <div class="card card-light">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <i class="fas fa-balance-scale mr-2"></i>Financial Summary
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm table-borderless">
                                            <tr class="table-success">
                                                <td><strong>Total Expected Income:</strong></td>
                                                <td class="text-right">Rs
                                                    {{ number_format($feeDetails['total_expected_income'], 2) }}</td>
                                            </tr>
                                            <tr class="table-info">
                                                <td><strong>Total Payments Received:</strong></td>
                                                <td class="text-right">Rs
                                                    {{ number_format($feeDetails['total_payments'], 2) }}</td>
                                            </tr>
                                            <tr
                                                class="table-{{ $feeDetails['remaining_status'] == 'positive' ? 'success' : 'danger' }}">
                                                <td>
                                                    <strong>
                                                        @if ($feeDetails['remaining_status'] == 'positive')
                                                            Advance Payment:
                                                        @else
                                                            Due Amount:
                                                        @endif
                                                    </strong>
                                                </td>
                                                <td class="text-right">
                                                    <strong>Rs
                                                        {{ number_format(abs($feeDetails['remaining_money']), 2) }}</strong>
                                                    <span
                                                        class="badge badge-{{ $feeDetails['remaining_status'] == 'positive' ? 'success' : 'danger' }} ml-2">
                                                        @if ($feeDetails['remaining_status'] == 'positive')
                                                            Advance
                                                        @else
                                                            Due
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Expense Details -->
                                        <div class="mt-3 p-3 border rounded">
                                            <h6 class="text-center mb-2"><strong>Expense Details</strong></h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td><strong>Total Expenses:</strong></td>
                                                    <td class="text-right">Rs
                                                        {{ number_format($feeDetails['total_expenses'], 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;Paid Expenses:</td>
                                                    <td class="text-right">Rs
                                                        {{ number_format($feeDetails['total_paid_expenses'], 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;Due Expenses:</td>
                                                    <td class="text-right">Rs
                                                        {{ number_format($feeDetails['total_due_expenses'], 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <!-- Summary Statistics -->
                                        <div class="mt-3 p-3 bg-light rounded">
                                            <div class="row text-center">
                                                <div class="col-4">
                                                    <div class="border-right">
                                                        <h5 class="mb-1 text-success">Rs
                                                            {{ number_format($feeDetails['total_expected_income'], 2) }}
                                                        </h5>
                                                        <small class="text-muted">Expected</small>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="border-right">
                                                        <h5 class="mb-1 text-info">Rs
                                                            {{ number_format($feeDetails['total_payments'], 2) }}</h5>
                                                        <small class="text-muted">Collected</small>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div>
                                                        <h5
                                                            class="mb-1 text-{{ $feeDetails['remaining_status'] == 'positive' ? 'success' : 'danger' }}">
                                                            Rs
                                                            {{ number_format(abs($feeDetails['remaining_money']), 2) }}
                                                        </h5>
                                                        <small class="text-muted">
                                                            @if ($feeDetails['remaining_status'] == 'positive')
                                                                Advance
                                                            @else
                                                                Due
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Breakdown -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-list-alt mr-2"></i>Financial Overview
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="info-box bg-gradient-success">
                                                    <span class="info-box-icon"><i
                                                            class="fas fa-money-check"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Expected Income</span>
                                                        <span class="info-box-number">Rs
                                                            {{ number_format($feeDetails['total_expected_income'], 2) }}</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 100%"></div>
                                                        </div>
                                                        <span class="progress-description">
                                                            Fees + Expenses
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-box bg-gradient-info">
                                                    <span class="info-box-icon"><i
                                                            class="fas fa-hand-holding-usd"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Actual Collection</span>
                                                        <span class="info-box-number">Rs
                                                            {{ number_format($feeDetails['total_payments'], 2) }}</span>
                                                        <div class="progress">
                                                            <div class="progress-bar"
                                                                style="width: {{ $feeDetails['total_expected_income'] > 0 ? ($feeDetails['total_payments'] / $feeDetails['total_expected_income']) * 100 : 0 }}%">
                                                            </div>
                                                        </div>
                                                        <span class="progress-description">
                                                            {{ $feeDetails['total_expected_income'] > 0 ? number_format(($feeDetails['total_payments'] / $feeDetails['total_expected_income']) * 100, 1) : 0 }}%
                                                            Collected
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div
                                                    class="info-box bg-gradient-{{ $feeDetails['remaining_status'] == 'positive' ? 'success' : 'danger' }}">
                                                    <span class="info-box-icon">
                                                        <i
                                                            class="fas fa-{{ $feeDetails['remaining_status'] == 'positive' ? 'plus' : 'minus' }}"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">
                                                            @if ($feeDetails['remaining_status'] == 'positive')
                                                                Advance Payment
                                                            @else
                                                                Due Amount
                                                            @endif
                                                        </span>
                                                        <span class="info-box-number">Rs
                                                            {{ number_format(abs($feeDetails['remaining_money']), 2) }}</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 100%"></div>
                                                        </div>
                                                        <span class="progress-description">
                                                            @if ($feeDetails['remaining_status'] == 'positive')
                                                                You have advance
                                                            @else
                                                                Payment required
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Calculation Formula -->
                                        <div class="mt-3 p-3 bg-light rounded">
                                            <h6 class="text-center mb-2"><strong>Calculation Formula</strong></h6>
                                            <div class="text-center">
                                                <code>
                                                    Expected Income = Admission Fee + Monthly Fees + Expenses<br>
                                                    Balance = Total Payments - Expected Income<br>
                                                    @if ($feeDetails['remaining_status'] == 'positive')
                                                        <span class="text-success">Positive Balance = Advance
                                                            Payment</span><br>
                                                        <span class="text-success">Negative Balance = Due Amount</span>
                                                    @else
                                                        <span class="text-danger">Positive Balance = Advance
                                                            Payment</span><br>
                                                        <span class="text-danger">Negative Balance = Due Amount</span>
                                                    @endif
                                                </code>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Expenses Section -->
<section class="content mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Left: Collapse Button -->
                        <div class="card-tools-left">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>

                        <!-- Center: Title -->
                        <h3
                            class="card-title mb-0 text-center flex-grow-1 d-flex justify-content-center align-items-center">
                            <i class="fas fa-money-bill-wave mr-2 text-success"></i>
                            Student Expenses
                        </h3>

                        <!-- Right: Add Expense Button -->
                        @can('create_single_expenses')
                            <div class="card-tools-right">
                                <a href="{{ route('expenses.create.current', ['student_id' => $student->id]) }}"
                                    class="btn btn-sm btn-success text-white">
                                    <i class="fa fa-plus"></i> Add Expense
                                </a>
                            </div>
                        @endcan
                    </div>


                    <div class="card-body">
                        @if ($student->expenses->count() > 0)
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Expense Type</th>
                                            <th>Amount</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($student->expenses as $expense)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $expense->expenseType->name ?? 'N/A' }}</td>
                                                <td>Rs {{ number_format($expense->amount, 2) }}</td>
                                                <td>Rs {{ number_format($expense->paid_amount, 2) }}</td>
                                                <td>Rs {{ number_format($expense->due_amount, 2) }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $expense->status == 'paid' ? 'success' : ($expense->status == 'partial' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($expense->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $expense->expense_date ? \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') : 'N/A' }}
                                                </td>
                                                <td>{{ $expense->description ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-info">
                                            <td colspan="2" class="text-right"><strong>Totals:</strong></td>
                                            <td><strong>Rs
                                                    {{ number_format($student->expenses->sum('amount'), 2) }}</strong>
                                            </td>
                                            <td><strong>Rs
                                                    {{ number_format($student->expenses->sum('paid_amount'), 2) }}</strong>
                                            </td>
                                            <td><strong>Rs
                                                    {{ number_format($student->expenses->sum('due_amount'), 2) }}</strong>
                                            </td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle mr-2"></i>No expenses found for this student.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Payments Section -->
<section class="content mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Left: Collapse Button -->
                        <div class="card-tools-left">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>

                        <!-- Center: Title -->
                        <h3
                            class="card-title mb-0 text-center flex-grow-1 d-flex justify-content-center align-items-center">
                            <i class="fas fa-credit-card mr-2 text-primary"></i>
                            Payment History
                        </h3>

                        <!-- Right: Add Payment Button -->
                        @can('create_single_payments')
                            <div class="card-tools-right">
                                <a href="{{ route('payments.createForStudent', ['student_id' => $student->id]) }}"
                                    class="btn btn-warning btn-sm text-white">
                                    <i class="fa fa-plus"></i> Add Payment
                                </a>
                            </div>
                        @endcan
                    </div>


                    <div class="card-body">
                        @if ($student->payments->count() > 0)
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Payment Date</th>
                                            <th>Total Amount</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Receipt</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($student->payments as $payment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                                </td>
                                                <td>Rs {{ number_format($payment->total_amount, 2) }}</td>
                                                <td>
                                                    <span class="badge badge-secondary">
                                                        {{ ucfirst($payment->payment_method) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($payment->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($payment->image)
                                                        <a href="{{ asset('storage/' . $payment->image) }}"
                                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                                            <i class="fas fa-receipt mr-1"></i>View
                                                        </a>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>{{ $payment->remarks ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('payments.show', $payment->id) }}"
                                                        class="btn btn-sm btn-info" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-info">
                                            <td colspan="2" class="text-right"><strong>Total Paid:</strong>
                                            </td>
                                            <td><strong>Rs
                                                    {{ number_format($student->payments->sum('total_amount'), 2) }}</strong>
                                            </td>
                                            <td colspan="5"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle mr-2"></i>No payment history found for this student.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('styles')
    <style>
        .student-status-section .card {
            margin-bottom: 0;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .student-status-section .card-body {
            padding: 1rem 1.5rem;
        }

        .detail-item {
            padding: 8px 0;
            border-bottom: 1px solid #f4f6f9;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .student-details {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .student-details::-webkit-scrollbar {
            width: 6px;
        }

        .student-details::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .student-details::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .documents-section .btn {
            margin-bottom: 8px;
            text-align: left;
        }

        .profile-image-container {
            margin-bottom: 20px;
        }

        .no-image-placeholder {
            border: 2px dashed #dee2e6;
        }

        .status-badge .badge {
            font-size: 14px;
            padding: 8px 16px;
        }

        /* Table Styles */
        .table-responsive {
            border-radius: 8px;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }

        .table tfoot td {
            background-color: #e3f2fd;
            font-weight: 600;
        }

        .badge {
            font-size: 12px;
            padding: 6px 12px;
        }
    </style>
@endpush
@push('styles')
    <style>
        /* Existing styles... */

        /* Fee Calculation Styles */
        .table-borderless td,
        .table-borderless th {
            border: none !important;
        }

        .info-box {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            border-radius: 8px;
            margin-bottom: 0;
        }

        .info-box .progress {
            background: rgba(0, 0, 0, 0.2);
            margin: 5px -10px 5px -10px;
            height: 2px;
        }

        .info-box .progress-bar {
            background: #fff;
        }

        .info-box-text {
            text-transform: uppercase;
            font-weight: 600;
            font-size: 14px;
        }

        .info-box-number {
            font-size: 24px;
            font-weight: 700;
        }

        .progress-description {
            font-size: 12px;
            margin-top: 5px;
        }

        /* Card enhancements */
        .card-light {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        .card-light .card-header {
            background-color: #e9ecef;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
@endpush
