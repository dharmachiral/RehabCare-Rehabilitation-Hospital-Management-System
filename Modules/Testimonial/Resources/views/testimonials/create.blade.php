@extends('setting::layouts.master')

@section('title', 'Create Testimonials')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('testimonials.index') }}">Testimonials</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <form id="product-form" action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button class="btn btn-primary">Create Testimonial <i class="bi bi-check"></i></button>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <!-- Full Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}" required>
                                            @error('name') <p style="color: red">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <!-- Designation -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="designation">Designation</label>
                                            <input type="text" name="designation" class="form-control" placeholder="Enter Designation" value="{{ old('designation') }}">
                                            @error('designation') <p style="color: red">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <!-- Image -->
                                    <div class="col-md-6">
                                        <div class="card image-card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="image">Donor Image</label>
                                                    <p class="text-muted small mb-2">
                                                        <strong>Required size:</strong> Around  70×70 pixels<br>
                                                                        <strong>Max file size:</strong> 2MB<br>
                                                                        <strong>Formats:</strong> JPG, PNG, WEBP<br>
                                                                        <strong>Note:</strong> Images not matching exact dimensions will be automatically cropped
                                                    </p>
                                                    <input type="file" id="create-image-input" accept="image/*"
                                                           class="form-control-file border" name="image"
                                                           onchange="showPreview(event, 'create-image-preview'); validateImageSize(this, 'create-size-error')">
                                                    @error('image')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                    <div class="preview mt-3 text-center">
                                                        <img src="" id="create-image-preview" class="img-thumbnail" style="display: none;">
                                                        <div id="create-size-error" class="size-error" style="display: none;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Rating -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rating">Rating (1 to 5 stars)</label>
                                            <select name="rating" class="form-control">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                                @endfor
                                            </select>
                                            @error('rating') <p style="color: red">{{ $message }}</p> @enderror
                                        </div>
                                         <!-- Status -->
                                    {{-- <div class="col-md-6"> --}}
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">Publish</h3>
                                            </div>
                                            <div class="card-body">
                                                <input type="checkbox" name="status" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                            </div>
                                        </div>
                                    {{-- </div> --}}
                                    </div>

                                    <!-- Message -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea name="message" rows="5" class="form-control" placeholder="Enter testimonial message">{{ old('message') }}</textarea>
                                            @error('message') <p style="color: red">{{ $message }}</p> @enderror
                                        </div>
                                    </div>



                                    <!-- Submit -->
                                    <div class="col-md-12 text-center mt-3 mb-3">
                                        <button type="submit" class="btn btn-primary">Create Testimonial <i class="bi bi-check"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
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
@endsection
