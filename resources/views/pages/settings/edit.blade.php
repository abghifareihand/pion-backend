@extends('layouts.master')

@section('title')
    Pengaturan Aplikasi
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Header -->
            <div class="col-md-12">
                <div class="card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Pengaturan Aplikasi</h5>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-soft-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            @foreach ($settings as $key => $setting)
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-semibold mb-0">{{ $setting->label }}</label>
                                    </div>
                                    <input
                                        type="text"
                                        class="form-control mb-1"
                                        name="settings[{{ $key }}]"
                                        value="{{ $setting->value }}"
                                        placeholder="Masukkan nilai..."
                                    >
                                    <small class="text-muted italic">
                                        <i class="fa fa-info-circle me-1"></i>
                                        Digunakan pada: 
                                        <strong>
                                            @if ($setting->key == \App\Models\Setting::IURAN_BULANAN_NOMINAL || $setting->key == \App\Models\Setting::IURAN_BULANAN_TERBILANG)
                                                PDF Member (Surat Kuasa)
                                            @elseif($setting->key == \App\Models\Setting::EMAIL_ORGANISASI)
                                                Header Kop PDF (Member & Pesan)
                                            @else
                                                Sistem
                                            @endif
                                        </strong>
                                    </small>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fa fa-save me-1"></i> Update
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
