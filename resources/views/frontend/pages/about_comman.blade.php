<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="section-title mb-4">
                    <h5 class="position-relative d-inline-block text-primary text-uppercase">About Us</h5>
                    <h1 class="display-5 mb-0">{!! $data['profile']->introduction !!}</h1>
                </div>
                <h4 class="text-body fst-italic mb-4">{!! strip_tags($data['profile']->mission) !!}</h4>
                <p class="mb-4">{!!($data['profile']->vision) !!}</p>
                <a href="{{route('frontend.contact')}}" class="btn btn-primary py-3 px-5 mt-4 wow zoomIn" data-wow-delay="0.6s">Get Help Today</a>
            </div>
            <div class="col-lg-5" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s" src="{{ asset('upload/images/settings/'.$data['profile']->image) }}" style="object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</div>
