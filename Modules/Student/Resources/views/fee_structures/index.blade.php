@extends('setting::layouts.master')
@section('title', 'Fee Structures')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Fee Structure</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Fee Structure</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    <section class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-outline-primary" href="{{ route('classes.index') }}">
            <i class="fa fa-list"></i> Class Index
        </a>
        <a class="btn btn-outline-primary" href="{{ route('fee-types.index') }}">
            <i class="fa fa-list"></i> Fee Types Index
        </a>
    </div>

    <div class="ml-auto">
        <a class="btn btn-success" href="{{ route('fee-structures.create') }}">
            <i class="fa fa-plus"></i> Create Fee Structure
        </a>
    </div>
</div>

            <div class="card-body">
                @if($feeStructures->count())
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Class</th>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Session Year</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeStructures as $fs)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $fs->classModel->class_name ?? '' }}</td>
                                    <td>{{ $fs->feeType->name ?? '' }}</td>
                                    <td>{{ $fs->amount }}</td>
                                    <td>{{ $fs->session_year }}</td>
                                    <td>
                                        <a href="{{ route('fee-structures.edit', $fs->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('fee-structures.destroy', $fs->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $feeStructures->links() }}
                @else
                    <p>No fee structures found.</p>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
