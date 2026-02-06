@extends('setting::layouts.master')
@section('title', isset($class) ? 'Edit Class' : 'Add Class')
@section('content')
<div class="content-wrapper">
   <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Class</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fee-structures.index') }}">fee structures</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    <section class="content">
        <div class="card card-primary">
             <div class="card-header">
                    <h3 class="card-title">Add Class</h3>
                </div>
            <form method="POST" action="{{ isset($class) ? route('classes.update', $class->id) : route('classes.store') }}">
                @csrf
                @if(isset($class)) @method('PUT') @endif
                <div class="card-body">
                    <div class="mb-3">
                        <label>Class Name</label>
                        <input type="text" name="class_name" class="form-control" value="{{ $class->class_name ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control">{{ $class->description ?? '' }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">{{ isset($class) ? 'Update' : 'Save' }}</button>
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
