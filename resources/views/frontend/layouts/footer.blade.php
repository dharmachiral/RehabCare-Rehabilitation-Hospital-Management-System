<!-- Newsletter Start -->
<div class="container-fluid position-relative pt-5 wow fadeInUp" data-wow-delay="0.1s" style="z-index: 1;">
    <div class="container">
        <div class="bg-primary p-5">
            <form class="mx-auto" style="max-width: 600px;">
                <div class="input-group">
                    <input type="text" class="form-control border-white p-3" placeholder="Your Phone Number">
                    <button class="btn btn-dark px-4"
                        onclick="window.location.href='{{ route('frontend.appointment') }}'">Get Help Now</button>
                </div>
                <p class="text-white text-center mt-3 mb-0">24/7 Confidential Support Line:
                    {{ $data['profile']->company_phone }}</p>
            </form>
        </div>
    </div>
</div>
<!-- Newsletter End -->
<!-- Footer Start -->
<div class="container-fluid bg-dark text-light py-5 wow fadeInUp" data-wow-delay="0.3s" style="margin-top: -75px;">
    <div class="container pt-5">
        <div class="row g-5 pt-4">
            <div class="col-lg-3 col-md-6">
                <h3 class="text-white mb-4">Quick Links</h3>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-light mb-2" href="{{ route('frontend.index') }}"><i
                            class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                    <a class="text-light mb-2" href="{{ route('frontend.about') }}"><i
                            class="bi bi-arrow-right text-primary me-2"></i>About Our Center</a>
                    <a class="text-light mb-2" href="{{ route('frontend.program') }}"><i
                            class="bi bi-arrow-right text-primary me-2"></i>Our services</a>
                    <a class="text-light mb-2" href="{{ route('frontend.testimonial') }}"><i
                            class="bi bi-arrow-right text-primary me-2"></i>Success Stories</a>
                    <a class="text-light" href="{{ route('frontend.contact') }}"><i
                            class="bi bi-arrow-right text-primary me-2"></i>Emergency Contact</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3 class="text-white mb-4">Treatment Options</h3>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Alcohol
                        Addiction</a>
                    <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Drug
                        Rehabilitation</a>
                    <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Detox
                        Programs</a>
                    <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Family
                        Counseling</a>
                    <a class="text-light" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Aftercare
                        Support</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3 class="text-white mb-4">Contact Us</h3>
                <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>{{ $data['profile']->company_address }}
                </p>
                <p class="mb-2"><i
                        class="bi bi-envelope-open text-primary me-2"></i>{{ $data['profile']->company_email }}</p>
                <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>{{ $data['profile']->company_phone }}
                </p>
                <p class="mt-2"><i class="bi bi-clock text-primary me-2"></i>24/7 Emergency Support</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3 class="text-white mb-4">Follow Our Journey</h3>
                <div class="d-flex">
                    <a class="btn btn-lg btn-primary btn-lg-square rounded me-2"
                        href="{{ $data['profile']->facebook }}"><i class="fab fa-facebook-f fw-normal"></i></a>
                    <a class="btn btn-lg btn-primary btn-lg-square rounded me-2"
                        href="{{ $data['profile']->instagram }}"><i class="fab fa-instagram fw-normal"></i></a>
                    <a class="btn btn-lg btn-primary btn-lg-square rounded me-2"
                        href="{{ $data['profile']->youtube }}"><i class="fab fa-youtube fw-normal"></i></a>
                    <a class="btn btn-lg btn-primary btn-lg-square rounded" href="{{ $data['profile']->twitter }}"><i
                            class="fab fa-x-twitter fw-normal"></i></a>
                </div>
                <div class="mt-4">
                    <h5 class="text-white mb-3">Newsletter</h5>
                    <div class="input-group">
                        <input type="text" class="form-control border-white p-2" placeholder="Your Email">
                        <button class="btn btn-primary px-3"
                            onclick="window.location.href='{{ route('frontend.appointment') }}'">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-light py-4" style="background: #051225;">
    <div class="container">
        <div class="row g-0">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-md-0">&copy; <a class="text-white border-bottom" href="#">hospital</a>. All Rights
                    Reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">Power By <a href="https://dweap.com/">Dweap</a><br>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
<script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
<script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('lib/twentytwenty/jquery.event.move.js') }}"></script>
<script src="{{ asset('lib/twentytwenty/jquery.twentytwenty.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
