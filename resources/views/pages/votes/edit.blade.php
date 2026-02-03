@extends('layouts.master')

@section('title')
    Edit Vote
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterange-picker.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Header -->
            <div class="col-md-12">
                <div class="card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Edit Vote</h5>
                        <a class="btn btn-primary" href="{{ route('votes.index') }}">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Edit -->
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

                        @php
                            $period = old('period');
                            if (!$period && $vote->start_at && $vote->end_at) {
                                $period = $vote->start_at->format('d/m/Y') . ' - ' . $vote->end_at->format('d/m/Y');
                            }
                        @endphp

                        {{-- Form untuk edit vote --}}
                        <form method="POST" action="{{ route('votes.update', $vote->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Date Period -->
                            {{-- <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Period</label>
                                        <input id="vote-period" class="datepicker-here form-control digits" type="text"
                                            name="period" value="{{ $period }}" data-range="true"
                                            data-multiple-dates-separator=" - " data-language="en" autocomplete="off" />
                                    </div>
                                </div>
                            </div> --}}


                            <!-- Date Period 2 -->
                            <div class="mb-3">
                                <label>Date Period</label>
                                <input class="form-control digits" type="text" name="period" id="vote-period2"
                                    value="{{ $period }}" autocomplete="off" required />
                            </div>


                            <!-- Title -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Title</label>
                                        <input class="form-control" type="text" name="title"
                                            value="{{ old('title', $vote->title) }}" required />
                                    </div>
                                </div>
                            </div>

                            <!-- Input Description -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" rows="3">{{ old('description', $vote->description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Candidates (read-only) -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Candidates</label>
                                        <div class="form-control-plaintext py-0">
                                            @foreach ($vote->options as $option)
                                                {{ $loop->iteration }}. {{ $option->label }}<br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Status</label>
                                        <div class="media-body">
                                            <label class="switch">
                                                <!-- hidden input supaya selalu ada value -->
                                                <input type="hidden" name="is_active" value="0">

                                                <!-- checkbox toggle -->
                                                <input type="checkbox" name="is_active" value="1"
                                                    {{ $vote->is_active ? 'checked' : '' }}>

                                                <span class="switch-state"></span>
                                            </label>
                                        </div>
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
        <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
        <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>

        <script>
            $(document).ready(function() {
                // konversi ke format Date
                const start = "{{ $vote->start_at->format('Y-m-d') }}";
                const end = "{{ $vote->end_at->format('Y-m-d') }}";

                const startDate = new Date(start);
                const endDate = new Date(end);

                const picker = $('#vote-period').datepicker({
                    range: true,
                    multipleDatesSeparator: ' - ',
                    language: 'en',
                    dateFormat: 'dd/mm/yyyy',
                }).data('datepicker');

                // tandai range lama di datepicker UI
                picker.selectDate([startDate, endDate]);

                // pastikan input value tetap tampil di input
                $('#vote-period').val(
                    "{{ $vote->start_at->format('d/m/Y') }} - {{ $vote->end_at->format('d/m/Y') }}"
                );
            });
        </script>

        <script src="{{ asset('assets/js/datepicker/daterange-picker/moment.min.js') }}"></script>
        <script src="{{ asset('assets/js/datepicker/daterange-picker/daterangepicker.js') }}"></script>
        <script src="{{ asset('assets/js/datepicker/daterange-picker/daterange-picker.custom.js') }}"></script>
        <script>
            $(function() {
                const $input = $('#vote-period2');

                // ambil value awal dari blade (dd/mm/yyyy - dd/mm/yyyy)
                const initialValue = "{{ $period }}";

                let startDate = null;
                let endDate = null;

                if (initialValue) {
                    const parts = initialValue.split(' - ');
                    if (parts.length === 2) {
                        startDate = moment(parts[0], 'DD/MM/YYYY');
                        endDate = moment(parts[1], 'DD/MM/YYYY');
                    }
                }

                $input.daterangepicker({
                    autoUpdateInput: false,
                    startDate: startDate,
                    endDate: endDate,
                    locale: {
                        format: 'DD/MM/YYYY',
                        separator: ' - '
                    }
                });

                // tampilkan value awal (penting)
                if (startDate && endDate) {
                    $input.val(startDate.format('DD/MM/YYYY') + ' - ' + endDate.format('DD/MM/YYYY'));
                }

                // saat user apply
                $input.on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(
                        picker.startDate.format('DD/MM/YYYY') +
                        ' - ' +
                        picker.endDate.format('DD/MM/YYYY')
                    );
                });

                // blok input manual
                $input.on('keydown paste', function(e) {
                    e.preventDefault();
                });
            });
        </script>
    @endpush
@endsection
