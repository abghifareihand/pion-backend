@extends('layouts.master')

@section('title')
    Edit User
@endsection

@push('css')
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Header Edit -->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Teks di kiri --}}
                        <h5 class="fw-bold mb-0">Edit User</h5>

                        {{-- Tombol di kanan --}}
                        <a class="btn btn-primary" href="{{ route('users.index') }}">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>


            <!-- Card Edit -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Alert sukses --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Alert Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Form untuk edit user --}}
                        <form method="POST" action="{{ route('users.update', $user->id) }}" class="form theme-form">
                            @csrf
                            @method('PUT')

                            <!-- Input Name -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Name</label>
                                        <input class="form-control" type="text" name="name"
                                            value="{{ old('name', $user->name) }}" required />
                                    </div>
                                </div>
                            </div>

                            <!-- Input Username -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Username</label>
                                        <input class="form-control" type="text" name="username"
                                            value="{{ old('username', $user->username) }}" required />
                                    </div>
                                </div>
                            </div>

                            <!-- Input Email -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input class="form-control" type="email" name="email"
                                            value="{{ old('email', $user->email) }}" required />
                                    </div>
                                </div>
                            </div>

                            <!-- Input Phone -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Phone</label>
                                        <input class="form-control" type="text" name="phone"
                                            value="{{ old('phone', $user->phone) }}" />
                                    </div>
                                </div>
                            </div>

                            <!-- Input PIN -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>PIN</label>
                                        <input class="form-control" type="text" name="pin"
                                            value="{{ old('pin', $user->pin) }}" required />
                                    </div>
                                </div>
                            </div>

                            <!-- Input Password -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Password</label>
                                        <input class="form-control" type="text" name="password" />
                                        <small class="text-muted">
                                            Kosongkan jika tidak ingin mengubah password
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Button Update -->
                            <div class="row">
                                <div class="col">
                                    <div class="text-end">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-save me-1"></i> Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- End Form --}}

                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
    @endpush
@endsection
