<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --warning-color: #f8961e;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --white: #ffffff;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .dashboard-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background: var(--white);
            box-shadow: var(--card-shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left h1 {
            font-size: 24px;
            color: var(--primary-color);
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .user-profile .dropdown-menu {
            position: absolute;
            right: 0;
            top: 50px;
            background: var(--white);
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            width: 200px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 100;
        }

        .user-profile:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            top: 45px;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px 20px;
            color: var(--dark-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .dropdown-menu a:hover {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .dropdown-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            padding: 20px;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: var(--white);
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .welcome-banner h2 {
            font-size: 28px;
            margin-bottom: 10px;
            position: relative;
        }

        .welcome-banner p {
            max-width: 60%;
            opacity: 0.9;
            position: relative;
        }

        .welcome-banner .icon {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 80px;
            opacity: 0.2;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
        }

        .stat-card.primary::before {
            background: var(--primary-color);
        }

        .stat-card.success::before {
            background: var(--success-color);
        }

        .stat-card.warning::before {
            background: var(--warning-color);
        }

        .stat-card.danger::before {
            background: var(--danger-color);
        }

        .stat-card h3 {
            font-size: 14px;
            color: var(--gray-color);
            margin-bottom: 10px;
        }

        .stat-card .value {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stat-card .icon {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 40px;
            opacity: 0.2;
        }

        /* Profile Section */
        .profile-section {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .profile-section {
                grid-template-columns: 1fr;
            }
        }

        .profile-card {
            background: var(--white);
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            text-align: center;
        }

        .profile-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid rgba(67, 97, 238, 0.1);
            margin-bottom: 15px;
        }

        .profile-card h3 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .profile-card p {
            color: var(--gray-color);
            margin-bottom: 15px;
        }

        .profile-card .badge {
            display: inline-block;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .profile-details {
            background: var(--white);
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
        }

        .profile-details h3 {
            font-size: 18px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        @media (max-width: 576px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
        }

        .detail-item {
            display: flex;
            margin-bottom: 10px;
        }

        .detail-item i {
            width: 30px;
            height: 30px;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .detail-item .label {
            font-weight: 500;
            color: var(--gray-color);
            margin-bottom: 3px;
            font-size: 14px;
        }

        .detail-item .value {
            font-weight: 500;
        }

        /* Documents Section */
        .documents-section {
            margin-top: 20px;
        }

        .documents-section h4 {
            margin-bottom: 15px;
            font-size: 16px;
            color: var(--gray-color);
        }

        .document-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .document-btn {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
        }

        .document-btn:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        .document-btn i {
            margin-right: 8px;
        }

        /* Tables Section */
        .table-section {
            background: var(--white);
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h3 {
            font-size: 18px;
        }

        .table-header a {
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            background: var(--primary-color);
            color: var(--white);
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
        }

        .table-header a:hover {
            background: var(--secondary-color);
        }

        .table-header a i {
            margin-right: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        th {
            font-weight: 600;
            color: var(--gray-color);
            font-size: 14px;
            text-transform: uppercase;
        }

        tr:hover {
            background: rgba(67, 97, 238, 0.03);
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success {
            background: rgba(76, 201, 240, 0.1);
            color: #4cc9f0;
        }

        .badge-warning {
            background: rgba(248, 150, 30, 0.1);
            color: #f8961e;
        }

        .badge-danger {
            background: rgba(247, 37, 133, 0.1);
            color: #f72585;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        /* Financial Section Styles */
        .content {
            padding: 0;
        }

        .card {
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
        }

        .card-header {
            background: var(--white);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-title {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .card-body {
            padding: 20px;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
        }

        .table-bordered {
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        /* Card Color Variants */
        .card-warning {
            border-top: 4px solid var(--warning-color);
        }

        .card-info {
            border-top: 4px solid var(--accent-color);
        }

        .card-success {
            border-top: 4px solid var(--success-color);
        }

        .card-light {
            border-top: 4px solid #f8f9fa;
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-success {
            background: var(--success-color);
            color: var(--white);
        }

        .btn-success:hover {
            background: #3ab0d9;
            color: var(--white);
        }

        .btn-warning {
            background: var(--warning-color);
            color: var(--white);
        }

        .btn-warning:hover {
            background: #e08617;
            color: var(--white);
        }

        .btn-info {
            background: var(--accent-color);
            color: var(--white);
        }

        .btn-info:hover {
            background: #3a7fd9;
            color: var(--white);
        }

        .btn-outline-primary {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-outline-info {
            background: transparent;
            border: 1px solid var(--accent-color);
            color: var(--accent-color);
        }

        .btn-outline-info:hover {
            background: var(--accent-color);
            color: var(--white);
        }

        .btn-outline-secondary {
            background: transparent;
            border: 1px solid var(--gray-color);
            color: var(--gray-color);
        }

        .btn-outline-secondary:hover {
            background: var(--gray-color);
            color: var(--white);
        }

        /* Badge Styles */
        .badge-primary {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .badge-secondary {
            background: rgba(108, 117, 125, 0.1);
            color: var(--gray-color);
        }

        .badge-success {
            background: rgba(76, 201, 240, 0.1);
            color: #4cc9f0;
        }

        .badge-warning {
            background: rgba(248, 150, 30, 0.1);
            color: #f8961e;
        }

        .badge-danger {
            background: rgba(247, 37, 133, 0.1);
            color: #f72585;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-info {
            background: rgba(72, 149, 239, 0.1);
            color: var(--accent-color);
            border-left: 4px solid var(--accent-color);
        }

        /* Info Box Styles */
        .info-box {
            box-shadow: var(--card-shadow);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .info-box-icon {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 15px;
        }

        .info-box-content {
            flex: 1;
        }

        .info-box-text {
            font-size: 14px;
            color: var(--gray-color);
            margin-bottom: 5px;
        }

        .info-box-number {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .progress {
            height: 6px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
            margin-bottom: 5px;
        }

        .progress-bar {
            background: currentColor;
            border-radius: 3px;
        }

        .progress-description {
            font-size: 12px;
            color: var(--gray-color);
        }

        /* Gradient Backgrounds */
        .bg-gradient-success {
            background: linear-gradient(135deg, var(--success-color), #3ab0d9);
            color: white;
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, var(--accent-color), #3a7fd9);
            color: white;
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, var(--danger-color), #d91a6c);
            color: white;
        }

        /* Table Color Variants */
        .table-success {
            background: rgba(76, 201, 240, 0.05) !important;
        }

        .table-info {
            background: rgba(72, 149, 239, 0.05) !important;
        }

        .table-danger {
            background: rgba(247, 37, 133, 0.05) !important;
        }

        /* Card Tools */
        .card-tools {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-tools-left {
            margin-right: auto;
        }

        .card-tools-right {
            margin-left: auto;
        }

        .btn-tool {
            background: transparent;
            border: none;
            color: var(--gray-color);
            padding: 5px;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-tool:hover {
            background: rgba(0, 0, 0, 0.05);
            color: var(--dark-color);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .welcome-banner p {
                max-width: 100%;
            }

            .welcome-banner .icon {
                display: none;
            }

            /* Header adjustments for tablet */
            .header-left h1 {
                font-size: 20px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 200px;
            }

            .header-left span strong {
                font-size: 14px;
                padding: 3px 8px;
            }

            .card-header {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .card-tools {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            /* Mobile header fixes */
            .header {
                flex-direction: row !important;
                align-items: center;
                padding: 10px 15px;
                flex-wrap: nowrap;
            }

            .header-left {
                flex: 1;
                min-width: 0;
                display: flex;
                align-items: center;
            }

            .header-left>div {
                display: flex;
                align-items: center;
                flex-wrap: nowrap;
                overflow: hidden;
            }

            .header-left h1 {
                margin-right: 10px;
                max-width: 150px;
            }

            .header-left span {
                margin: 0;
            }

            .header-right {
                margin-top: 0 !important;
                width: auto !important;
                justify-content: flex-end !important;
            }

            .user-profile span {
                display: none;
            }

            .user-profile .dropdown-menu {
                right: 0;
                left: auto;
            }

            /* Other mobile adjustments */
            .welcome-banner {
                padding: 20px;
            }

            .welcome-banner h2 {
                font-size: 20px;
            }

            .profile-card {
                padding: 15px;
            }

            .profile-card h3 {
                font-size: 18px;
            }

            .profile-details {
                padding: 15px;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            th,
            td {
                padding: 8px 10px;
                font-size: 13px;
            }

            .info-box {
                flex-direction: column;
                text-align: center;
            }

            .info-box-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Header with Logout -->
        <header class="header">
            <div class="header-left">
                <div>
                    <h1 style="display: inline-block; margin-right: 15px;">Student Dashboard</h1>
                    <span style="display: inline-block;">
                        @if ($student->status == 'on')
                            <strong style="color:#ffffff; background-color:#28a745; padding: 5px; border-radius: 5px;">
                                <i class="fa fa-user-check"></i> Current Student
                            </strong>
                        @else
                            <strong style="color:#000000; background-color:#ffff00; padding: 5px; border-radius: 5px;">
                                <i class="fa fa-user-check"></i> Recovered Student
                            </strong>
                        @endif
                    </span>
                </div>
            </div>

          @include('setting::droupdown')
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Welcome Banner -->
            <section class="welcome-banner">
                <h2>Welcome back, {{ $student->full_name }}!</h2>
                <p>Track your rehabilitation progress, financial details, and stay updated with important announcements.
                </p>
                <i class="fas fa-heartbeat"></i>
            </section>

            <!-- Profile Section -->
            <section class="profile-section">
                <div class="profile-card">
                    @if ($student->image)
                        <img src="{{ asset('upload/images/Students/' . $student->image) }}" alt="Student Photo"
                            style="width: 200px; height: 200px; object-fit: cover; border: 5px solid #e9ecef;"
                            class="rounded-circle shadow">
                    @else
                        <div class="no-avatar bg-light p-4 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 200px; height: 200px; margin: 0 auto;">
                            <i class="fas fa-user-graduate fa-5x text-muted"></i>
                        </div>
                    @endif
                    <h3>{{ $student->full_name }}</h3>
                    <p>{{ $student->user->email }}</p>
                    <span class="badge badge-primary">{{ ucfirst($student->gender) }}</span>

                    <div class="documents-section mt-3">
                        <h4>Documents</h4>
                        <div class="document-buttons">
                            @if ($student->medical_report)
                                <a href="{{ asset('upload/files/Students/' . $student->medical_report) }}"
                                    class="btn btn-outline-info mb-2" target="_blank">
                                    <i class="fas fa-file-medical mr-2"></i> Medical Report
                                </a>
                            @endif
                            @if ($student->document)
                                <a href="{{ asset('upload/files/Students/' . $student->document) }}"
                                    class="btn btn-outline-secondary" target="_blank">
                                    <i class="fas fa-file-alt mr-2"></i> View Documents
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="profile-details">
                    <h3>Personal Information</h3>
                    <div class="details-grid">
                        <div class="detail-item">
                            <i class="fas fa-user"></i>
                            <div>
                                <div class="label">Full Name</div>
                                <div class="value">{{ $student->full_name }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-venus-mars"></i>
                            <div>
                                <div class="label">Gender</div>
                                <div class="value">{{ ucfirst($student->gender) }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-birthday-cake"></i>
                            <div>
                                <div class="label">Date of Birth</div>
                                <div class="value">
                                    {{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d M Y') : 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-tint"></i>
                            <div>
                                <div class="label">Blood Group</div>
                                <div class="value">{{ $student->blood_group ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <div class="label">Email</div>
                                <div class="value">{{ $student->user->email }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <div class="label">Phone</div>
                                <div class="value">{{ $student->phone ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <div class="label">Address</div>
                                <div class="value">{{ $student->address ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-user-shield"></i>
                            <div>
                                <div class="label">Guardian</div>
                                <div class="value">{{ $student->guardian_name ?? 'N/A' }}
                                    ({{ $student->guardian_phone ?? 'N/A' }})</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-school"></i>
                            <div>
                                <div class="label">Class</div>
                                <div class="value">{{ $student->classModel->class_name ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <div>
                                <div class="label">Admission Fee</div>
                                <div class="value">${{ number_format($student->admission_fee, 2) }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <div class="label">Monthly Fee</div>
                                <div class="value">${{ number_format($student->monthly_fee, 2) }}</div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-calendar-plus"></i>
                            <div>
                                <div class="label">Admission Date</div>
                                <div class="value">
                                    {{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d M Y') : 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-calendar-check"></i>
                            <div>
                                <div class="label">Recovery Date</div>
                                <div class="value">
                                    @if ($student->recover_date)
                                        <span class="text-success font-weight-bold">
                                            {{ \Carbon\Carbon::parse($student->recover_date)->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted">Not Recovered</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Behaviour Notes -->
                    <div class="behaviour-notes mt-4">
                        <h4><i class="fas fa-smile mr-2"></i>Behaviour Notes</h4>
                        <p class="mb-0">{{ $student->behaviour ?? 'No behaviour notes available.' }}</p>
                    </div>
                </div>
            </section>

            <!-- Fee Calculation & Balance Sheet Section -->
            <section class="content mt-4">
                {{-- <div class="container-fluid"> --}}
                {{-- <div class="row"> --}}
                {{-- <div class="col-12"> --}}
                {{-- <div class="card card-warning"> --}}

                <div class="card-body">


                    <!-- Detailed Breakdown -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-list-alt mr-2"></i>Financial Overview
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="info-box bg-gradient-success">
                                                <span class="info-box-icon"><i class="fas fa-money-check"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Expected Income</span>
                                                    <span class="info-box-number">Rs
                                                        {{ number_format($feeDetails['total_expected_income'], 2) }}</span>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: 100%"></div>
                                                    </div>
                                                    <span class="progress-description">
                                                        Fees + Expenses
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="info-box bg-gradient-info">
                                                <span class="info-box-icon"><i
                                                        class="fas fa-hand-holding-usd"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Actual Collection</span>
                                                    <span class="info-box-number">Rs
                                                        {{ number_format($feeDetails['total_payments'], 2) }}</span>
                                                    <div class="progress">
                                                        <div class="progress-bar"
                                                            style="width: {{ $feeDetails['total_expected_income'] > 0 ? ($feeDetails['total_payments'] / $feeDetails['total_expected_income']) * 100 : 0 }}%">
                                                        </div>
                                                    </div>
                                                    <span class="progress-description">
                                                        {{ $feeDetails['total_expected_income'] > 0 ? number_format(($feeDetails['total_payments'] / $feeDetails['total_expected_income']) * 100, 1) : 0 }}%
                                                        Collected
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="info-box bg-gradient-{{ $feeDetails['remaining_status'] == 'positive' ? 'success' : 'danger' }}">
                                                <span class="info-box-icon">
                                                    <i
                                                        class="fas fa-{{ $feeDetails['remaining_status'] == 'positive' ? 'plus' : 'minus' }}"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">
                                                        @if ($feeDetails['remaining_status'] == 'positive')
                                                            Advance Payment
                                                        @else
                                                            Due Amount
                                                        @endif
                                                    </span>
                                                    <span class="info-box-number">Rs
                                                        {{ number_format(abs($feeDetails['remaining_money']), 2) }}</span>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: 100%"></div>
                                                    </div>
                                                    <span class="progress-description">
                                                        @if ($feeDetails['remaining_status'] == 'positive')
                                                            You have advance
                                                        @else
                                                            Payment required
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Calculation Formula -->
                                    <div class="mt-3 p-3 bg-light rounded">
                                        <h6 class="text-center mb-2"><strong>Calculation Formula</strong></h6>
                                        <div class="text-center">
                                            <code>
                                                Expected Income = Admission Fee + Monthly Fees + Expenses<br>
                                                Balance = Total Payments - Expected Income<br>
                                                @if ($feeDetails['remaining_status'] == 'positive')
                                                    <span class="text-success">Positive Balance = Advance
                                                        Payment</span><br>
                                                    <span class="text-success">Negative Balance = Due Amount</span>
                                                @else
                                                    <span class="text-danger">Positive Balance = Advance
                                                        Payment</span><br>
                                                    <span class="text-danger">Negative Balance = Due Amount</span>
                                                @endif
                                            </code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}
                </div>
            </section>

            <!-- Expenses Section -->
            <section class="content mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <!-- Left: Collapse Button -->
                                    <div class="card-tools-left">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>

                                    <!-- Center: Title -->
                                    <h3
                                        class="card-title mb-0 text-center flex-grow-1 d-flex justify-content-center align-items-center">
                                        <i class="fas fa-money-bill-wave mr-2 text-success"></i>
                                        Student Expenses
                                    </h3>

                                    <!-- Right: Add Expense Button -->
                                    @can('create_single_expenses')
                                        <div class="card-tools-right">
                                            <a href="{{ route('expenses.create.current', ['student_id' => $student->id]) }}"
                                                class="btn btn-sm btn-success text-white">
                                                <i class="fa fa-plus"></i> Add Expense
                                            </a>
                                        </div>
                                    @endcan
                                </div>

                                <div class="card-body">
                                    @if ($student->expenses->count() > 0)
                                        <div class="table-responsive">
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Expense Type</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Due</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($student->expenses as $expense)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $expense->expenseType->name ?? 'N/A' }}</td>
                                                            <td>Rs {{ number_format($expense->amount, 2) }}</td>
                                                            <td>Rs {{ number_format($expense->paid_amount, 2) }}</td>
                                                            <td>Rs {{ number_format($expense->due_amount, 2) }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge badge-{{ $expense->status == 'paid' ? 'success' : ($expense->status == 'partial' ? 'warning' : 'danger') }}">
                                                                    {{ ucfirst($expense->status) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $expense->expense_date ? \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') : 'N/A' }}
                                                            </td>
                                                            <td>{{ $expense->description ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr class="table-info">
                                                        <td colspan="2" class="text-right"><strong>Totals:</strong>
                                                        </td>
                                                        <td><strong>Rs
                                                                {{ number_format($student->expenses->sum('amount'), 2) }}</strong>
                                                        </td>
                                                        <td><strong>Rs
                                                                {{ number_format($student->expenses->sum('paid_amount'), 2) }}</strong>
                                                        </td>
                                                        <td><strong>Rs
                                                                {{ number_format($student->expenses->sum('due_amount'), 2) }}</strong>
                                                        </td>
                                                        <td colspan="3"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info text-center">
                                            <i class="fas fa-info-circle mr-2"></i>No expenses found for this student.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Payments Section -->
            <section class="content mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-success">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <!-- Left: Collapse Button -->
                                    <div class="card-tools-left">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>

                                    <!-- Center: Title -->
                                    <h3
                                        class="card-title mb-0 text-center flex-grow-1 d-flex justify-content-center align-items-center">
                                        <i class="fas fa-credit-card mr-2 text-primary"></i>
                                        Payment History
                                    </h3>

                                    <!-- Right: Add Payment Button -->
                                    @can('create_single_payments')
                                        <div class="card-tools-right">
                                            <a href="{{ route('payments.createForStudent', ['student_id' => $student->id]) }}"
                                                class="btn btn-warning btn-sm text-white">
                                                <i class="fa fa-plus"></i> Add Payment
                                            </a>
                                        </div>
                                    @endcan
                                </div>

                                <div class="card-body">
                                    @if ($student->payments->count() > 0)
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Payment Date</th>
                                                        <th>Total Amount</th>
                                                        <th>Payment Method</th>
                                                        <th>Status</th>
                                                        <th>Receipt</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($student->payments as $payment)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                                            </td>
                                                            <td>Rs {{ number_format($payment->total_amount, 2) }}</td>
                                                            <td>
                                                                <span class="badge badge-secondary">
                                                                    {{ ucfirst($payment->payment_method) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge badge-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                                                    {{ ucfirst($payment->status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if ($payment->image)
                                                                    <a href="{{ asset('storage/' . $payment->image) }}"
                                                                        class="btn btn-sm btn-outline-primary"
                                                                        target="_blank">
                                                                        <i class="fas fa-receipt mr-1"></i>View
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">N/A</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $payment->remarks ?? '-' }}</td>
                                                            <td>
                                                                <a href="{{ route('payments.show', $payment->id) }}"
                                                                    class="btn btn-sm btn-info" title="View Details">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr class="table-info">
                                                        <td colspan="2" class="text-right"><strong>Total
                                                                Paid:</strong>
                                                        </td>
                                                        <td><strong>Rs
                                                                {{ number_format($student->payments->sum('total_amount'), 2) }}</strong>
                                                        </td>
                                                        <td colspan="5"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info text-center">
                                            <i class="fas fa-info-circle mr-2"></i>No payment history found for this
                                            student.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        

            // Card collapse functionality
            const collapseButtons = document.querySelectorAll('[data-card-widget="collapse"]');
            collapseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const card = this.closest('.card');
                    const cardBody = card.querySelector('.card-body');
                    const icon = this.querySelector('i');

                    if (cardBody.style.display === 'none') {
                        cardBody.style.display = 'block';
                        icon.classList.remove('fa-plus');
                        icon.classList.add('fa-minus');
                    } else {
                        cardBody.style.display = 'none';
                        icon.classList.remove('fa-minus');
                        icon.classList.add('fa-plus');
                    }
                });
            });
    
    </script>
</body>

</html>
