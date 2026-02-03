@extends('layouts.master')

@section('title')
    Detail Vote
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
                        <h5 class="fw-bold mb-0">Detail Vote</h5>
                        <a class="btn btn-primary" href="{{ route('votes.index') }}">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Detail -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="mb-3">
                            <label>Title</label>
                            <div class="form-control-plaintext py-0">
                                {{ $vote->title }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Total Candidates</label>
                            <div class="form-control-plaintext py-0">
                                @foreach ($vote->options as $option)
                                    {{ $loop->iteration }}. {{ $option->label }}<br>
                                @endforeach
                            </div>
                        </div>


                        <div class="mb-3">
                            <label>Period</label>
                            <div class="form-control-plaintext py-0">
                                {{ optional($vote->start_at)->format('d/m/Y') }}
                                -
                                {{ optional($vote->end_at)->format('d/m/Y') }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <div class="form-control-plaintext py-0">
                                @if ($vote->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
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
