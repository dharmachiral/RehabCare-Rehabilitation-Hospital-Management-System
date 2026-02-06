@extends('setting::layouts.master')

@section('title', 'Edit Student')
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
@section('content')
    <style>
        .profile-image-preview, .medical-report-preview .document-preview {
            max-width: 200px;
            max-height: 200px;
            border: 2px dashed #ddd;
            border-radius: 5px;
            padding: 5px;
            display: none;
            margin-top: 10px;
        }
        .form-section {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
                        <h1>Update Student Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Students</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
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
                            <form id="user-form" action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-section">
                                        <h4 class="section-title">Basic Information</h4>
                                        <div class="form-row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="full_name" class="required-field">Full Name</label>
                                                    <input type="text" name="full_name" class="form-control"
                                                           placeholder="Enter full name" value="{{ old('full_name', $student->full_name) }}" required>
                                                    @error('full_name')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="class_id" class="required-field">Class</label>
                                                    <select name="class_id" id="class_id" class="form-control" required>
                                                        <option value="">-- Select Class --</option>
                                                        @foreach($classes as $class)
                                                            @php
                                                                // Get fee data for each class
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
                                                                {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                                                {{ $class->class_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('class_id')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="dob">Date of Birth</label>
                                                    <input type="date" name="dob" class="form-control"
                                                           value="{{ old('dob', $student->dob) }}">
                                                    @error('dob')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <div class="gender-radio">
                                                        <label>
                                                            <input type="radio" name="gender" value="male" {{ old('gender', $student->gender) == 'male' ? 'checked' : '' }}>
                                                            Male
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="gender" value="female" {{ old('gender', $student->gender) == 'female' ? 'checked' : '' }}>
                                                            Female
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="gender" value="other" {{ old('gender', $student->gender) == 'other' ? 'checked' : '' }}>
                                                            Other
                                                        </label>
                                                    </div>
                                                    @error('gender')
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
                                                            placeholder="Enter admission fee" value="{{ old('admission_fee', $student->admission_fee) }}"
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
                                                            placeholder="Enter monthly fee" value="{{ old('monthly_fee', $student->monthly_fee) }}"
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

                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email" class="required-field">Username/Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                           placeholder="Enter email" value="{{ old('email', $student->user->email) }}" required>
                                                    @error('email')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" name="password" class="form-control"
                                                           placeholder="New password">
                                                    <small class="form-text text-muted ms-4" style=""><strong style="color:#FF1810 !important">Note:</strong> Leave blank if you don't want to change the password.</small>
                                                    @error('password')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                           placeholder="Confirm password">
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
                                                           placeholder="Enter phone number" value="{{ old('phone', $student->phone) }}">
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
                                                        <option value="A+" {{ old('blood_group', $student->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                                        <option value="A-" {{ old('blood_group', $student->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                                        <option value="B+" {{ old('blood_group', $student->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                                        <option value="B-" {{ old('blood_group', $student->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                                        <option value="AB+" {{ old('blood_group', $student->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                        <option value="AB-" {{ old('blood_group', $student->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                        <option value="O+" {{ old('blood_group', $student->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                                        <option value="O-" {{ old('blood_group', $student->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                                    </select>
                                                    @error('blood_group')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea name="address" class="form-control" rows="3"
                                                      placeholder="Enter full address">{{ old('address', $student->address) }}</textarea>
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
                                                           placeholder="Enter guardian name" value="{{ old('guardian_name', $student->guardian_name) }}">
                                                    @error('guardian_name')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="guardian_phone">Guardian Phone</label>
                                                    <input type="text" name="guardian_phone" class="form-control"
                                                           placeholder="Enter guardian phone" value="{{ old('guardian_phone', $student->guardian_phone) }}">
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
                                            <textarea name="behaviour" class="form-control" rows="3"
                                                      placeholder="Enter behaviour notes">{{ old('behaviour', $student->behaviour) }}</textarea>
                                            @error('behaviour')
                                                <p class="text-danger small">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="image">Image </label>
                                                    <input type="file" accept="image/*"
                                                        class="form-control-file border" value="{{ old('image') }}"
                                                        onchange="showPreview1(event);" name="image">
                                                    <img src="{{ asset('upload/images/Students/'.$student->image ?? 'N/A') }}" width="120px" alt="{{ $student->full_name }}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="medical_report">Medical Report</label>
                                                    <input type="file" accept=".pdf,.jpg,.png,.doc,.docx"
                                                        class="form-control-file border" value="{{ old('medical_report') }}"
                                                        onchange="previewMedicalReport(this, 'medical-report-preview');" name="medical_report">
                                                    <img id="medical-report-preview" src="{{ $student->medical_report ? asset('upload/files/Students/' . $student->medical_report) : '' }}" width="120px" alt="Medical Report Preview" style="{{ $student->medical_report ? 'display: block;' : 'display: none;' }}">
                                                    @error('medical_report')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="document">Documents</label>
                                                    <input type="file" accept=".pdf,.jpg,.png,.doc,.docx"
                                                        class="form-control-file border" value="{{ old('document') }}"
                                                        onchange="previewDocument(this, 'document-preview');" name="document">
                                                    <img id="document-preview" src="{{ $student->document ? asset('upload/files/Students/' . $student->document) : '' }}" width="120px" alt="Document Preview" style="{{ $student->document ? 'display: block;' : 'display: none;' }}">
                                                    @error('document')
                                                        <p class="text-danger small">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                    <a href="{{ route('student.index') }}" class="btn btn-secondary ml-2">Cancel</a>
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

        // Preview functions
        $('#image-upload').on('change', function() {
            previewImage(this, 'image-preview');
        });

        $('#medical-report-upload').on('change', function() {
            previewDocument(this, 'medical-report-preview', 'medical-report-filename');
        });

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

        // For edit form, we don't auto-update the fee fields to preserve existing values
        // But we can show a message if the current fees don't match the default
        const currentAdmissionFee = parseFloat($('#admission_fee').val()) || 0;
        const currentMonthlyFee = parseFloat($('#monthly_fee').val()) || 0;

        if (currentAdmissionFee !== admissionFee) {
            $('#default_admission_fee').addClass('text-warning');
        } else {
            $('#default_admission_fee').removeClass('text-warning');
        }

        if (currentMonthlyFee !== monthlyFee) {
            $('#default_monthly_fee').addClass('text-warning');
        } else {
            $('#default_monthly_fee').removeClass('text-warning');
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

    function showPreview1(event) {
        const input = event.target;
        previewImage(input, 'image-preview');
    }
</script>
@endsection