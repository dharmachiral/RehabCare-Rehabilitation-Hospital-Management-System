@extends('setting::layouts.master')

@section('title', isset($feeStructure) ? 'Edit Fee Structure' : 'Add Fee Structure')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($feeStructure) ? 'Edit Fee Structure' : 'Add Fee Structure' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('fee-structures.index') }}">Fee Structures</a></li>
                        <li class="breadcrumb-item active">{{ isset($feeStructure) ? 'Edit' : 'Add' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Form -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ isset($feeStructure) ? 'Edit Fee Structure' : 'Add Fee Structure' }}</h3>
            </div>

            <form method="POST" action="{{ isset($feeStructure) ? route('fee-structures.update', $feeStructure->id) : route('fee-structures.store') }}">
                @csrf
                @if(isset($feeStructure)) @method('PUT') @endif

                <div class="card-body">
                    <!-- Class Selection -->
                    <div class="mb-3">
                        <label>Class</label>
                        <select name="class_id" class="form-control" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ isset($feeStructure) && $feeStructure->class_id == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fee Type Selection -->
                    <div class="mb-3">
                        <label>Fee Type</label>
                        <select name="fee_type_id" class="form-control" required>
                            <option value="">Select Fee Type</option>
                            @foreach($feeTypes as $type)
                                <option value="{{ $type->id }}" {{ isset($feeStructure) && $feeStructure->fee_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="mb-3">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" value="{{ $feeStructure->amount ?? '' }}" required>
                    </div>

                    <!-- Session Year -->
                    <div class="mb-3">
                        <label>Session Year</label>
                        <input type="text" name="session_year" class="form-control" value="{{ $feeStructure->session_year ?? '' }}" placeholder="e.g. 2081/82" required>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="card-footer">
                    <button class="btn btn-success">{{ isset($feeStructure) ? 'Update' : 'Save' }}</button>
                    <a href="{{ route('fee-structures.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
