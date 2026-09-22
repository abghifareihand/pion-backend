@extends('layouts.master')

@section('title', 'Edit Informasi')

@section('breadcrumb')
    <a href="{{ route('informations.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Informasi & Berita</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Edit Informasi</span>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Informasi</h1>
            <p class="text-slate-500 text-sm mt-0.5">Perbarui konten informasi atau pengumuman serikat.</p>
        </div>
        <a href="{{ route('informations.index') }}" class="btn btn-sm btn-ghost gap-1.5 self-start sm:self-auto">
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
            <h3 class="card-title">Edit Detail Informasi</h3>
        </div>
        <form method="POST" action="{{ route('informations.update', $information->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body space-y-6">
                {{-- Judul --}}
                <div>
                    <label class="form-label" for="title">Judul Informasi <span class="text-red-500">*</span></label>
                    <input class="input @error('title') border-red-500 @enderror" type="text" id="title" name="title" value="{{ old('title', $information->title) }}" required />
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="form-label" for="description">Deskripsi Lengkap</label>
                    <textarea class="input @error('description') border-red-500 @enderror" id="description" name="description" rows="5">{{ old('description', $information->description) }}</textarea>
                    @error('description') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Section Foto --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <label class="form-label font-semibold text-slate-800">Foto / Cover</label>
                    @if ($information->image_path)
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . $information->image_path) }}" alt="" class="w-24 h-24 object-cover rounded-lg border border-slate-200 shadow-xs" />
                            <a href="{{ asset('storage/' . $information->image_path) }}" target="_blank" class="text-xs font-semibold text-sky-600 hover:underline">
                                Buka Foto di Tab Baru &rarr;
                            </a>
                        </div>
                    @endif
                    <div>
                        <label class="text-xs text-slate-500 mb-1 block">Unggah Foto Baru (opsional, biarkan kosong jika tidak diganti)</label>
                        <x-file-input name="image" accept=".jpg,.jpeg,.png" />
                    </div>
                </div>

                {{-- Section File --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <label class="form-label font-semibold text-slate-800">Berkas Dokumen</label>
                    @if ($information->file_path)
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-lg border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Dokumen Terlampir Saat Ini
                            </span>
                            <a href="{{ asset('storage/' . $information->file_path) }}" target="_blank" class="text-xs font-semibold text-emerald-600 hover:underline">
                                Unduh File &rarr;
                            </a>
                        </div>
                    @endif
                    <div>
                        <label class="text-xs text-slate-500 mb-1 block">Unggah Dokumen Baru (opsional, biarkan kosong jika tidak diganti)</label>
                        <x-file-input name="file" accept=".pdf,.doc,.docx" />
                    </div>
                </div>
            </div>

            <div class="card-footer flex items-center justify-end gap-3">
                <a href="{{ route('informations.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
