
<!-- Gallery Section -->
<section class="gallery-section">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 800px;">
            <h5 class="text-primary text-uppercase">Our Gallery</h5>
            <h1 class="display-5 mb-0">See Our Facility & Recovery Journeys</h1>
        </div>

        <!-- Improved Category Scroller -->
        <div class="scroller-container position-relative">
            <div class="scroller-arrow left d-none d-md-flex" onclick="scrollCategories(-100)">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="category-scroller" id="categoryScroller">
                <button class="category-btn active" data-filter="all">All</button>
                @foreach($data['categories'] as $category)
                    <button class="category-btn" data-filter="{{ $category->title }}">{{ $category->title }}</button>
                @endforeach
            </div>
            <div class="scroller-arrow right d-none d-md-flex" onclick="scrollCategories(100)">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="row gallery-container">
            @foreach($data['galleries'] as $index => $gallery)
                <div class="col-lg-4 col-md-6 gallery-item @if($index >= 6) d-none more-item @endif"
                     data-category="{{ $gallery->category->title ?? 'uncategorized' }}">
                    <div class="gallery-item-wrapper">
                        <img src="{{ asset($gallery->image) }}" class="img-fluid gallery-img" onclick="openLightbox(this)">
                    </div>
                </div>
            @endforeach
        </div>

        <!-- See More/Less Button -->
        @if(count($data['galleries']) > 6)
            <div class="text-center mt-4">
                <button id="toggleGalleryBtn" class="btn btn-primary" onclick="toggleGallery()">
                    See More <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        @endif
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="lightbox-modal">
    <span class="close-btn" onclick="closeLightbox()">&times;</span>
    <img id="lightboxImage" class="lightbox-image img-fluid">
    <a class="prev-btn" onclick="changeImage(-1)">&#10094;</a>
    <a class="next-btn" onclick="changeImage(1)">&#10095;</a>
</div>
