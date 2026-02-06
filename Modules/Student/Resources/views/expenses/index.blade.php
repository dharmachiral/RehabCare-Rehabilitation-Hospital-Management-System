@extends('setting::layouts.master')

@section('title', 'Student Expenses')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Expenses</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Student Expenses</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content mt-3">
        <div class="card">
          
             <div class="card-header d-flex justify-content-between align-items-center">
    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-outline-primary" href="{{ route('expense-types.index') }}">
            <i class="fa fa-list"></i> expenses type Index
        </a>
        
    </div>

    <div class="ml-auto">
        <a class="btn btn-info text-white" href="{{ route('expenses.create') }}">
                        <i class="fa fa-plus"></i> Add Expense
                    </a>
    </div>
</div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Student</th>
                            <th>Expense Type</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $exp)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $exp->student->full_name ?? 'N/A' }}</td>

                            <td>{{ $exp->expenseType->name ?? 'N/A' }}</td>
                            <td>{{ number_format($exp->amount, 2) }}</td>
                            <td>{{ number_format($exp->paid_amount, 2) }}</td>
                            <td>{{ number_format($exp->amount - $exp->paid_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $exp->status == 'paid' ? 'success' : ($exp->status == 'partial' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($exp->status) }}
                                </span>
                            </td>
                            <td>{{ $exp->expense_date ? date('Y-m-d', strtotime($exp->expense_date)) : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('expenses.edit', $exp->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('expenses.destroy', $exp->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this expense?')">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>S.N</th>
                            <th>Student</th>
                            <th>Expense Type</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
                {{ $expenses->links() }}
            </div>
        </div>
    </section>
</div>
@endsection
