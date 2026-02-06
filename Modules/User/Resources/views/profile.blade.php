@extends('setting::layouts.master')

@section('title', 'User Profile')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h3>Hello, <span class="text-primary">{{ auth()->user()->name }}</span></h3>
                        <p class="font-italic">Change your profile information & password from here...</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <!-- Add success/error messages -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT') {{-- Change to PUT --}}

                                    <div class="form-group">
                                        <label for="image">Profile Image</label>
                                        <div class="text-center mb-3">
                                            @if(auth()->user()->image && file_exists(public_path('upload/images/users/' . auth()->user()->image)))
                                                <img style="width: 100px;height: 100px;"
                                                    class="d-block mx-auto img-thumbnail img-fluid rounded-circle mb-2"
                                                    src="{{ asset('upload/images/users/' . auth()->user()->image) }}"
                                                    alt="Profile Image" id="current-image">
                                            @else
                                                <div class="d-block mx-auto img-thumbnail img-fluid rounded-circle mb-2" 
                                                     style="width: 100px; height: 100px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" id="file-ip-1" accept="image/*"
                                            class="form-control-file border" 
                                            onchange="showPreview1(event);" name="image">
                                        <small class="form-text text-muted">Max file size: 2MB. Allowed types: JPEG, PNG, JPG, GIF</small>
                                        @error('image')
                                            <p class="text-danger small mt-1">{{ $message }}</p>
                                        @enderror
                                        <div class="preview mt-2 text-center">
                                            <img src="" id="file-ip-1-preview" width="100px" style="display: none;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" required
                                            value="{{ old('name', auth()->user()->name) }}">
                                        @error('name')
                                            <p class="text-danger small mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" required
                                            value="{{ old('email', auth()->user()->email) }}">
                                        @error('email')
                                            <p class="text-danger small mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update Profile <i
                                                class="bi bi-check"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Password form remains the same -->
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function showPreview1(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
                
                // Hide current image when new one is selected
                var currentImage = document.getElementById("current-image");
                if (currentImage) {
                    currentImage.style.display = "none";
                }
            }
        }
    </script>
@endsection