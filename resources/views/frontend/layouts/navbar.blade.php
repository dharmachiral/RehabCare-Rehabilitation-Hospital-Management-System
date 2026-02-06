<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-dark m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->
    <!-- Topbar Start -->
    <!-- Topbar Start -->
    <div class="container-fluid bg-light ps-5 pe-0 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-md-5 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center">
                    <small class="py-2"><i class="far fa-clock text-primary me-2"></i>Opening Hours: Sun - Sat : 10.00
                        am - 06.00 pm, Saturday Closed </small>
                </div>
            </div>
            <div class="col-md-7 text-center text-lg-end">
                <div class="position-relative d-inline-flex align-items-center bg-primary text-white top-shape px-5">
                    <div class="me-3 pe-3 border-end d-flex align-items-center py-2">
                        <i class="fa fa-envelope-open me-2"></i>
                        <span>{{ $data['profile']->company_email }}</span>
                    </div>
                    <div class="d-flex align-items-center py-2">
                        <i class="fa fa-phone-alt me-2"></i>
                        <span>{{ $data['profile']->company_phone }}/0987654321</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
        <a href="index.html" class="navbar-brand p-0">
            <h1 class="m-0 text-primary"><i class="fas fa-clinic-medical me-2"></i>Hospital</h1>
        </a>
        {{-- <a href="index.html" class="navbar-brand p-0">
    <img src="{{ asset('upload/images/settings/'.$data['profile']->favicon) }}" alt="Logo" style="height: 80px;">
</a> --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="{{ route('frontend.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('frontend.index') ? 'active' : '' }}">Home</a>
                <a href="{{ route('frontend.about') }}"
                    class="nav-item nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}">About</a>
                <a href="{{ route('frontend.program') }}"
                    class="nav-item nav-link {{ request()->routeIs('frontend.program') ? 'active' : '' }}">Programs</a>
                <div class="nav-item dropdown">
                    <a href="#"
                        class="nav-link dropdown-toggle {{ request()->routeIs('frontend.frontend_gallery', 'frontend.team', 'frontend.testimonial', 'frontend.faq') ? 'active' : '' }}"
                        data-bs-toggle="dropdown">More</a>
                    <div class="dropdown-menu m-0">
                        <a href="{{ route('frontend.frontend_gallery') }}"
                            class="dropdown-item {{ request()->routeIs('frontend.frontend_gallery') ? 'active' : '' }}">Gallery</a>
                        <a href="{{ route('frontend.team') }}"
                            class="dropdown-item {{ request()->routeIs('frontend.team') ? 'active' : '' }}">Our
                            Team</a>
                        <a href="{{ route('frontend.testimonial') }}"
                            class="dropdown-item {{ request()->routeIs('frontend.testimonial') ? 'active' : '' }}">Success
                            Stories</a>
                        <a href="{{ route('frontend.blog') }}"
                            class="dropdown-item {{ request()->routeIs('frontend.blog') ? 'active' : '' }}">Blogs</a>
                        <a href="{{ route('frontend.faq') }}"
                            class="dropdown-item {{ request()->routeIs('frontend.faq') ? 'active' : '' }}">FAQ</a>
                    </div>
                </div>
                <a href="{{ route('frontend.contact') }}"
                    class="nav-item nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}">Contact</a>
            </div>
            <button type="button" class="btn text-dark" data-bs-toggle="modal" data-bs-target="#searchModal"><i
                    class="fa fa-search"></i></button>
            <a href="{{ route('frontend.contact') }}" class="btn btn-primary py-2 px-4 ms-3">Get Help</a>
        </div>
    </nav>
    <!-- Navbar End -->
