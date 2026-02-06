@extends('frontend.layouts.master')
@section('content')
    <div class="pager-header">
       
        <div class="container">
            <div class="page-content">
                <h2>Service</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Service</li>
                </ol>
            </div>
        </div>
    </div><!-- /Page Header -->
    <section class="blog-section bg-grey padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 sm-padding">
                    <div class="blog-items single-post row">
                        <img src="{{ asset('upload/images/services/' . $data['serviceDetail']->image) }}" alt="service post">
                        <div>
                            <h2>{{ $data['serviceDetail']->title }}</h2>
                        </div><br>

                        <!-- Meta Info -->
                        <div>{!! $data['serviceDetail']->description !!}</div>

                        <div class="share-wrap">
                            <h4>Share This service</h4>
                            <ul class="share-icon">
                                <div class="sharethis-inline-share-buttons"></div>
                            </ul>
                        </div><!-- Share Wrap -->
                    </div>
                </div><!-- Blog Posts -->
                <div class="col-lg-3 sm-padding">
                    <div class="sidebar-wrap">
                        <div class="sidebar-widget mb-50">
                            <h4>Recent service</h4>
                            <ul class="recent-posts">
                                @foreach ($data['servicefront'] as $item)
                                    <li>
                                        <img src="{{ asset('upload/images/services/' . $item->image) }}" alt="service post">
                                        <div>
                                            <h4
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                                <a
                                                    href="{{ route('frontend.service_details', $item->id) }}">{{ $item->title }}</a>
                                            </h4>
                                            <span class="date"><i
                                                    class="fa fa-clock-o"></i>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- Recent Posts -->
                    </div><!-- /Sidebar Wrapper -->
                </div>
            </div>
        </div>
    </section><!-- /Blog Section -->
@endsection

