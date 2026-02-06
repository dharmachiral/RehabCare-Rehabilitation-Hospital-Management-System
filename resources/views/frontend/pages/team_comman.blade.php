<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 wow slideInUp" data-wow-delay="0.1s">
                <div class="section-title bg-light rounded h-100 p-5">
                    <h5 class="position-relative d-inline-block text-primary text-uppercase">Our Experts</h5>
                    <h1 class="display-6 mb-4">Meet Our Compassionate Recovery Specialists</h1>
                    <a href="{{route('frontend.appointment')}}" class="btn btn-primary py-3 px-5">Free Assessment</a>
                </div>
            </div>

            <!-- Visible team members (first 5) -->
            @foreach($data['teams']->take(5) as $team)
            <div class="col-lg-4 wow slideInUp team-member" data-wow-delay="0.3s">
                <div class="team-item">
                    <div class="position-relative rounded-top" style="z-index: 1;">
                        <img class="img-fluid rounded-top w-100" src="{{ asset('upload/images/teams/'.$team->image)}}" alt="Addiction Psychiatrist" style="object-fit: cover; height: 300px; width: 100%;">
                        <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                            <a class="btn btn-primary btn-square m-1" href="{{ $team->twitter }}"><i class="fab fa-twitter fw-normal"></i></a>
                            <a class="btn btn-primary btn-square m-1" href="{{ $team->facebook }}"><i class="fab fa-facebook-f fw-normal"></i></a>
                            <a class="btn btn-primary btn-square m-1" href="{{ $team->linkedin }}"><i class="fab fa-linkedin-in fw-normal"></i></a>
                            <a class="btn btn-primary btn-square m-1" href="{{ $team->instagram }}"><i class="fab fa-instagram fw-normal"></i></a>
                        </div>
                    </div>
                    <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                        <h4 class="mb-2"><a href="{{ route('frontend.team_details',$team->id) }}"><strong style="color:black">{{ $team->name }}</strong></a></h4>
                        <p class="text-primary mb-0">{{ $team->designation }}</p>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Hidden team members (rest of them) -->
            @foreach($data['teams']->slice(5) as $team)
            <div class="col-lg-4 wow slideInUp team-member hidden-team" data-wow-delay="0.3s" style="display: none;">
                <div class="team-item">
                    <div class="position-relative rounded-top" style="z-index: 1;">
                        <img class="img-fluid rounded-top w-100" src="{{ asset('upload/images/teams/'.$team->image)}}" alt="Addiction Psychiatrist" style="object-fit: cover; height: 300px; width: 100%;">
                        <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                            <a class="btn btn-primary btn-square m-1" href="{{ $team->twitter }}"><i class="fab fa-twitter fw-normal"></i></a>
                            <a class="btn btn-primary btn-square m-1" href="{{ $team->facebook }}"><i class="fab fa-facebook-f fw-normal"></i></a>
                            <a class="btn btn-primary btn-square m-1" href="{{ $team->linkedin }}"><i class="fab fa-linkedin-in fw-normal"></i></a>
                            <a class="btn btn-primary btn-square m-1" href="{{ $team->instagram }}"><i class="fab fa-instagram fw-normal"></i></a>
                        </div>
                    </div>
                    <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                        <h4 class="mb-2"><a href="{{ route('frontend.team_details',$team->id) }}"><strong style="color:black">{{ $team->name }}</strong></a></h4>
                        <p class="text-primary mb-0">{{ $team->designation }}</p>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- See More button (only shown if there are more than 5 team members) -->
            @if($data['teams']->count() > 5)
            <div class="col-12 text-center mt-4">
                <button id="seeMoreBtn" class="btn btn-primary py-3 px-5">See More</button>
            </div>
            @endif
        </div>
    </div>
</div>
