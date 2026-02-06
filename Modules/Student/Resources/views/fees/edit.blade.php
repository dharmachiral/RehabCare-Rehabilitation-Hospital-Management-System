@extends('student::layouts.master')
@section('title', 'Edit Fee Type')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Fee Type</h3>
            </div>
            <form action="{{ route('student.fee-types.update', $feeType->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $feeType->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <input type="text" name="category" class="form-control" value="{{ $feeType->category }}" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_recurring" value="1" class="form-check-input" {{ $feeType->is_recurring ? 'checked' : '' }}>
                        <label class="form-check-label">Recurring Fee?</label>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('student.fee-types.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
