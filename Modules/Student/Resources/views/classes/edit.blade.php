@extends('setting::layouts.master')
@section('title', 'Edit Class')
@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Class</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fee-structures.index') }}">fee structures</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Form -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Class</h3>
            </div>
            <form method="POST" action="{{ route('classes.update', $class->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label>Class Name</label>
                        <input type="text" name="class_name" class="form-control" value="{{ old('class_name', $class->class_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control">{{ old('description', $class->description) }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
