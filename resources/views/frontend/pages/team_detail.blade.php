@extends('frontend.layouts.master')
@section('title', 'Team Detail')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center mb-5">
        <h3 class="text-dark">Our Dedicated Team</h3>
      </div>
    </div>
  </div>
  <!-- Team Detail Section -->
<section style="background-color: #eee;">
    <div class="container py-5">
      <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('frontend.team') }}">Team</a></li>
              <li class="breadcrumb-item active" aria-current="page">Team Profile</li>
            </ol>
          </nav>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center">
              <img src="{{ asset('upload/images/teams/' . $data['team']->image) }}" alt="avatar"
                class="rounded-circle img-fluid" style="width: 150px;">
              <h5 class="my-3">{{ $data['team']->name }}</h5>
              <p class="text-muted mb-1">{{ $data['team']->designation }}</p>
            </div>
          </div>
          <div class="card mb-4 mb-lg-0">
            <div class="card-body p-0">
              <ul class="list-group list-group-flush rounded-3">
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                    <p class="mb-0">{{ $data['team']->facebook }}</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <i class="fab fa-linkedin fa-lg" style="color: #0e76a8;"></i>
                    <p class="mb-0">{{ $data['team']->linkedin }}</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <i class="fab fa-tiktok fa-lg" style="color: #000000;"></i>
                    <p class="mb-0">{{ $data['team']->tiktok }}</p>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fab fa-x fa-lg" style="color: #55acee;"></i>
                  <p class="mb-0">{{ $data['team']->twitter }}</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                  <p class="mb-0">{{ $data['team']->instagram }}</p>
                </li>

              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Full Name</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ $data['team']->name }}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Email</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ $data['team']->email }}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Mobile</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ $data['team']->phone }}</p>
                </div>
              </div>
              <hr>
            </div>
          </div>
          <div class="card-body">
            {{-- <div class="col-md-6"> --}}
                <div class="card mb-6 mb-md-0">
                 <p>{!! strip_tags($data['team']->introduction) !!}</p>
                </div>
              {{-- </div> --}}
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
