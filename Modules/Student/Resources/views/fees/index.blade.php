@extends('student::layouts.master')

@section('title', 'Fee Types')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Fee Types</li>
    </ol>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Fee Types</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('student.fee-types.create') }}" class="btn btn-primary">Add Fee Type</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Recurring</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feeTypes as $key => $feeType)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $feeType->name }}</td>
                            <td>{{ $feeType->category }}</td>
                            <td>{{ $feeType->is_recurring ? 'Yes' : 'No' }}</td>
                            <td class="text-center">
                                <a href="{{ route('student.fee-types.edit', $feeType->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure?')) { document.getElementById('delete{{ $feeType->id }}').submit(); }">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <form id="delete{{ $feeType->id }}" action="{{ route('student.fee-types.destroy', $feeType->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Recurring</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
