@extends('layouts.master')

@section('title')
    Detail Social
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
                        <h5 class="fw-bold mb-0">Detail Social</h5>
                        <a class="btn btn-primary" href="{{ route('socials.index') }}">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Detail -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">{{ $social->title }}</h5>

                        <p>
                            <strong>File : </strong>
                            <a href="{{ asset('storage/' . $social->file_path) }}" target="_blank">
                                Download
                            </a>
                        </p>

                        {{-- Optional: Embed PDF --}}
                        @if (Str::endsWith($social->file_path, '.pdf'))
                            <iframe src="{{ asset('storage/' . $social->file_path) }}"
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
