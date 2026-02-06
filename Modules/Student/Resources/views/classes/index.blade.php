@extends('setting::layouts.master')
@section('title', 'Classes')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Classes</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fee-structures.index') }}">fee structures</a></li>

                            <li class="breadcrumb-item active">Classes</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

    <section class="content">
        <div class="card">
              <div class="card-header">
                    <h3 class="card-title float-right"><a class="btn btn-info text-white"
                            href="{{ route('classes.create') }}"><i class="fa fa-plus"></i> Create</a> </h3>
                </div>
            <div class="card-body">
                @if($classes->count())
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Class Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $class)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $class->class_name }}</td>
                                    <td>{{ $class->description }}</td>
                                    <td>
                                        <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('classes.destroy', $class->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $classes->links() }}
                @else
                    <p>No classes found.</p>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
