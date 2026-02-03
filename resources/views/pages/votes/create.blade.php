@extends('layouts.master')

@section('title')
    Create Vote
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/date-picker.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Header Create -->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Teks di kiri --}}
                        <h5 class="fw-bold mb-0">Create Vote</h5>

                        {{-- Tombol di kanan --}}
                        <a class="btn btn-primary" href="{{ route('votes.index') }}">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Create -->
            <div class="col-md-12">
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


                        <form method="POST" action="{{ route('votes.store') }}">
                            @csrf

                            <!-- Input Title -->
                            <div class="mb-3">
                                <label>Title Vote</label>
                                <input class="form-control" type="text" name="title" value="{{ old('title') }}"
                                    required />
                            </div>

                            {{-- Select Candidates --}}
                            <div class="mb-3">
                                <label>Select Candidates</label>
                                <div class="row">
                                    @foreach ($users as $user)
                                        <div class="col-md-6">
                                            <label class="d-block" for="user_{{ $user->id }}">
                                                <input class="checkbox_animated" id="user_{{ $user->id }}"
                                                    type="checkbox" name="options[]" value="{{ $user->id }}"
                                                    {{ in_array($user->id, old('options', [])) ? 'checked' : '' }}>
                                                {{ $user->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Date Period --}}
                            <div class="mb-3">
                                <label>Date Period</label>
                                <input id="vote-period" class="datepicker-here form-control digits" type="text"
                                    name="period" data-range="true" data-multiple-dates-separator=" - " data-language="en"
                                    autocomplete="off" />

                            </div>


                            <!-- Button Submit -->
                            <div class="row">
                                <div class="col">
                                    <div class="text-end">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-save me-1"></i> Submit
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
        <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
        <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>

        <script>
            $('#vote-period').datepicker({
                range: true,
                multipleDatesSeparator: ' - ',
                language: 'en',
                dateFormat: 'dd/mm/yyyy'
            });
        </script>
    @endpush
@endsection
