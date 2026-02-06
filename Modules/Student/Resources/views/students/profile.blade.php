@extends('setting::layouts.master')

@section('title', 'Student Profile')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Students</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    @include('student::students.recover')


                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Students</a></li>
                            <li class="breadcrumb-item active">{{ $student->full_name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Student Profile Card -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-graduate mr-2"></i>
                                    {{ $student->full_name }}'s Profile
                                    @if ($student->status == 'on')
                                        <span class="badge badge-warning ml-2"><i class="fas fa-user-clock mr-1"></i>
                                            Current Student</span>
                                    @else
                                        <span class="badge badge-success ml-2"><i class="fas fa-user-check mr-1"></i>
                                            Recovered Student</span>
                                    @endif
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <!-- Student Image Column -->
                                    <div class="col-md-3 text-center">
                                        <div class="profile-image-container mb-3">
                                            @if ($student->image)
                                                <img src="{{ asset('upload/images/Students/' . $student->image) }}"
                                                    alt="{{ $student->full_name }}" class="img-fluid rounded-circle shadow"
                                                    style="width: 200px; height: 200px; object-fit: cover; border: 5px solid #e9ecef;">
                                            @else
                                                <div class="no-image-placeholder bg-light p-4 rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 200px; height: 200px; margin: 0 auto;">
                                                    <i class="fas fa-user-graduate fa-5x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Status Badge -->
                                        <div class="status-badge mb-3">
                                            @if ($student->status == 'on')
                                                <span class="badge badge-warning p-2" style="font-size: 14px;">
                                                    <i class="fas fa-user-clock mr-1"></i> Current Student
                                                </span>
                                            @else
                                                <span class="badge badge-success p-2" style="font-size: 14px;">
                                                    <i class="fas fa-user-check mr-1"></i> Recovered Student
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Documents Section -->
                                        <div class="documents-section">
                                            @if ($student->medical_report)
                                                <a href="{{ asset('upload/files/Students/' . $student->medical_report) }}"
                                                    class="btn btn-block btn-outline-info mb-2" target="_blank">
                                                    <i class="fas fa-file-medical mr-2"></i>Medical Report
                                                </a>
                                            @endif
                                            @if ($student->document)
                                                <a href="{{ asset('upload/files/Students/' . $student->document) }}"
                                                    class="btn btn-block btn-outline-secondary" target="_blank">
                                                    <i class="fas fa-file-alt mr-2"></i>View Documents
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Student Information Column -->
                                    <div class="col-md-9">
                                        <div class="row">
                                            <!-- Personal Information -->
                                            <div class="col-md-6">
                                                <div class="card card-info">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            <i class="fas fa-info-circle mr-2"></i>Personal Information
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="student-details">
                                                            <div class="detail-item mb-3">
                                                                <strong><i class="fas fa-user mr-2"></i>Full Name:</strong>
                                                                <span class="float-right">{{ $student->full_name }}</span>
                                                            </div>
                                                            <div class="detail-item mb-3">
                                                                <strong><i
                                                                        class="fas fa-venus-mars mr-2"></i>Gender:</strong>
                                                                <span
                                                                    class="float-right">{{ ucfirst($student->gender) }}</span>
                                                            </div>
                                                            <div class="detail-item mb-3">
                                                                <strong><i class="fas fa-birthday-cake mr-2"></i>Date of
                                                                    Birth:</strong>
                                                                <span
                                                                    class="float-right">{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d M Y') : 'N/A' }}</span>
                                                            </div>
                                                            <div class="detail-item mb-3">
                                                                <strong><i class="fas fa-tint mr-2"></i>Blood
                                                                    Group:</strong>
                                                                <span
                                                                    class="float-right">{{ $student->blood_group ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="detail-item mb-3">
                                                                <strong><i class="fas fa-envelope mr-2"></i>Email:</strong>
                                                                <span
                                                                    class="float-right">{{ $student->user->email }}</span>
                                                            </div>
                                                            <div class="detail-item mb-3">
                                                                <strong><i class="fas fa-phone mr-2"></i>Phone:</strong>
                                                                <span
                                                                    class="float-right">{{ $student->phone ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="detail-item mb-3">
                                                                <strong><i
                                                                        class="fas fa-map-marker-alt mr-2"></i>Address:</strong>
                                                                <span
                                                                    class="float-right">{{ $student->address ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="detail-item mb-3">
                                                                <strong><i class="fas fa-school mr-2"></i>Class:</strong>
                                                                <span
                                                                    class="float-right">{{ $student->classModel->class_name ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="detail-item mb-3">
                                                                <strong><i class="fas fa-money-bill-wave mr-2"></i>Admission
                                                                    Fee:</strong>
                                                                <span
                                                                    class="float-right">${{ number_format($student->admission_fee, 2) }}</span>
                                                            </div>
                                                            <div class="detail-item">
                                                                <strong><i class="fas fa-calendar-alt mr-2"></i>Monthly
                                                                    Fee:</strong>
                                                                <span
                                                                    class="float-right">${{ number_format($student->monthly_fee, 2) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Guardian & Dates Information -->
                                            <div class="col-md-6">
                                                <!-- Guardian Information -->
                                                <div class="card card-success mb-3">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            <i class="fas fa-user-shield mr-2"></i>Guardian Information
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="detail-item mb-3">
                                                            <strong><i class="fas fa-user-tie mr-2"></i>Name:</strong>
                                                            <span
                                                                class="float-right">{{ $student->guardian_name ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="detail-item">
                                                            <strong><i class="fas fa-phone-alt mr-2"></i>Phone:</strong>
                                                            <span
                                                                class="float-right">{{ $student->guardian_phone ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Dates Information -->
                                                <div class="card card-primary mb-3">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            <i class="fas fa-calendar-alt mr-2"></i>Important Dates
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="detail-item mb-3">
                                                            <strong><i class="fas fa-calendar-plus mr-2"></i>Admission
                                                                Date:</strong>
                                                            <span class="float-right">
                                                                {{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d M Y') : 'N/A' }}
                                                            </span>
                                                        </div>
                                                        <div class="detail-item">
                                                            <strong><i class="fas fa-calendar-check mr-2"></i>Recovery
                                                                Date:</strong>
                                                            <span class="float-right">
                                                                @if ($student->recover_date)
                                                                    <span class="text-success font-weight-bold">
                                                                        {{ \Carbon\Carbon::parse($student->recover_date)->format('d M Y') }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted">Not Recovered</span>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <div class="card card-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-smile mr-2"></i>Behaviour Notes
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0">
                                                    {{ $student->behaviour ?? 'No behaviour notes available.' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
@include('student::students.table')
       
    </div>
    </section>
    </div>


@endsection

@push('styles')
    <style>
        .student-status-section .card {
            margin-bottom: 0;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .student-status-section .card-body {
            padding: 1rem 1.5rem;
        }

        .detail-item {
            padding: 8px 0;
            border-bottom: 1px solid #f4f6f9;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .student-details {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .student-details::-webkit-scrollbar {
            width: 6px;
        }

        .student-details::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .student-details::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .documents-section .btn {
            margin-bottom: 8px;
            text-align: left;
        }

        .profile-image-container {
            margin-bottom: 20px;
        }

        .no-image-placeholder {
            border: 2px dashed #dee2e6;
        }

        .status-badge .badge {
            font-size: 14px;
            padding: 8px 16px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
