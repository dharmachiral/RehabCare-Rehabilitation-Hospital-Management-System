@extends('setting::layouts.master')
@section('title', 'Edit Fee Type')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Fee Type</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fee-structures.index') }}">fee structures</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('fee-types.index') }}">Fee Types</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Fee Type</h3>
            </div>
            <form method="POST" action="{{ route('fee-types.update', $feeType->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $feeType->name }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <input type="text" name="category" value="{{ $feeType->category }}" class="form-control">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_recurring" value="1" class="form-check-input" id="isRecurring" {{ $feeType->is_recurring ? 'checked' : '' }}>
                        <label class="form-check-label" for="isRecurring">Recurring</label>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('fee-types.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
