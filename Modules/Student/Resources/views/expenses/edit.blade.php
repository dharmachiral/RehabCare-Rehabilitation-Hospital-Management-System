@extends('setting::layouts.master')
@section('title', 'Edit Expense')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Student Expense</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Student Expenses</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content mt-3">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Expense</h3>
            </div>

            <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        @include('student::expenses.name2') <!-- If you want to keep this partial -->
       

        <!-- Expense Type Dropdown -->
        <div class="col-md-6 mb-3">
            <label>Expense Type</label>
            <select name="expense_type_id" class="form-control select2" required>
                <option value="">Select Expense Type</option>
                @foreach($expenseTypes as $type)
                    <option value="{{ $type->id }}"
                        {{ $expense->expense_type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Amount -->
        <div class="col-md-6 mb-3">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" step="0.01"
                value="{{ $expense->amount }}" required>
        </div>

        <!-- Expense Date -->
        <div class="col-md-6 mb-3">
            <label>Expense Date</label>
            <input type="date" name="expense_date" class="form-control"
                value="{{ $expense->expense_date }}">
        </div>

        <!-- Description -->
        <div class="col-md-12 mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="2">{{ $expense->description }}</textarea>
        </div>
    </div>

    <div class="card-footer">
        <button class="btn btn-success">Update Expense</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>



        </div>
    </section>
</div>
@endsection
