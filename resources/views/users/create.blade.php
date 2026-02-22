@extends('layouts.app')

@section('title', 'Create User')

@section('contents')

<div class="app-content main-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">
                        <i class="fa fa-user-plus me-2 text-primary"></i> Create User Form
                    </h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Create User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Layouts</li>
                    </ol>
                </div>
            </div>

            <!-- FORM ROW -->
            <div class="row row-deck">
                <div class="col-lg-8 offset-lg-2 col-md-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-gradient-info text-white text-center py-3">
                            <h3 class="card-title fw-bold"><i class="fa fa-user-edit me-2"></i> Create User</h3>
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

                            <form class="form-horizontal" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Name --}}
                                <div class="row mb-4">
                                    <label for="name" class="col-md-3 form-label">User Name</label>
                                    <div class="col-md-9">
                                        <input type="text" id="name" name="name" class="form-control"
                                               placeholder="User Name" value="{{ old('name') }}" required>
                                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="row mb-4">
                                    <label for="email" class="col-md-3 form-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" id="email" name="email" class="form-control"
                                               placeholder="User Email" value="{{ old('email') }}" required>
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Mobile --}}
                                <div class="row mb-4">
                                    <label for="mobile" class="col-md-3 form-label">Mobile Number</label>
                                    <div class="col-md-9">
                                        <input type="text" id="mobile" name="mobile" class="form-control"
                                               placeholder="User Mobile No" value="{{ old('mobile') }}">
                                        @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Permission --}}
                                <div class="row mb-4">
                                    <label for="permission" class="col-md-3 form-label">Permission</label>
                                    <div class="col-md-9">
                                        <select name="permission" id="permission" class="form-control" required>
                                            <option disabled {{ old('permission') ? '' : 'selected' }}>Select user type</option>
                                            <option value="1" {{ old('permission') == 1 ? 'selected' : '' }}>Admin</option>
                                            <option value="2" {{ old('permission') == 2 ? 'selected' : '' }}>User</option>
                                        </select>
                                        @error('permission') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Designation --}}
                                <div class="row mb-4">
                                    <label for="designation" class="col-md-3 form-label">Designation</label>
                                    <div class="col-md-9">
                                        <input type="text" id="designation" name="designation" class="form-control"
                                               placeholder="User designation" value="{{ old('designation') }}">
                                        @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Profile Photo --}}
                                <div class="row mb-4">
                                    <label for="profile_photo_path" class="col-md-3 form-label">User Photo</label>
                                    <div class="col-md-9">
                                        <input type="file" id="profile_photo_path" name="profile_photo_path"
                                               class="dropify form-control" data-height="200"
                                               data-default-file="{{ asset('images/default-user.png') }}">
                                        @error('profile_photo_path') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- About --}}
                                <div class="row mb-4">
                                    <label for="about" class="col-md-3 form-label">About</label>
                                    <div class="col-md-9">
                                        <textarea id="about" name="about" class="form-control" rows="3">{{ old('about') }}</textarea>
                                        @error('about') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Address --}}
                                <div class="row mb-4">
                                    <label for="address" class="col-md-3 form-label">Address</label>
                                    <div class="col-md-9">
                                        <textarea id="address" name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="row mb-4">
                                    <label for="password" class="col-md-3 form-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" id="password" name="password" class="form-control"
                                               placeholder="User Password" autocomplete="off" required>
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="row mb-4">
                                    <label class="col-md-3 form-label"></label>
                                    <div class="col-md-9">
                                        <button type="submit" class="btn btn-primary fw-bold">
                                            <i class="fa fa-check me-1"></i> Create User
                                        </button>
                                    </div>
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
