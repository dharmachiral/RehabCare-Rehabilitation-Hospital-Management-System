
@extends('setting::layouts.master')

@section('title', 'Gallery Category')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Gallery Category</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gallery Category</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Gallery Category</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8">

                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <h4>Gallery Categories</h4>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Title</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->title }}</td>
                                                <td class="text-center"><img
                                                        src="{{ asset('upload/images/gallery/' . $value->image) }}"
                                                        width="120px" alt="{{ $value->name }}"> </td>
                                                <td class="text-center">
                                                    @if ($value->status == 'on')
                                                        <a href="{{ route('galleries-category.status', $value->id) }}"
                                                            class="btn btn-success">On</a>
                                                    @else
                                                        <a href="{{ route('galleries-category.status', $value->id) }}"
                                                            class="btn btn-danger">Off</a>
                                                    @endif
                                                </td>
                                                <td class="">
                                                    <a data-toggle="modal" data-target="#categoryEdit{{ $value->id }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    {{-- <a href="{{ route('Service.show',$value->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a> --}}
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="
                                        event.preventDefault();
                                        if (confirm('Are you sure? It will delete the data permanently!')) {
                                            document.getElementById('destroy{{ $value->id }}').submit()
                                        }
                                        ">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $value->id }}" class="d-none"
                                                            action="{{ route('galleriescategory.destroy', $value->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </button>
                                                    <div class="modal fade" id="categoryEdit{{ $value->id }}" tabindex="-1"
                                                        aria-labelledby="categoryEditLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="categoryEditLabel">category
                                                                        Edit</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('galleriescategory.update',$value->id) }}"
                                                                        method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="form-row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="title">Title</label>
                                                                                    <input type="text" name="title"
                                                                                        value="{{ $value->title }}"
                                                                                        class="form-control"
                                                                                        placeholder="Enter Title" required>
                                                                                    @error('title')
                                                                                        <p style="color: red">
                                                                                            {{ $message }}</p>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="logo">Image</label>
                                                                                    <input type="file" id="file-ip-1"
                                                                                        accept="image/*"
                                                                                        class="form-control-file border"
                                                                                        value="{{ old('image') }}"
                                                                                        onchange="showPreview2(event);"
                                                                                        name="image">
                                                                                    @error('image')
                                                                                        <p style="color: red">
                                                                                            {{ $message }}</p>
                                                                                    @enderror
                                                                                    <div class="preview mt-2">
                                                                                        <img src=""
                                                                                            id="file-ip-2-preview"
                                                                                            width="200px">
                                                                                    </div>
                                                                                    <div class="preview mt-2">
                                                                                        <img src="{{ asset('upload/images/gallery/'.$value->image) }}" width="200px">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <!-- Bootstrap Switch -->
                                                                                <div class="card card-secondary">
                                                                                    <div class="card-header">
                                                                                        <h3 class="card-title">Publish</h3>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        @if($value->status == 'on')
                                                                                        <input type="checkbox" name="status" checked data-bootstrap-switch
                                                                                            data-off-color="danger" data-on-color="success" >
                                                                                    @else
                                                                                        <input type="checkbox" name="status" data-bootstrap-switch
                                                                                        data-off-color="danger" data-on-color="success">
                                                                                    @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Save
                                                                                changes</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Title</th>
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
                    <div class="col-4">

                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <h4>Create Gallery Category</h4>
                            </div>
                            <!-- /.card-header -->
                            <form action="{{ route('galleriescategory.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="card-body">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Title</label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Enter Category Title">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="image">Image </label>

                                            <input type="file" id="file-ip-1" accept="image/*"
                                                class="form-control-file border" value="{{ old('image') }}"
                                                onchange="showPreview1(event);" name="image">
                                                <strong>Format:<span style="color:red;" >image must be 80*80 pixels</span>
                                                </strong>
                                            @error('image')
                                                <p style="color: red">{{ $message }}</p>
                                            @enderror
                                            <div class="preview mt-2">
                                                <img src="" id="file-ip-1-preview" width="200px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <!-- Bootstrap Switch -->
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">Publish</h3>
                                            </div>
                                            <div class="card-body">
                                                <input type="checkbox" name="status" checked data-bootstrap-switch
                                                    data-off-color="danger" data-on-color="success">
                                            </div>
                                        </div>
                                    </div>


                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success" type="submit">Save Changes</button>
                            </div>
                        </form>
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
<script type="text/javascript">
    function showPreview1(event) {
        if (event.target.files.length > 0) {
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-ip-1-preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }
</script>
<script type="text/javascript">
    function showPreview2(event) {
        if (event.target.files.length > 0) {
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-ip-2-preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }
</script>
