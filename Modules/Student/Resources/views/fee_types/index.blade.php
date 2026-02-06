@extends('setting::layouts.master')
@section('title', 'Fee Types')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Fee Types</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fee-structures.index') }}">fee structures</a></li>

                        <li class="breadcrumb-item active">Fee Types</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Fee Types</h3>
                <a href="{{ route('fee-types.create') }}" class="btn btn-primary float-right">Add Fee Type</a>
            </div>
            <div class="card-body">
                @if($feeTypes->count())
                <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Recurring</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeTypes as $feeType)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $feeType->name }}</td>
                                    <td>{{ $feeType->category ?? '-' }}</td>
                                    <td>{{ $feeType->is_recurring ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('fee-types.edit', $feeType->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('fee-types.destroy', $feeType->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $feeTypes->links() }}
                @else
                    <p>No fee types found.</p>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
