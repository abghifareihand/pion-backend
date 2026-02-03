@extends('layouts.master')

@section('title')
    Detail User
@endsection

@push('css')
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Header -->
            <div class="col-md-12">
                <div class="card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Detail User</h5>
                        <a class="btn btn-primary" href="{{ route('users.index') }}">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Detail -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <!-- Baris 1 -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Name</label>
                                    <div class="form-control-plaintext py-0">
                                        {{ $user->name }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Username</label>
                                    <div class="form-control-plaintext py-0">
                                        {{ $user->username }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Baris 2 -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Email</label>
                                    <div class="form-control-plaintext py-0">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Phone</label>
                                    <div class="form-control-plaintext py-0">
                                        {{ $user->phone ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Baris 3 -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Role</label>
                                    <div class="form-control-plaintext py-0">
                                        {{ $user->role }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>PIN</label>
                                    <div class="form-control-plaintext py-0">
                                        {{ $user->pin}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
@endsection
