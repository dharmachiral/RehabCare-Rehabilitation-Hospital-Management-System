@extends('frontend.layouts.master')
@section('title', 'hospital')
@section('content')

    <!-- Hero Start -->
    <div class="container-fluid bg-primary py-5 hero-header mb-5">
        <div class="row py-3">
            <div class="col-12 text-center">
                <h1 class="display-3 text-white animated zoomIn">FAQ</h1>
                <a href="{{ route('frontend.index') }}" class="h4 text-white">Home</a>
                <i class="fas fa-angle-right text-white px-2"></i>
                <a href="" class="h4 text-white" style="color:#06A3DA !important">FAQ</a>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- faq Start -->
    <div class="faq-top">
        <h1 class="faq-heading">FAQ</h1>
        <p>Frequently Asked Questions</p>
        <div class="search-bar">
            <input type="text" class="form-control" placeholder="Search...">
            <button>Search</button>
        </div>
    </div>

    <div class="faq-content mt-5">
        <div class="row align-items-start">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <h4 class="mb-3 text-white">Have questions?</h4>
                <img src="/img/faq1.png" alt="FAQ" class="illustration">
            </div>
            <div class="col-md-8">
                <div class="accordion" id="faqAccordion">

                    {{-- Example static FAQ --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q0">
                                What types of addictions do you treat?
                            </button>
                        </h2>
                        <div id="q0" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-white text-dark">
                                We treat alcohol, drug (opioids, cannabis, prescription meds), and other substance use
                                disorders.
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic FAQs --}}
                    @foreach ($data['faq'] as $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#q{{ $loop->index + 1 }}" aria-expanded="false"
                                    aria-controls="q{{ $loop->index + 1 }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="q{{ $loop->index + 1 }}" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion" aria-labelledby="heading{{ $loop->index }}">
                                <div class="accordion-body">
                                    {{-- {!! $faq->answer !!} --}}
                                    {{ strip_tags(html_entity_decode($faq->answer)) }}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

@endsection
