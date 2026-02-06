@extends('setting::layouts.master')
@section('title', 'Edit Programs')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Before and After</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Update</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update images</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            @if($baf && $baf->id)
                            <form id="product-form" action="{{ route('baf.update', $baf->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="before_image">Before</label>
                                                <input type="file" id="file-ip-1-before" accept="image/*" class="form-control-file border" 
                                                value="{{ old('before_image') }}" onchange="showPreview1(event, 'before');" name="before_image">
                                                @error('before_image')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <p><strong>Current Image:</strong></p>
                                                    <img id="current-before-image" src="{{ isset($baf) ? asset('upload/images/services/'.$baf->before_image) : '' }}" width="200px">
                                                </div>
                                                <div class="preview mt-2">
                                                    <p><strong>New Image Preview:</strong></p>
                                                    <img id="preview-before-image" src="" width="200px" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image2">After</label>
                                                <input type="file" id="file-ip-1-after" accept="image/*" class="form-control-file border" 
                                                value="{{ old('image2') }}" onchange="showPreview1(event, 'after');" name="image2">
                                                @error('image2')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <p><strong>Current Image:</strong></p>
                                                    <img id="current-after-image" src="{{ isset($baf) && $baf->image2 ? asset('upload/images/services/'.$baf->image2) : '' }}" width="200px">
                                                </div>
                                                <div class="preview mt-2">
                                                    <p><strong>New Image Preview:</strong></p>
                                                    <img id="preview-after-image" src="" width="200px" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            @else
                            <form id="product-form" action="{{ route('baf.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="before_image">Before</label>
                                                <input type="file" id="file-ip-1-before" accept="image/*" class="form-control-file border" 
                                                value="{{ old('before_image') }}" onchange="showPreview1(event, 'before');" name="before_image">
                                                @error('before_image')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <p><strong>Current Image:</strong></p>
                                                    <img id="current-before-image" src="{{ isset($baf) ? asset('upload/images/services/'.$baf->before_image) : '' }}" width="200px">
                                                </div>
                                                <div class="preview mt-2">
                                                    <p><strong>New Image Preview:</strong></p>
                                                    <img id="preview-before-image" src="" width="200px" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image2">After</label>
                                                <input type="file" id="file-ip-1-after" accept="image/*" class="form-control-file border" 
                                                value="{{ old('image2') }}" onchange="showPreview1(event, 'after');" name="image2">
                                                @error('image2')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <p><strong>Current Image:</strong></p>
                                                    <img id="current-after-image" src="{{ isset($baf) && $baf->image2 ? asset('upload/images/services/'.$baf->image2) : '' }}" width="200px">
                                                </div>
                                                <div class="preview mt-2">
                                                    <p><strong>New Image Preview:</strong></p>
                                                    <img id="preview-after-image" src="" width="200px" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            @endif
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <!-- image preview -->
    <script type="text/javascript">
        function showPreview1(event, type) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var previewId = "preview-" + type + "-image";
                var preview = document.getElementById(previewId);
                preview.src = src;
                preview.style.display = "block";
            }
        }
    </script>
@endsection