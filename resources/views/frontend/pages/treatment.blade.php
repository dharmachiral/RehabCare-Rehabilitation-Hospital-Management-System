@extends('frontend.layouts.master')
@section('title', 'hospital - Treatment')
@section('content')
<!-- Hero Start -->
<div class="container-fluid bg-primary py-5 hero-header mb-5">
    <div class="row py-3">
        <div class="col-12 text-center">
            <h1 class="display-3 text-white animated zoomIn">Treatment</h1>
            <a href="{{route('frontend.index')}}" class="h4 text-white">Home</a>
                  <i class="fas fa-angle-right text-white px-2"></i>
            <a href="" class="h4 text-white" style="color:#06A3DA !important">Treatment</a>
        </div>
    </div>
  </div>
  <!-- Hero End -->
@include('frontend.pages.treatment_comman')
@endsection