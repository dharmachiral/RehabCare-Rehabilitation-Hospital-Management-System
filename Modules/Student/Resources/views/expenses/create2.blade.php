@extends('setting::layouts.master')

@section('title', 'Add Expense')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Student Expense</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Student Expenses</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content mt-3">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Expense</h3>
            </div>

            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                       <div class="col-md-6 mb-3">
    <label>Student</label>
    <input type="text" class="form-control" value="{{ $student->full_name }}" readonly>
    <input type="hidden" name="student_id" value="{{ $student->id }}">
</div>



                        <!-- Expense Type Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label>Expense Type</label>
                            <select name="expense_type_id" class="form-control select2" required>
                                <option value="">Select Expense Type</option>
                                @foreach($expenseTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Amount -->
                        <div class="col-md-6 mb-3">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" step="0.01" required>
                        </div>

                        <!-- Expense Date -->
                        <div class="col-md-6 mb-3">
                            <label>Expense Date</label>
                            <input type="date" name="expense_date" class="form-control">
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success">Save Expense</button>
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
