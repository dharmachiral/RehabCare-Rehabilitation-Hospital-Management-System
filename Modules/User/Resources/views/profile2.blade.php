<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
            padding: 20px;
        }

        .profile-header {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .profile-card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: none;
            margin-bottom: 30px;
            height: 100%;
        }

        .profile-card .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }

        .profile-card .card-body {
            padding: 25px;
        }

        .profile-img-container {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            position: relative;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-img-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: 4px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #5a5c69;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 8px 25px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            display: none;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .required-asterisk {
            color: #dc3545;
            font-weight: bold;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Profile Header -->
        <div class="profile-header">
            <h3>Hello, <span class="text-primary">{{ $student->full_name ?? '' }}</span></h3>
            <p class="text-muted">Change your profile information & password from here...</p>
        </div>

        <div class="row">
            <!-- Profile Update Card -->
            <div class="col-lg-6 mb-4">
                <div class="profile-card card">
                    <div class="card-header">
                        <i class="fas fa-user-edit me-2"></i> Profile Information
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="text-center mb-4">
                                @if($student->image ?? false)
                                    <div class="profile-img-container">
                                        <img class="profile-img"
                                             src="{{ asset('upload/images/Students/' . $student->image) }}"
                                             alt="Profile Image">
                                    </div>
                                @else
                                    <div class="profile-img-container">
                                        <div class="profile-img-placeholder">
                                            <i class="fas fa-user fa-3x"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Image <span class="required-asterisk">*</span></label>
                                <input type="file" id="file-ip-1" accept="image/*"
                                       class="form-control" onchange="showPreview1(event);" name="student_image">
                                @error('image')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                                <img src="" id="file-ip-1-preview" class="image-preview">
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="required-asterisk">*</span></label>
                                <input class="form-control" type="text" name="full_name" required
                                       value="{{ $student->full_name ?? '' }}">
                                @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="required-asterisk">*</span></label>
                                <input class="form-control" type="email" name="email" required
                                       value="{{ auth()->user()->email }}">
                                @error('email')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="col-lg-6 mb-4">
                <div class="profile-card card">
                    <div class="card-header">
                        <i class="fas fa-key me-2"></i> Change Password
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update.password') }}" method="POST">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password <span class="required-asterisk">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="current_password" required
                                           id="current_password">
                                    <span class="input-group-text toggle-password"
                                          data-target="current_password">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                @error('current_password')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password <span class="required-asterisk">*</span></label>
                                <div class="input-group">
                                    <input class="form-control" type="password" name="password" required
                                           id="password">
                                    <span class="input-group-text toggle-password"
                                          data-target="password">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="required-asterisk">*</span></label>
                                <div class="input-group">
                                    <input class="form-control" type="password" name="password_confirmation" required
                                           id="password_confirmation">
                                    <span class="input-group-text toggle-password"
                                          data-target="password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-2"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        // Image preview function
        function showPreview1(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
