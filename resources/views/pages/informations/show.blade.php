@extends('layouts.master')

@section('title')
    Detail Informasi
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-800">Detail Informasi & Berita</h2>
            <p class="text-sm text-slate-500 mt-1">Pratinjau publikasi berita dan informasi anggota.</p>
        </div>
        <div>
            <a href="{{ route('informations.index') }}" class="btn btn-secondary inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Content Card -->
    <x-card>
        <div class="space-y-6 max-w-4xl">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Judul Informasi</dt>
                <dd class="mt-1 text-lg font-semibold text-slate-900">{{ $information->title }}</dd>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Isi / Deskripsi</dt>
                <dd class="mt-1 text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $information->description ?? '-' }}</dd>
            </div>

            @if ($information->image_path)
                <div class="border-t border-slate-100 pt-4">
                    <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Foto / Gambar Sampul</dt>
                    <dd>
                        <div class="rounded-xl overflow-hidden border border-slate-200 inline-block shadow-sm">
                            <img src="{{ asset('storage/' . $information->image_path) }}" alt="{{ $information->title }}" class="max-w-lg w-full h-auto object-cover">
                        </div>
                    </dd>
                </div>
            @endif

            @if (Str::endsWith($information->file_path, '.pdf'))
                <div class="border-t border-slate-100 pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Lampiran Dokumen PDF</dt>
                        <a href="{{ asset('storage/' . $information->file_path) }}" target="_blank" class="text-xs font-medium text-primary hover:underline inline-flex items-center gap-1">
                            Buka di Tab Baru
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                    <dd class="rounded-xl overflow-hidden border border-slate-200 shadow-sm bg-slate-50">
                        <iframe src="{{ asset('storage/' . $information->file_path) }}" class="w-full h-[750px] border-0"></iframe>
                    </dd>
                </div>
            @endif
        </div>
    </x-card>
</div>
@endsection
