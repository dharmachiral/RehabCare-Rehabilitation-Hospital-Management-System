@extends('setting::layouts.master')

@section('title', 'Create Programs')
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
@section('content')
    <style>
        h2 {
            margin-bottom: 0;
        }

        h3 {
            margin: 0 0 30px;
        }

        .ui-slider-range {
            background: green;
        }

        .percent {
            color: green;
            font-weight: bold;
            text-align: center;
            width: 100%;
            border: none;
        }
        .select2-selection__choice{
            background-color: #4CAF50 !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Service</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create</li>
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
                                <h3 class="card-title">Create Service</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="product-form" action="{{ route('service.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Title</label>
                                                <input type="text" name="title" class="form-control"
                                                    placeholder="Enter Title " value="{{ old('title') }}" required>
                                                @error('title')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shortDescription">Short Description</label>
                                                <textarea type="text" name="shortDescription" class="summernote" placeholder="Enter Short Description" required>{{ old('shortDescription') }}</textarea>
                                                @error('shortDescription')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea type="text" name="description" class="summernote" placeholder="Enter Short description">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="image">Image</label>
                                                        <p class="text-muted small mb-2">
                                                            <strong>Required size:</strong> Exactly 318×220 pixels (1.45:1 aspect ratio)<br>
                                                            <strong>Max file size:</strong> 1MB<br>
                                                            <strong>Formats:</strong> JPG, PNG<br>
                                                            <strong>Note:</strong> Images will be cropped to fit if not exact size
                                                        </p>

                                                        <input type="file" id="file-ip-1" accept="image/*"
                                                               class="form-control-file border" value="{{ old('image') }}"
                                                               onchange="showPreview1(event); validateStandardImage(this);" name="image">

                                                        @error('image')
                                                            <p class="text-danger small">{{ $message }}</p>
                                                        @enderror

                                                        <div class="preview mt-3 text-center">
                                                            <img src="" id="file-ip-1-preview" class="img-thumbnail"
                                                                 style="width: 318px; height: 220px; display: none; object-fit: cover;">
                                                            <div id="standard-size-error" class="text-danger small mt-2" style="display: none;"></div>
                                                            <div id="standard-dimension-display" class="text-muted small mt-1" style="display: none;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            function showPreview1(event) {
                                                const file = event.target.files[0];
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        const preview = document.getElementById('file-ip-1-preview');
                                                        preview.src = e.target.result;
                                                        preview.style.display = 'block';
                                                    }
                                                    reader.readAsDataURL(file);
                                                }
                                            }

                                            function validateStandardImage(input) {
                                                const sizeError = document.getElementById('standard-size-error');
                                                const dimensionDisplay = document.getElementById('standard-dimension-display');
                                                sizeError.style.display = 'none';
                                                dimensionDisplay.style.display = 'none';

                                                if (input.files && input.files[0]) {
                                                    const file = input.files[0];
                                                    const img = new Image();
                                                    const reader = new FileReader();

                                                    reader.onload = function(e) {
                                                        img.src = e.target.result;
                                                        img.onload = function() {
                                                            // Display actual dimensions
                                                            dimensionDisplay.textContent = `Current dimensions: ${this.width}×${this.height}px`;
                                                            dimensionDisplay.style.display = 'block';

                                                            // Check exact dimensions (318×220)
                                                            const targetWidth = 318;
                                                            const targetHeight = 220;
                                                            const tolerance = 2; // 2 pixel tolerance

                                                            if (Math.abs(this.width - targetWidth) > tolerance ||
                                                                Math.abs(this.height - targetHeight) > tolerance) {
                                                                sizeError.innerHTML = `⚠️ Image must be exactly <strong>318×220</strong> pixels.<br>
                                                                                    Your image is <strong>${this.width}×${this.height}</strong>px.`;
                                                                sizeError.style.display = 'block';
                                                            }

                                                            // Check file size (1MB max)
                                                            if (file.size > 1 * 1024 * 1024) {
                                                                sizeError.textContent = 'Error: File size exceeds 1MB limit.';
                                                                sizeError.style.display = 'block';
                                                                input.value = '';
                                                                document.getElementById('file-ip-1-preview').style.display = 'none';
                                                                dimensionDisplay.style.display = 'none';
                                                            }
                                                        };
                                                    };
                                                    reader.readAsDataURL(file);
                                                }
                                            }
                                        </script>

                                        <style>
                                            .preview .img-thumbnail {
                                                border: 1px solid #dee2e6;
                                                border-radius: 4px;
                                                padding: 3px;
                                                background-color: #f8f9fa;
                                            }

                                            .text-muted.small {
                                                font-size: 0.8rem;
                                                line-height: 1.4;
                                            }

                                            #standard-size-error {
                                                background-color: #fff3f3;
                                                padding: 8px;
                                                border-left: 3px solid #dc3545;
                                                border-radius: 0 4px 4px 0;
                                            }

                                            .card {
                                                margin-bottom: 20px;
                                                border-radius: 5px;
                                                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                                            }

                                            .form-control-file {
                                                padding: 6px 0;
                                            }
                                        </style>
                                        <div class="col-md-6">
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
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
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
    <script>
        $('textarea.summernote').summernote({
            // placeholder: 'Enter Description',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });
    </script>
    <script>
        $('.extra-fields-customer').click(function() {
            $('.customer_records').clone().appendTo('.customer_records_dynamic');
            $('.customer_records_dynamic .customer_records').addClass('single remove');
            $('.single .extra-fields-customer').remove();
            $('.single').append(
                '<a href="#" class="remove-field btn-remove-customer badge badge-danger">Remove Product</a>');
            $('.customer_records_dynamic > .single').attr("class", "remove");

            $('.customer_records_dynamic input').each(function() {
                var count = 0;
                var fieldname = $(this).attr("name");
                $(this).attr('name', fieldname + count);
                count++;
            });

        });

        $(document).on('click', '.remove-field', function(e) {
            $(this).parent('.remove').remove();
            e.preventDefault();
        });
    </script>
    <script>
        $(function() {
            $('.project').each(function() {
                var $projectBar = $(this).find('.bar');
                var $projectPercent = $(this).find('.percent');
                var $hiddenInput = $('#completion_percentage'); // Reference the hidden input field

                $projectBar.slider({
                    range: "min",
                    animate: true,
                    value: 1,
                    min: 0,
                    max: 100,
                    step: 1,
                    slide: function(event, ui) {
                        $projectPercent.val(ui.value + "%");
                        $hiddenInput.val(ui.value); // Update the hidden input value
                    },
                    change: function(event, ui) {
                        var $projectRange = $(this).find('.ui-slider-range');
                        var percent = ui.value;
                        $hiddenInput.val(percent); // Update the hidden input value

                        if (percent < 30) {
                            $projectPercent.css({
                                'color': 'red'
                            });
                            $projectRange.css({
                                'background': '#f20000'
                            });
                        } else if (percent > 31 && percent < 70) {
                            $projectPercent.css({
                                'color': 'gold'
                            });
                            $projectRange.css({
                                'background': 'gold'
                            });
                        } else if (percent > 70) {
                            $projectPercent.css({
                                'color': 'green'
                            });
                            $projectRange.css({
                                'background': 'green'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
