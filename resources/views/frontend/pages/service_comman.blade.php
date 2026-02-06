<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row g-5 mb-5">
            <!-- Before/After Image Comparison -->
            <div class="col-lg-5 wow zoomIn" data-wow-delay="0.3s" style="min-height: 400px;">
                <div class="twentytwenty-container position-relative h-100 rounded overflow-hidden">
                    @if($data['baf'] ?? false)
                        <img class="position-absolute w-100 h-100" src="{{ asset('upload/images/services/'.$data['baf']->before_image)}}" style="object-fit: cover;" alt="Before Recovery">
                        <img class="position-absolute w-100 h-100" src="{{ asset('upload/images/services/'.$data['baf']->image2)}}" style="object-fit: cover;" alt="After Recovery">
                    @endif
                </div>
            </div>

            <!-- Services Carousel Section -->
            <div class="col-lg-7">
                <div class="section-title mb-5">
                    <h5 class="position-relative d-inline-block text-primary text-uppercase">Our Programs</h5>
                    <h1 class="display-5 mb-0">Transformative Addiction Treatment Services</h1>
                </div>

                <!-- Carousel with sliding one item at a time but displaying two -->
                <div id="servicesCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            $services = $data['servicefront'];
                            $totalItems = count($services);
                            // Create sliding pairs: [1,2], [2,3], [3,4], etc.
                            $slidingPairs = [];
                            for ($i = 0; $i < $totalItems; $i++) {
                                $pair = [
                                    $services[$i],
                                    $services[($i + 1) % $totalItems] // Wrap around to first item
                                ];
                                $slidingPairs[] = $pair;
                            }
                        @endphp

                        @foreach($slidingPairs as $index => $pair)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                @foreach($pair as $servicefront)
                                <div class="col-md-6">
                                    <div class="service-item h-100 wow zoomIn" data-wow-delay="0.6s">
                                        <div class="card h-100 border-0 shadow-lg overflow-hidden">
                                            <div class="rounded-top overflow-hidden" style="height: 250px;">
                                                <img class="img-fluid w-100 h-100"
                                                     src="{{ asset('upload/images/services/'.$servicefront->image)}}"
                                                     alt="{{ $servicefront->title }}"
                                                     style="object-fit: cover; transition: transform 0.5s ease;">
                                            </div>
                                            <div class="card-body position-relative bg-light text-center p-4">
                                                <h5 class="card-title m-0">
                                                    <a href="{{ route('frontend.service_details', $servicefront->id) }}"
                                                       class="stretched-link text-decoration-none"
                                                       style="color: rgb(9, 30, 62); font-size: 22px; font-weight: bold;">
                                                        {{ $servicefront->title }}
                                                    </a>
                                                </h5>
                                                <div class="mt-3">
                                                    <a href="{{ route('frontend.service_details', $servicefront->id) }}"
                                                       class="btn btn-primary btn-sm rounded-pill px-3">
                                                        Learn More
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Custom Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-primary bg-opacity-75 rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-primary bg-opacity-75 rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                    <!-- Indicators -->
                    <div class="carousel-indicators position-static mt-4">
                        @for($i = 0; $i < $totalItems; $i++)
                        <button type="button"
                                data-bs-target="#servicesCarousel"
                                data-bs-slide-to="{{ $i }}"
                                class="{{ $i === 0 ? 'active' : '' }} bg-primary rounded-circle mx-1"
                                style="width: 10px; height: 10px;"></button>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
