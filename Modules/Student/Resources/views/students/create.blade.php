@extends('setting::layouts.master')

@section('title', 'Create Student')
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
@section('content')
    <style>
        .profile-image-preview,
.medical-report-preview,
.document-preview {
    max-width: 200px;
    max-height: 200px;
    border: 2px dashed #ddd;
    border-radius: 5px;
    padding: 5px;
    display: none;
    margin-top: 10px;
    object-fit: cover;
}


        .form-section {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-title {
            color: #3c8dbc;
            border-bottom: 2px solid #f4f4f4;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .required-field::after {
            content: " *";
            color: red;
        }

        .gender-radio {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .gender-radio label {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .file-upload-container {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .file-requirements {
            font-size: 0.85rem;
            color: #666;
            margin-top: 5px;
        }

        .payment-receipt-preview {
            max-width: 200px;
            max-height: 200px;
            border: 2px dashed #ddd;
            border-radius: 5px;
            padding: 5px;
            display: none;
            margin-top: 10px;
        }

        .date-range-selector {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .date-range-selector .form-group {
            flex: 1;
        }

        .total-fee-display {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-weight: bold;
        }

        .month-year-selector {
            display: flex;
            gap: 10px;
        }

        .month-year-selector select {
            flex: 1;
        }

        .fee-info {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Student Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Students</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid id="student_payment-form"-->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Students Information</h3>
                            </div>
                            <!-- form start -->
                            <form id="student_payment-form user-form" action="{{ route('student.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-section">
                                        <h4 class="section-title">Basic Information</h4>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="full_name" class="required-field">Full Name</label>
                                                    <input type="text" name="full_name" class="form-control"
                                                        placeholder="Enter full name" value="{{ old('full_name') }}"
                                                        required>
                                                    @error('full_name')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dob">Date of Birth</label>
                                                    <input type="date" name="dob" class="form-control"
                                                        value="{{ old('dob') }}">
                                                    @error('dob')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <div class="gender-radio">
                                                        <label>
                                                            <input type="radio" name="gender" value="male"
                                                                {{ old('gender') == 'male' ? 'checked' : '' }}>
                                                            Male
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="gender" value="female"
                                                                {{ old('gender') == 'female' ? 'checked' : '' }}>
                                                            Female
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="gender" value="other"
                                                                {{ old('gender') == 'other' ? 'checked' : '' }}>
                                                            Other
                                                        </label>
                                                    </div>
                                                    @error('gender')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="admission_date">Admission Date</label>
                                                    <input type="date" name="admission_date" class="form-control"
                                                        value="{{ old('admission_date') }}">
                                                    @error('admission_date')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="class_id" class="required-field">Class</label>
                                                    <select name="class_id" id="class_id" class="form-control" required>
                                                        <option value="">-- Select Class --</option>
                                                        @foreach ($classes as $class)
                                                            @php
                                                                // Debug: Check what fee types are available
                                                                $admissionFee = 0;
                                                                $monthlyFee = 0;
                                                                
                                                                foreach ($class->feeStructures as $feeStructure) {
                                                                    if ($feeStructure->feeType) {
                                                                        if (strtolower($feeStructure->feeType->name) == 'admission fee' || 
                                                                            strtolower($feeStructure->feeType->name) == 'admission') {
                                                                            $admissionFee = $feeStructure->amount;
                                                                        }
                                                                        if (strtolower($feeStructure->feeType->name) == 'monthly fee' || 
                                                                            strtolower($feeStructure->feeType->name) == 'monthly') {
                                                                            $monthlyFee = $feeStructure->amount;
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            <option value="{{ $class->id }}"
                                                                    data-admission-fee="{{ $admissionFee }}"
                                                                    data-monthly-fee="{{ $monthlyFee }}"
                                                                    {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                                {{ $class->class_name }}
                                                                {{-- @if($admissionFee > 0 || $monthlyFee > 0)
                                                                    (Admission: {{ $admissionFee }}, Monthly: {{ $monthlyFee }})
                                                                @endif --}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('class_id')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fee Section -->
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="admission_fee" class="required-field">Admission Fee</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="number" name="admission_fee" id="admission_fee" class="form-control"
                                                            placeholder="Enter admission fee" value="{{ old('admission_fee', 0) }}"
                                                            step="0.01" min="0" required>
                                                    </div>
                                                    @error('admission_fee')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                    <div class="fee-info">
                                                        <small class="form-text">
                                                            <strong>Default fee:</strong> $<span id="default_admission_fee" class="font-weight-bold">0.00</span>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="monthly_fee" class="required-field">Monthly Fee</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="number" name="monthly_fee" id="monthly_fee" class="form-control"
                                                            placeholder="Enter monthly fee" value="{{ old('monthly_fee', 0) }}"
                                                            step="0.01" min="0" required>
                                                    </div>
                                                    @error('monthly_fee')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                    <div class="fee-info">
                                                        <small class="form-text">
                                                            <strong>Default fee:</strong> $<span id="default_monthly_fee" class="font-weight-bold">0.00</span>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section">
                                        <h4 class="section-title">Contact Information</h4>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">Phone Number</label>
                                                    <input type="text" name="phone" class="form-control"
                                                        placeholder="Enter phone number" value="{{ old('phone') }}">
                                                    @error('phone')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="blood_group">Blood Group</label>
                                                    <select name="blood_group" class="form-control">
                                                        <option value="">Select Blood Group</option>
                                                        <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                                        <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                                        <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                                        <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                                        <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                        <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                        <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                                        <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                                    </select>
                                                    @error('blood_group')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea name="address" class="form-control" rows="3" placeholder="Enter full address">{{ old('address') }}</textarea>
                                            @error('address')
                                                <p class="text-danger small">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-section">
                                        <h4 class="section-title">Guardian Information</h4>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="guardian_name">Guardian Name</label>
                                                    <input type="text" name="guardian_name" class="form-control"
                                                        placeholder="Enter guardian name"
                                                        value="{{ old('guardian_name') }}">
                                                    @error('guardian_name')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="guardian_phone">Guardian Phone</label>
                                                    <input type="text" name="guardian_phone" class="form-control"
                                                        placeholder="Enter guardian phone"
                                                        value="{{ old('guardian_phone') }}">
                                                    @error('guardian_phone')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-section">
                                        <h4 class="section-title">Additional Information</h4>
                                        <div class="form-group">
                                            <label for="behaviour">Behaviour Notes</label>
                                            <textarea name="behaviour" class="form-control" rows="3" placeholder="Enter behaviour notes">{{ old('behaviour') }}</textarea>
                                            @error('behaviour')
                                                <p class="text-danger small">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <div class="file-upload-container">
                                                    <div class="form-group">
                                                        <label for="image">Profile Image</label>
                                                        <input type="file" id="image-upload" name="image"
                                                            class="form-control-file" accept="image/*"
                                                            onchange="previewImage(this, 'image-preview')">
                                                        <div class="file-requirements">
                                                            <strong>Max file size:</strong> 2MB<br>
                                                            <strong>Formats:</strong> JPG, PNG, GIF
                                                        </div>
                                                        @error('image')
                                                            <p class="text-danger small">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <img id="image-preview" class="profile-image-preview"
                                                        alt="Profile Image Preview">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="file-upload-container">
                                                    <div class="form-group">
                                                        <label for="medical_report">Medical Report</label>
                                                        <input type="file" id="medical-report-upload"
                                                            name="medical_report" class="form-control-file"
                                                            accept=".pdf,.jpg,.png,.doc,.docx"
                                                            onchange="previewDocument(this, 'medical-report-preview', 'medical-report-filename')">
                                                        <div class="file-requirements">
                                                            <strong>Max file size:</strong> 2MB<br>
                                                            <strong>Formats:</strong> PDF, JPG, PNG, DOC, DOCX
                                                        </div>
                                                        @error('medical_report')
                                                            <p class="text-danger small">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <img id="medical-report-preview" class="medical-report-preview"
                                                        alt="Medical Report Preview" style="display: none;">
                                                    <div id="medical-report-filename" class="text-muted small mt-2"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="file-upload-container">
                                                    <div class="form-group">
                                                        <label for="document">Documents</label>
                                                        <input type="file" id="document-upload" name="document"
                                                            class="form-control-file" accept=".pdf,.jpg,.png,.doc,.docx"
                                                            onchange="previewDocument(this, 'document-preview', 'document-filename')">
                                                        <div class="file-requirements">
                                                            <strong>Max file size:</strong> 2MB<br>
                                                            <strong>Formats:</strong> PDF, JPG, PNG, DOC, DOCX
                                                        </div>
                                                        @error('document')
                                                            <p class="text-danger small">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <img id="document-preview" class="document-preview" alt="document"
                                                        style="display: none;">
                                                    <div id="document-filename" class="text-muted small mt-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Create Profile</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        // Initialize datepicker for date of birth
        $('input[name="dob"]').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0',
            maxDate: new Date()
        });

        // Class change event for fees
        $('#class_id').on('change', function() {
            updateFeeFields(this);
        });

        // Initialize fees on page load
        updateFeeFields($('#class_id')[0]);

        // Preview profile image
        $('#image-upload').on('change', function() {
            previewImage(this, 'image-preview');
        });

        // Preview medical report
        $('#medical-report-upload').on('change', function() {
            previewDocument(this, 'medical-report-preview', 'medical-report-filename');
        });

        // Preview document
        $('#document-upload').on('change', function() {
            previewDocument(this, 'document-preview', 'document-filename');
        });
    });

    function updateFeeFields(classSelect) {
        const selectedOption = classSelect.options[classSelect.selectedIndex];
        const admissionFee = parseFloat(selectedOption.getAttribute('data-admission-fee')) || 0;
        const monthlyFee = parseFloat(selectedOption.getAttribute('data-monthly-fee')) || 0;

        console.log('Selected Class Fees - Admission:', admissionFee, 'Monthly:', monthlyFee);

        // Update default fee display
        $('#default_admission_fee').text(admissionFee.toFixed(2));
        $('#default_monthly_fee').text(monthlyFee.toFixed(2));

        // Get current values
        const currentAdmissionFee = parseFloat($('#admission_fee').val()) || 0;
        const currentMonthlyFee = parseFloat($('#monthly_fee').val()) || 0;

        // Only update if current values are 0 or if this is initial load
        if (currentAdmissionFee === 0 || $('#admission_fee').val() === '0' || $('#admission_fee').val() === '0.00') {
            $('#admission_fee').val(admissionFee.toFixed(2));
        }
        
        if (currentMonthlyFee === 0 || $('#monthly_fee').val() === '0' || $('#monthly_fee').val() === '0.00') {
            $('#monthly_fee').val(monthlyFee.toFixed(2));
        }
    }

    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + previewId).attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewDocument(input, previewId, filenameDisplayId) {
        var file = input.files[0];
        if (file) {
            $('#' + filenameDisplayId).text('Selected file: ' + file.name);
            
            // Show preview for images
            if (file.type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result).show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#' + previewId).hide();
            }
        }
    }
</script>
@endsection