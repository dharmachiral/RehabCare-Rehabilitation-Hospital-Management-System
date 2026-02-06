@extends('setting::layouts.master')

@section('title', 'Edit Role')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('style')
    <style>
        .custom-control-label {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Role <i class="bi bi-check"></i>
                                </button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Role Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" required
                                            value="{{ $role->name }}">
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label for="permissions">
                                            Permissions <span class="text-danger">*</span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="select-all">
                                            <label class="custom-control-label" for="select-all">Give All
                                                Permissions</label>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <!-- User Management Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    User Mangement
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_user_management" name="permissions[]"
                                                                    value="access_user_management"
                                                                    {{ $role->hasPermissionTo('access_user_management') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_user_management">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_own_profile" name="permissions[]"
                                                                    value="edit_own_profile"
                                                                    {{ $role->hasPermissionTo('edit_own_profile') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_own_profile">Own Profile</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Settings -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Settings
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_settings" name="permissions[]"
                                                                    value="access_settings"
                                                                    {{ $role->hasPermissionTo('access_settings') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_settings">Access</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sliders Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Sliders
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_sliders" name="permissions[]"
                                                                    value="access_sliders"
                                                                    {{ $role->hasPermissionTo('access_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_sliders">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_sliders" name="permissions[]"
                                                                    value="show_sliders"
                                                                    {{ $role->hasPermissionTo('show_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_sliders">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_sliders" name="permissions[]"
                                                                    value="create_sliders"
                                                                    {{ $role->hasPermissionTo('create_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_sliders">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_sliders" name="permissions[]"
                                                                    value="edit_sliders"
                                                                    {{ $role->hasPermissionTo('edit_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_sliders">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_sliders" name="permissions[]"
                                                                    value="delete_sliders"
                                                                    {{ $role->hasPermissionTo('delete_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_sliders">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Blogs Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Blogs
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_blogs" name="permissions[]"
                                                                    value="access_blogs"
                                                                    {{ $role->hasPermissionTo('access_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_blogs">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_blogs" name="permissions[]"
                                                                    value="show_blogs"
                                                                    {{ $role->hasPermissionTo('show_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_blogs">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_blogs" name="permissions[]"
                                                                    value="create_blogs"
                                                                    {{ $role->hasPermissionTo('create_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_blogs">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_blogs" name="permissions[]"
                                                                    value="edit_blogs"
                                                                    {{ $role->hasPermissionTo('edit_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_blogs">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_blogs" name="permissions[]"
                                                                    value="delete_blogs"
                                                                    {{ $role->hasPermissionTo('delete_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_blogs">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Advertisements Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Treatments
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_treatments" name="permissions[]"
                                                                    value="access_treatments"
                                                                    {{ $role->hasPermissionTo('access_treatments') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_treatments">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_treatments" name="permissions[]"
                                                                    value="show_treatments"
                                                                    {{ $role->hasPermissionTo('show_treatments') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_treatments">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_treatments" name="permissions[]"
                                                                    value="create_treatments"
                                                                    {{ $role->hasPermissionTo('create_treatments') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_treatments">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_treatments" name="permissions[]"
                                                                    value="edit_treatments"
                                                                    {{ $role->hasPermissionTo('edit_treatments') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_treatments">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_treatments" name="permissions[]"
                                                                    value="delete_treatments"
                                                                    {{ $role->hasPermissionTo('delete_treatments') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_treatments">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Teams Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Teams
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_teams" name="permissions[]"
                                                                    value="access_teams"
                                                                    {{ $role->hasPermissionTo('access_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_teams">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_teams" name="permissions[]"
                                                                    value="show_teams"
                                                                    {{ $role->hasPermissionTo('show_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_teams">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_teams" name="permissions[]"
                                                                    value="create_teams"
                                                                    {{ $role->hasPermissionTo('create_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_teams">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_teams" name="permissions[]"
                                                                    value="edit_teams"
                                                                    {{ $role->hasPermissionTo('edit_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_teams">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_teams" name="permissions[]"
                                                                    value="delete_teams"
                                                                    {{ $role->hasPermissionTo('delete_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_teams">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Faqs Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Faqs
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_faqs" name="permissions[]"
                                                                    value="access_faqs"
                                                                    {{ $role->hasPermissionTo('access_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_faqs">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_faqs" name="permissions[]"
                                                                    value="show_faqs"
                                                                    {{ $role->hasPermissionTo('show_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_faqs">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_faqs" name="permissions[]"
                                                                    value="create_faqs"
                                                                    {{ $role->hasPermissionTo('create_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_faqs">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_faqs" name="permissions[]"
                                                                    value="edit_faqs"
                                                                    {{ $role->hasPermissionTo('edit_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_faqs">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_faqs" name="permissions[]"
                                                                    value="delete_faqs"
                                                                    {{ $role->hasPermissionTo('delete_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_faqs">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Testimonials Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Testimonials
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_testimonials" name="permissions[]"
                                                                    value="access_testimonials"
                                                                    {{ $role->hasPermissionTo('access_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_testimonials">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_testimonials" name="permissions[]"
                                                                    value="show_testimonials"
                                                                    {{ $role->hasPermissionTo('show_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_testimonials">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_testimonials" name="permissions[]"
                                                                    value="create_testimonials"
                                                                    {{ $role->hasPermissionTo('create_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_testimonials">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_testimonials" name="permissions[]"
                                                                    value="edit_testimonials"
                                                                    {{ $role->hasPermissionTo('edit_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_testimonials">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_testimonials" name="permissions[]"
                                                                    value="delete_testimonials"
                                                                    {{ $role->hasPermissionTo('delete_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_testimonials">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Services Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Services
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_services" name="permissions[]"
                                                                    value="access_services"
                                                                    {{ $role->hasPermissionTo('access_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_services">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_services" name="permissions[]"
                                                                    value="show_services"
                                                                    {{ $role->hasPermissionTo('show_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_services">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_services" name="permissions[]"
                                                                    value="create_services"
                                                                    {{ $role->hasPermissionTo('create_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_services">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_services" name="permissions[]"
                                                                    value="edit_services"
                                                                    {{ $role->hasPermissionTo('edit_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_services">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_services" name="permissions[]"
                                                                    value="delete_services"
                                                                    {{ $role->hasPermissionTo('delete_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_services">Delete</label>
                                                            </div>
                                                        </div>
                                                          <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="baf_services" name="permissions[]"
                                                                    value="baf_services"
                                                                    {{ $role->hasPermissionTo('baf_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="baf_services">update B/A</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Students permissions --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Students
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_students" name="permissions[]"
                                                                    value="access_students"
                                                                    {{ $role->hasPermissionTo('access_students') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_students">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_students" name="permissions[]"
                                                                    value="show_students"
                                                                    {{ $role->hasPermissionTo('show_students') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_students">View Current Student</label>
                                                            </div>
                                                        </div>
                                                         <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_students2" name="permissions[]"
                                                                    value="show_students2"
                                                                    {{ $role->hasPermissionTo('show_students2') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_students2">View Recover Student</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="view_students" name="permissions[]"
                                                                    value="view_students"
                                                                    {{ $role->hasPermissionTo('view_students') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="view_students">View Profile</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_students" name="permissions[]"
                                                                    value="create_students"
                                                                    {{ $role->hasPermissionTo('create_students') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_students">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_students" name="permissions[]"
                                                                    value="edit_students"
                                                                    {{ $role->hasPermissionTo('edit_students') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_students">Edit</label>
                                                            </div>
                                                        </div>
                                                         <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_fee" name="permissions[]"
                                                                    value="edit_fee"
                                                                    {{ $role->hasPermissionTo('edit_fee') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_fee">Fee</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_students" name="permissions[]"
                                                                    value="delete_students"
                                                                    {{ $role->hasPermissionTo('delete_students') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_students">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Expenses
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_expenses" name="permissions[]"
                                                                    value="show_expenses"
                                                                    {{ $role->hasPermissionTo('show_expenses') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_expenses">access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_expenses" name="permissions[]"
                                                                    value="create_expenses"
                                                                    {{ $role->hasPermissionTo('create_expenses') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_expenses">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_expenses" name="permissions[]"
                                                                    value="edit_expenses"
                                                                    {{ $role->hasPermissionTo('edit_expenses') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_expenses">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_expenses" name="permissions[]"
                                                                    value="delete_expenses"
                                                                    {{ $role->hasPermissionTo('delete_expenses') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_expenses">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                          <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow">
                                        <div class="card-header">
                                            Payments
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="access_payments" name="permissions[]"
                                                               value="access_payments" {{ $role->hasPermissionTo('access_payments') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="access_payments">Access</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="show_payments" name="permissions[]"
                                                               value="show_payments" {{ $role->hasPermissionTo('show_payments') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="show_payments">View</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="create_payments" name="permissions[]"
                                                               value="create_payments" {{ $role->hasPermissionTo('create_payments') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="create_payments">Create</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="edit_payments" name="permissions[]"
                                                               value="edit_payments" {{ $role->hasPermissionTo('edit_payments') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="edit_payments">Edit</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="delete_payments" name="permissions[]"
                                                               value="delete_payments" {{ $role->hasPermissionTo('delete_payments') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="delete_payments">Delete</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="manage_fee_structures" name="permissions[]"
                                                               value="manage_fee_structures" {{ $role->hasPermissionTo('manage_fee_structures') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="manage_fee_structures">fee structure</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 
                                
                                {{-- balance sheet & Finance Summary --}}
                                  <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow">
                                        <div class="card-header">
                                            balance sheet & Finance Summary
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                              <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="access_balance" name="permissions[]"
                                                               value="access_balance" {{ $role->hasPermissionTo('access_balance') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="access_balance">Access  balance sheet</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="access_finance" name="permissions[]"
                                                               value="access_finance" {{ $role->hasPermissionTo('access_finance') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="access_finance">Finance Summary</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="create_deposits" name="permissions[]"
                                                               value="create_deposits" {{ $role->hasPermissionTo('create_deposits') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="create_deposits">Create Deposits</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- single expenses and payment --}}
                                 <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow">
                                        <div class="card-header">
                                            Single Expenses and payments
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                             <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="create_single_expenses" name="permissions[]"
                                                               value="create_single_expenses" {{ $role->hasPermissionTo('create_single_expenses') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="create_single_expenses">access expenses</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="create_single_payments" name="permissions[]"
                                                               value="create_single_payments" {{ $role->hasPermissionTo('create_single_payments') ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="create_single_payments">access payment</label>
                                                    </div>
                                                </div>
                            
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                           
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Gallery
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_galleries" name="permissions[]"
                                                                    value="access_galleries"
                                                                    {{ $role->hasPermissionTo('access_galleries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_galleries">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_galleries" name="permissions[]"
                                                                    value="show_galleries"
                                                                    {{ $role->hasPermissionTo('show_galleries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_galleries">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_galleries" name="permissions[]"
                                                                    value="create_galleries"
                                                                    {{ $role->hasPermissionTo('create_galleries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_galleries">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_galleries" name="permissions[]"
                                                                    value="edit_galleries"
                                                                    {{ $role->hasPermissionTo('edit_galleries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_galleries">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_galleries" name="permissions[]"
                                                                    value="delete_galleries"
                                                                    {{ $role->hasPermissionTo('delete_galleries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_galleries">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Appointments/Inquiries
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_appointments" name="permissions[]"
                                                                    value="access_appointments"
                                                                    {{ $role->hasPermissionTo('access_appointments') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_appointments">Access Appointments</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_inquiries" name="permissions[]"
                                                                    value="access_inquiries"
                                                                    {{ $role->hasPermissionTo('access_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_inquiries">Access Inquiries</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_appointments" name="permissions[]"
                                                                    value="show_appointments"
                                                                    {{ $role->hasPermissionTo('show_appointments') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_appointments">View Appointments</label>
                                                            </div>
                                                        </div>
                                                         <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_inquiries" name="permissions[]"
                                                                    value="show_inquiries"
                                                                    {{ $role->hasPermissionTo('show_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_inquiries">View Inquiries</label>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_appointments" name="permissions[]"
                                                                    value="delete_appointments"
                                                                    {{ $role->hasPermissionTo('delete_appointments') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_appointments">Delete Appointments</label>
                                                            </div>
                                                        </div>
                                                          <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_inquiries" name="permissions[]"
                                                                    value="delete_inquiries"
                                                                    {{ $role->hasPermissionTo('delete_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_inquiries">Delete Inquiries</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- service category permission --}}
                                        {{-- <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Services Category
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_service_category" name="permissions[]"
                                                                    value="access_service_category"
                                                                    {{ $role->hasPermissionTo('access_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_service_category">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_service_category" name="permissions[]"
                                                                    value="show_service_category"
                                                                    {{ $role->hasPermissionTo('show_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_service_category">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_service_category" name="permissions[]"
                                                                    value="create_service_category"
                                                                    {{ $role->hasPermissionTo('create_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_service_category">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_service_category" name="permissions[]"
                                                                    value="edit_service_category"
                                                                    {{ $role->hasPermissionTo('edit_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_service_category">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_service_category" name="permissions[]"
                                                                    value="delete_service_category"
                                                                    {{ $role->hasPermissionTo('delete_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_service_category">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}


                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#select-all').click(function() {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function() {
                    this.checked = checked;
                });
            })
        });
    </script>
@endsection
