@extends('layouts.app')

@section('title', 'Edit User')

@section('contents')

<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">
                        <i class="fa fa-user-edit me-2 text-primary"></i> Edit User
                    </h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>

            <!-- FORM CARD -->
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-gradient-info text-white text-center py-3">
                            <h3 class="card-title fw-bold"><i class="fa fa-user-circle me-2"></i> Update Profile</h3>
                        </div>
                        <div class="card-body bg-light p-4">

                            @if(session('message'))
                                <div class="alert alert-success text-center fw-semibold">
                                    <i class="fa fa-check-circle me-1"></i> {{ session('message') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger shadow-sm">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li><i class="fa fa-exclamation-circle me-1 text-danger"></i> {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Name --}}
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-bold">User Name</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{ old('name', $user->name) }}" required>
                                </div>

                                {{-- Email --}}
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                           value="{{ old('email', $user->email) }}" required>
                                </div>

                                {{-- Mobile --}}
                                <div class="mb-4">
                                    <label for="mobile" class="form-label fw-bold">Mobile Number</label>
                                    <input type="text" id="mobile" name="mobile" class="form-control"
                                           value="{{ old('mobile', $user->mobile) }}">
                                </div>

                                {{-- Permission --}}
                                <div class="mb-4">
                                    <label for="permission" class="form-label fw-bold">Permission</label>
                                    <select name="permission" id="permission" class="form-control" required>
                                        <option value="1" {{ old('permission', $user->permission) == 1 ? 'selected' : '' }}>Admin</option>
                                        <option value="2" {{ old('permission', $user->permission) == 2 ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>

                                {{-- Designation --}}
                                <div class="mb-4">
                                    <label for="designation" class="form-label fw-bold">Designation</label>
                                    <input type="text" id="designation" name="designation" class="form-control"
                                           value="{{ old('designation', $user->designation) }}">
                                </div>

                                {{-- Profile Photo --}}
                                <div class="mb-4">
                                    <label for="profile_photo_path" class="form-label fw-bold">Profile Photo</label>
                                    <input type="file" id="profile_photo_path" name="profile_photo_path"
                                           class="dropify form-control" data-height="200"
                                           data-default-file="{{ $user->profile_photo_url }}"
                                           accept="image/*">
                                    <div class="mt-3 text-center">
                                        <img src="{{ $user->profile_photo_url }}" alt="Current Photo"
                                             class="rounded shadow-sm" width="120" height="120" style="object-fit: cover;">
                                        <p class="small text-muted mt-2">Current photo</p>
                                    </div>
                                </div>

                                {{-- About --}}
                                <div class="mb-4">
                                    <label for="about" class="form-label fw-bold">About</label>
                                    <textarea id="about" name="about" class="form-control" rows="3">{{ old('about', $user->about) }}</textarea>
                                </div>

                                {{-- Address --}}
                                <div class="mb-4">
                                    <label for="address" class="form-label fw-bold">Address</label>
                                    <textarea id="address" name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                                </div>

                                {{-- Password --}}
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                           placeholder="Leave blank to keep current password" autocomplete="off">
                                </div>

                                {{-- Submit --}}
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary fw-bold">
                                        <i class="fa fa-save me-1"></i> Update User
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary fw-bold ms-2">
                                        <i class="fa fa-arrow-left me-1"></i> Cancel
                                    </a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- END ROW -->

        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove':  'Remove',
                'error':   'Ooops, something wrong happened.'
            }
        });
    });
</script>
@endpush
