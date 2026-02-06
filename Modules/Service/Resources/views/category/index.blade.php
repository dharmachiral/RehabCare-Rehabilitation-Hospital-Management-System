@extends('setting::layouts.master')

@section('title', 'Program Sectors')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Program Sectors</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Program Sectors</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Program Sectors</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
  
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
             
              <!-- /.card -->
  
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title float-right"><a class="btn btn-info text-white" href="{{ route('programs_category.create') }}"><i class="fa fa-plus"></i> Create</a> </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>S.N</th>
                      <th>Title</th>
                      <th class="text-center">Icon</th>
                      <th class="text-center">Image</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->title }}</td>
                            <td class="text-center"><img src="{{ asset('upload/images/category/'.$value->icon) }}" width="120px" alt="{{ $value->name }}"> </td>
                            <td class="text-center"><img src="{{ asset('upload/images/category/'.$value->image) }}" width="120px" alt="{{ $value->name }}"> </td>
                            <td class="text-center">
                                @if($value->status == 'on')
                                <a href="{{ route('programs_category.status',$value->id) }}" class="btn btn-success">On</a>
                                @else
                                <a href="{{ route('programs_category.status',$value->id) }}" class="btn btn-danger">Off</a> 
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('programs_category.edit',$value->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                {{-- <a href="{{ route('Service.show',$value->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a> --}}
                                <button id="delete" class="btn btn-danger btn-sm" onclick="
                                event.preventDefault();
                                if (confirm('Are you sure? It will delete the data permanently!')) {
                                    document.getElementById('destroy{{ $value->id }}').submit()
                                }
                                ">
                                <i class="fa fa-trash"></i>
                                <form id="destroy{{ $value->id }}" class="d-none" action="{{ route('programs_category.destroy', $value->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                </form>
                            </button>
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>S.N</th>
                        <th>Title</th>
                        <th class="text-center">Icon</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
 
@endsection
