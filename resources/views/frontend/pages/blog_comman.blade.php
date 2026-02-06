<!-- blog Start -->
<!-- Blog Section -->
<section class="blog-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold ">Recovery & Wellness Blog </h2>
            <p class="text-muted">Insights, stories, and guidance on addiction recovery </p>
        </div>

        <div class="blog-container">
            <button class="scroll-btn left" onclick="scrollBlogs(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div class="blog-scroller" id="blogScroller">
                <!-- Blog Post 1 -->
                @foreach ($data['blog'] as $story)
                    <div class="blog-card card border-0">
                        <div class="position-relative">
                            <img src="{{ asset('upload/images/blogs/' . $story->image) }}" alt="Recovery journey"
                                class="blog-img">
                            {{-- <span class="category-badge badge bg-success">Recovery</span> --}}
                        </div>

                        <div class="card-body">

                            <div class="d-flex align-items-center mb-3">
                                {{-- <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Dr. Rajesh Sharma" class="author-img me-2"> --}}
                                <div>
                                    {{-- <h6 class="mb-0">Dr. Rajesh Sharma</h6> --}}
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($story->date)->format('M d, Y') }}</small>
                                </div>
                            </div>
                            <h5 class="card-title title-toggle">{{ $story->title }}</h5>
                            <p class="card-text text-muted">{!! Str::limit(strip_tags($story->slug), 120) !!}</p>
                            <a href="{{ route('frontend.blog_details', $story->id) }}"
                                class="btn btn-link text-primary text-decoration-none px-0">Read More <i
                                    class="fas fa-arrow-right ms-2"></i></a>
                        </div>

                    </div>
                @endforeach
                <button class="scroll-btn right" onclick="scrollBlogs(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>


        </div>
</section>


</body>

</html>
