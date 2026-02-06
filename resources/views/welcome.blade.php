    @extends('frontend.layouts.master')
    @section('title', 'hospital - Your Path to Recovery')
    @section('content')
    <!-- Full Screen Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background: rgba(9, 30, 62, .7);">
                <div class="modal-header border-0">
                    <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <div class="input-group" style="max-width: 600px;">
                        <input type="text" class="form-control bg-transparent border-primary p-3" placeholder="Type search keyword">
                        <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Full Screen Search End -->
    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($data['slider'] as $index => $slider)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img class="w-100" src="{{ asset('upload/images/sliders/' . $slider->image) }}" alt="Image" style="height: auto; max-height: 700px; object-fit: cover;">    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 900px;">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">{{ $slider->title }}</h5>
                                <h1 class="display-1 text-white mb-md-4 animated zoomIn">{{ strip_tags(html_entity_decode($slider->short_description)) }}</h1>    <a href="{{ route('frontend.appointment') }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Book a Consultation</a>
                                <a href="{{ route('frontend.contact') }}" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Contact Us</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    
    <!-- Carousel End -->
    <!-- Banner Start -->
    <div class="container-fluid banner mb-5">
        <div class="container">
            <div class="row gx-0">
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.1s">
                    <div class="bg-primary d-flex flex-column p-5" style="height: 300px;">
                        <h3 class="text-white mb-3">Opening Hours</h3>
                        <div class="d-flex justify-content-between text-white mb-3">
                            <h6 class="text-white mb-0">Mon - Fri</h6>
                            <p class="mb-0"> 8:00am - 9:00pm</p>
                        </div>
                        <div class="d-flex justify-content-between text-white mb-3">
                            <h6 class="text-white mb-0">Saturday</h6>
                            <p class="mb-0"> 8:00am - 7:00pm</p>
                        </div>
                        <div class="d-flex justify-content-between text-white mb-3">
                            <h6 class="text-white mb-0">Sunday</h6>
                            <p class="mb-0"> 8:00am - 5:00pm</p>
                        </div>
                        <a class="btn btn-light" href="{{route('frontend.appointment')}}">Book a Session</a>
                    </div>
                </div>
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.3s">
                    <div class="bg-dark d-flex flex-column p-5" style="height: 300px;">
                        <h3 class="text-white mb-3">Find a Specialist</h3>
                        <div class="date mb-3" id="date" data-target-input="nearest">
                            <input type="text" class="form-control bg-light border-0 datetimepicker-input"
                                placeholder="Consultation Date" data-target="#date" data-toggle="datetimepicker" style="height: 40px;">
                        </div>
                        <select class="form-select bg-light border-0 mb-3" style="height: 40px;">
                            <option selected>Select a Program</option>
                            <option value="1">Addiction Recovery</option>
                            <option value="2">Physical Therapy</option>
                            <option value="3">Mental Wellness</option>
                             <option value="4">Others</option>
                        </select>
                        <a class="btn btn-light" href="{{route('frontend.appointment')}}">Find Specialist</a>
                    </div>
                </div>
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.6s">
                    <div class="bg-secondary d-flex flex-column p-5" style="height: 300px;">
                        <h3 class="text-white mb-3">Get Immediate Help</h3>
                        <p class="text-white">Start your recovery journey today with compassionate care from our expert team.</p>
                        <h2 class="text-white mb-0" style="font-size:18px">{{$data['profile']->company_phone}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Start -->
    <!-- About Start -->
    @include('frontend.pages.about_comman')
    <!-- About End -->
    <!-- Appointment Start -->
    @include('frontend.pages.appointment')
    <!-- Appointment End -->
    <!-- Service Start -->
   @include('frontend.pages.service_comman')
    <!-- Service End -->
    <!-- Offer Start -->
  @include('frontend.pages.midbody')
    <!-- Offer End -->
    <!-- Pricing Start -->
    @include('frontend.pages.treatment_comman')
    <!-- Pricing End -->
    <!-- Testimonial Start -->
    @include('frontend.pages.testimonial_comman')
    <!-- Testimonial End -->
    <!-- Team Start -->
    @include('frontend.pages.team_comman')
    <!-- Team End -->
    @endsection

    