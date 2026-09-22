@extends('layouts.master')

@section('title', 'Tambah Program Sosial')

@section('breadcrumb')
    <a href="{{ route('socials.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Program Sosial</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Tambah Program</span>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Tambah Program Sosial</h1>
            <p class="text-slate-500 text-sm mt-0.5">Unggah agenda kegiatan sosial, bakti amal, atau santunan anggota.</p>
        </div>
        <a href="{{ route('socials.index') }}" class="btn btn-sm btn-ghost gap-1.5 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Alert Errors --}}
    @if ($errors->any())
        <x-alert type="danger" title="Terjadi Kesalahan Input">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    {{-- Form Card --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Program Sosial</h3>
        </div>
        <form method="POST" action="{{ route('socials.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body space-y-5">
                {{-- Judul --}}
                <div>
                    <label class="form-label" for="title">Nama Program Sosial <span class="text-red-500">*</span></label>
                    <input class="input @error('title') border-red-500 @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Santunan Pendidikan Anak Anggota" required />
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="form-label" for="description">Deskripsi Kegiatan</label>
                    <textarea class="input @error('description') border-red-500 @enderror" id="description" name="description" rows="4" placeholder="Keterangan mengenai tujuan, sasaran, atau jadwal program sosial">{{ old('description') }}</textarea>
                    @error('description') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Foto Kegiatan --}}
                    <div>
                        <label class="form-label" for="image">Dokumentasi Foto</label>
                        <x-file-input id="image" name="image" accept=".jpg,.jpeg,.png" />
                        <p class="form-help text-xs text-slate-500 mt-1">Format: JPG, PNG (Maks 3MB)</p>
                        @error('image') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- File Dokumen Laporan --}}
                    <div>
                        <label class="form-label" for="file">Dokumen / Proposal / Laporan</label>
                        <x-file-input id="file" name="file" accept=".pdf,.doc,.docx" />
                        <p class="form-help text-xs text-slate-500 mt-1">Format: PDF, DOC (Maks 10MB)</p>
                        @error('file') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer flex items-center justify-end gap-3">
                <a href="{{ route('socials.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Program</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
