@extends('layouts.master')

@section('title')
    Detail Organization
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
                        <h5 class="fw-bold mb-0">Detail Organization</h5>
                        <a class="btn btn-primary" href="{{ route('organizations.index') }}">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Detail -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">{{ $organization->title }}</h5>

                        {{-- Tampilkan Image jika ada --}}
                        @if ($organization->image_path)
                            <div class="mb-3">
                                <strong>Image:</strong> {{-- <-- label dulu --}}
                                <div>
                                    <img src="{{ asset('storage/' . $organization->image_path) }}"
                                        alt="{{ $organization->title }}" style="max-width: 400px; height: 400px;">
                                </div>
                            </div>
                        @endif

                        {{-- Tampilkan File --}}
                        @if ($organization->file_path)
                            <div class="mb-3">
                                <strong>File:</strong> {{-- label dulu --}}
                                <div style="margin-top: 8px;">
                                    <a href="{{ asset('storage/' . $organization->file_path) }}" target="_blank">
                                        Download
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Optional: Embed PDF --}}
                        @if (Str::endsWith($organization->file_path, '.pdf'))
                            <iframe src="{{ asset('storage/' . $organization->file_path) }}"
                                style="width:100%; height:800px;" frameborder="0"></iframe>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
@endsection
