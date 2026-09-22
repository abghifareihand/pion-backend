@extends('layouts.master')

@section('title', 'Edit Laporan Keuangan')

@section('breadcrumb')
    <a href="{{ route('financials.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Laporan Keuangan</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Edit Laporan</span>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Laporan Keuangan</h1>
            <p class="text-slate-500 text-sm mt-0.5">Perbarui rincian, dokumen, atau bukti transaksi keuangan.</p>
        </div>
        <a href="{{ route('financials.index') }}" class="btn btn-sm btn-ghost gap-1.5 self-start sm:self-auto">
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

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Perbarui Laporan Keuangan</h3>
        </div>

        <form method="POST" action="{{ route('financials.update', $financial->id) }}" enctype="multipart/form-data" class="space-y-5 p-6">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div>
                <label class="form-label" for="title">Judul Laporan <span class="text-danger-500">*</span></label>
                <input class="input @error('title') border-danger-500 @enderror" type="text" id="title" name="title" value="{{ old('title', $financial->title) }}" required />
                @error('title') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="form-label" for="description">Keterangan / Deskripsi</label>
                <textarea class="input @error('description') border-danger-500 @enderror" id="description" name="description" rows="4">{{ old('description', $financial->description) }}</textarea>
                @error('description') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2 border-t border-slate-100">
                {{-- Foto Bukti --}}
                <div class="space-y-3">
                    <label class="form-label">Lampiran Foto / Bukti</label>
                    @if ($financial->image_path)
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3">
                            <img src="{{ asset('storage/' . $financial->image_path) }}" alt="Bukti" class="w-16 h-16 rounded-lg object-cover border border-slate-200" />
                            <div>
                                <a href="{{ asset('storage/' . $financial->image_path) }}" target="_blank" class="text-xs font-semibold text-primary-600 hover:underline">
                                    Lihat Foto Saat Ini
                                </a>
                                <p class="text-[11px] text-slate-400 mt-0.5">Unggah baru jika ingin mengganti</p>
                            </div>
                        </div>
                    @endif
                    <x-file-input id="image" name="image" accept=".jpg,.jpeg,.png" />
                </div>

                {{-- Berkas Dokumen --}}
                <div class="space-y-3">
                    <label class="form-label">Lampiran Berkas Dokumen</label>
                    @if ($financial->file_path)
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">
                                DOC
                            </div>
                            <div class="min-w-0">
                                <a href="{{ asset('storage/' . $financial->file_path) }}" target="_blank" class="text-xs font-semibold text-primary-600 hover:underline block truncate">
                                    Unduh Dokumen Saat Ini
                                </a>
                                <p class="text-[11px] text-slate-400 mt-0.5">Unggah baru jika ingin mengganti</p>
                            </div>
                        </div>
                    @endif
                    <x-file-input id="file" name="file" accept=".pdf,.doc,.docx" />
                </div>
            </div>

            {{-- Card Footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('financials.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Perbarui Laporan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
