@extends('setting::layouts.master')
@section('title', 'Add Fee Type')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Fee Type</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fee-structures.index') }}">fee structures</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('fee-types.index') }}">Fee Types</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Fee Type</h3>
            </div>
            <form method="POST" action="{{ route('fee-types.store') }}">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <input type="text" name="category" class="form-control">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_recurring" value="1" class="form-check-input" id="isRecurring">
                        <label class="form-check-label" for="isRecurring">Recurring</label>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Save</button>
                    <a href="{{ route('fee-types.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
