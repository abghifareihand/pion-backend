@extends('layouts.master')

@section('title', 'Buat Laporan Keuangan')

@section('breadcrumb')
    <a href="{{ route('financials.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Laporan Keuangan</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Buat Laporan</span>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Buat Laporan Keuangan</h1>
            <p class="text-slate-500 text-sm mt-0.5">Unggah rincian, berkas dokumen, atau bukti transaksi keuangan.</p>
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
            <h3 class="card-title">Formulir Laporan Keuangan</h3>
        </div>

        <form method="POST" action="{{ route('financials.store') }}" enctype="multipart/form-data" class="space-y-5 p-6">
            @csrf

            {{-- Judul --}}
            <div>
                <label class="form-label" for="title">Judul Laporan <span class="text-danger-500">*</span></label>
                <input class="input @error('title') border-danger-500 @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Laporan Kas Masuk Bulan Maret 2026" required />
                @error('title') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="form-label" for="description">Keterangan / Deskripsi</label>
                <textarea class="input @error('description') border-danger-500 @enderror" id="description" name="description" rows="4" placeholder="Uraikan rincian laporan keuangan...">{{ old('description') }}</textarea>
                @error('description') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2 border-t border-slate-100">
                {{-- Foto Bukti --}}
                <div>
                    <label class="form-label" for="image">Lampiran Foto / Bukti (.jpg, .jpeg, .png)</label>
                    <x-file-input id="image" name="image" accept=".jpg,.jpeg,.png" />
                    <p class="form-help text-xs text-slate-500 mt-1">Opsional: Format gambar struk/nota/kwitansi.</p>
                </div>

                {{-- Berkas Dokumen --}}
                <div>
                    <label class="form-label" for="file">Lampiran Berkas Dokumen (.pdf, .doc, .docx)</label>
                    <x-file-input id="file" name="file" accept=".pdf,.doc,.docx" />
                    <p class="form-help text-xs text-slate-500 mt-1">Opsional: Berkas spreadsheet atau PDF laporan kas.</p>
                </div>
            </div>

            {{-- Card Footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('financials.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Laporan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
