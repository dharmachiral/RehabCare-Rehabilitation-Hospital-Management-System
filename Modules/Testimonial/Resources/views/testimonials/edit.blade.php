@extends('setting::layouts.master')

@section('title', 'Edit Testimonials')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('testimonials.index') }}">Testimonials</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <form id="product-form" action="{{ route('testimonials.update', $testimonial->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button class="btn btn-primary">Update Testimonial <i class="bi bi-check"></i></button>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Full Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Enter Name" value="{{ $testimonial->name }}" required>
                                                @error('name')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Designation -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="designation">Designation</label>
                                                <input type="text" name="designation" class="form-control"
                                                    placeholder="Enter Designation" value="{{  $testimonial->designation}}">
                                                @error('designation')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image">Image </label>
                                                <p class="text-muted small mb-2">
                                                    <strong>Required size:</strong> Around  70×70 pixels<br>
                                                                    <strong>Max file size:</strong> 2MB<br>
                                                                    <strong>Formats:</strong> JPG, PNG, WEBP<br>
                                                                    {{-- <strong>Note:</strong> Images not matching exact dimensions will be automatically cropped --}}
                                                </p>
                                                <input type="file" id="file-ip-1" accept="image/*"
                                                    class="form-control-file border" value="{{ old('image') }}"
                                                    onchange="showPreview1(event);" name="image">
                                                <img src="{{ asset('upload/images/testimonials/' . $testimonial->image) }}"
                                                    alt="{{ $testimonial->title }}" width="200px">
                                                @error('image')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <img src="" id="file-ip-1-preview" width="30%">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rating">Rating (1 to 5 stars)</label>
                                                <select name="rating" class="form-control">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <option value="{{ $i }}" {{ (old('rating') ?? $testimonial->rating) == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
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
                                                    @if ($testimonial->status == 'on')
                                                        <input type="checkbox" name="status" checked data-bootstrap-switch
                                                            data-off-color="danger" data-on-color="success">
                                                    @else
                                                        <input type="checkbox" name="status" data-bootstrap-switch
                                                            data-off-color="danger" data-on-color="success">
                                                    @endif
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="message">Message</label>
                                                <textarea type="text" name="message" rows="10" class="form-control" placeholder="Enter Message">{{ $testimonial->message }}</textarea>
                                                @error('message')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="col-md-12 text-center" style=" margin-top: 10px;margin-bottom: 10px;">
                                            <button type="submit" class="btn btn-primary">Update Testimonial <i
                                                    class="bi bi-check"></i></button>
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
