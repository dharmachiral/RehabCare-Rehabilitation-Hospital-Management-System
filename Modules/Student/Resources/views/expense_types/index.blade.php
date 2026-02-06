@extends('setting::layouts.master')

@section('title', 'Expense Types')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Expense Types</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Student Expenses</a></li>

                            <li class="breadcrumb-item active">Expense Types</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <section class="content mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-right"><a class="btn btn-info text-white"
                            href="{{ route('expense-types.create') }}"><i class="fa fa-plus"></i> Create</a> </h3>
                </div>
                <div class="card-body">
                    {{-- <table class="table table-bordered table-striped"> --}}
                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($types as $type)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $type->name }}</td>
                                    <td>{{ $type->description }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('expense-types.edit', $type->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('expense-types.destroy', $type->id) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this expense type?')">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $types->links() }}
                </div>
            </div>
        </section>
    </div>
@endsection
