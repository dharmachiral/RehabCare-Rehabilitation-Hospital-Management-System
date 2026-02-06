@extends('setting::layouts.master')

@section('title', 'Finance Summary')

@section('content')
<div class="content-wrapper">
    <section class="content-header d-flex justify-content-between align-items-center">
        <h1>Finance Summary</h1>
        <form action="{{ route('finance.summary') }}" method="GET" class="form-inline">
            <select name="filter" id="filter" class="form-control mr-2" onchange="toggleDateInputs(this.value)">
                <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Today</option>
                <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>This Week</option>
                <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>This Month</option>
                <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>This Year</option>
                <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Custom</option>
            </select>

            <div id="custom-dates" class="d-flex align-items-center {{ $filter == 'custom' ? '' : 'd-none' }}">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control mr-2">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control mr-2">
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
        </form>
    </section>

    <section class="content">
        <div class="container-fluid mt-3">

            <!-- Summary Cards -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-success text-white shadow-sm">
                        <div class="card-body text-center">
                            <h5>Total Income</h5>
                            <h3>Rs. {{ number_format($totalIncome, 2) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-danger text-white shadow-sm">
                        <div class="card-body text-center">
                            <h5>Total Expenses</h5>
                            <h3>Rs. {{ number_format($totalExpense, 2) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-warning text-dark shadow-sm">
                        <div class="card-body text-center">
                            <h5>Remaining Balance</h5>
                            <h3>Rs. {{ number_format($remaining, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Income Table -->
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fa fa-money-bill"></i> Income Records</h5>
                </div>
                <div class="card-body p-0">
                    <table id="example1" class="table table-bordered table-striped mb-0">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Student</th>
                                <th>Payment Date</th>
                                <th>Method</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $key => $p)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $p->student->full_name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->payment_date)->format('d M, Y') }}</td>
                                    <td>{{ ucfirst($p->payment_method) }}</td>
                                    <td><strong>Rs. {{ number_format($p->total_amount, 2) }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No income records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Expense Table -->
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fa fa-coins"></i> Expense Records</h5>
                </div>
                <div class="card-body p-0">
                    <table id="example2" class="table table-bordered table-striped mb-0">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Student</th>
                                <th>Expense Type</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $key => $e)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $e->student->full_name ?? '-' }}</td>
                                    <td>{{ $e->expenseType->name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($e->expense_date)->format('d M, Y') }}</td>
                                    <td><strong>Rs. {{ number_format($e->amount, 2) }}</strong></td>
                                    <td>{{ $e->description ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No expense records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

@endsection

@push('scripts')
<script>
function toggleDateInputs(value) {
    const dateInputs = document.getElementById('custom-dates');
    if (value === 'custom') {
        dateInputs.classList.remove('d-none');
    } else {
        dateInputs.classList.add('d-none');
    }
}
</script>
@endpush
