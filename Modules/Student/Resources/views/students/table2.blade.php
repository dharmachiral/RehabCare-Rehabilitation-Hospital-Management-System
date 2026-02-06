
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

