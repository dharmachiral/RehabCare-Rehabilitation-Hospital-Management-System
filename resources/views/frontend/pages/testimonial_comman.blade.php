<div class="container-fluid bg-primary bg-testimonial py-5 my-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="owl-carousel testimonial-carousel rounded p-5 wow zoomIn" data-wow-delay="0.6s">
                    @foreach ($data['testimonials'] as $testimonial)
                    <div class="testimonial-item text-center text-white">
                        <img class="img-fluid mx-auto rounded mb-4" src="{{ asset('upload/images/testimonials/' . $testimonial->image) }}" alt="Recovery Success Story">
                        <p class="fs-5">"{{ $testimonial->message }}"</p>
                        <hr class="mx-auto w-25">
                        <h4 class="text-white mb-0">{{ $testimonial->name }} ({{ $testimonial->designation }})</h4>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>