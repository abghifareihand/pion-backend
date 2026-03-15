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
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSettingModal">
                            <i class="fa fa-plus me-1"></i> Tambah Setting
                        </button>
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
                                        <a href="#" class="btn btn-danger btn-xs"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-action="{{ route('settings.destroy', $setting->id) }}"
                                            data-name="{{ $setting->label }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="settings[{{ $key }}]"
                                        value="{{ $setting->value }}"
                                        placeholder="Masukkan nilai..."
                                    >
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa fa-save me-1"></i> Update
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Setting --}}
    <div class="modal fade" id="addSettingModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Setting Baru</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('settings.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Key <small class="text-muted">(unik, huruf kecil & underscore)</small></label>
                            <input type="text" class="form-control" name="key" placeholder="contoh: nama_rekening" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Label</label>
                            <input type="text" class="form-control" name="label" placeholder="contoh: Nama Rekening" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nilai</label>
                            <input type="text" class="form-control" name="value" placeholder="Masukkan nilai...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah Setting --}}

    {{-- Modal Delete --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus setting <strong id="deleteItemName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Delete --}}

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteForm = document.getElementById('deleteForm');
                const deleteItemName = document.getElementById('deleteItemName');

                document.querySelectorAll('.btn-danger[data-bs-target="#deleteModal"]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        deleteForm.action = this.dataset.action;
                        deleteItemName.textContent = this.dataset.name;
                    });
                });
            });
        </script>
    @endpush
@endsection
