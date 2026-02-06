@extends('student::layouts.master')
@section('title', 'Add Fee Type')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Fee Type</h3>
            </div>
            <form action="{{ route('student.fee-types.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <input type="text" name="category" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_recurring" value="1" class="form-check-input">
                        <label class="form-check-label">Recurring Fee?</label>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Save</button>
                    <a href="{{ route('student.fee-types.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
