@extends('layouts.master')

@section('title')
    Detail Program Sosial
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-800">Detail Program Sosial</h2>
            <p class="text-sm text-slate-500 mt-1">Pratinjau program bantuan dan kegiatan sosial anggota.</p>
        </div>
        <div>
            <a href="{{ route('socials.index') }}" class="btn btn-secondary inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Content Card -->
    <x-card>
        <div class="space-y-6 w-full">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Judul Program Sosial</dt>
                <dd class="mt-1 text-lg font-semibold text-slate-900">{{ $social->title }}</dd>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Keterangan / Deskripsi</dt>
                <dd class="mt-1 text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $social->description ?? '-' }}</dd>
            </div>

            @if ($social->image_path)
                <div class="border-t border-slate-100 pt-4">
                    <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Foto Dokumentasi</dt>
                    <dd>
                        <div class="rounded-xl overflow-hidden border border-slate-200 inline-block shadow-sm">
                            <img src="{{ asset('storage/' . $social->image_path) }}" alt="{{ $social->title }}" class="max-w-xl w-full h-auto object-cover">
                        </div>
                    </dd>
                </div>
            @endif

            @if (Str::endsWith($social->file_path, '.pdf'))
                <div class="border-t border-slate-100 pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Dokumen Pendukung (PDF)</dt>
                        <a href="{{ asset('storage/' . $social->file_path) }}" target="_blank" class="text-xs font-medium text-primary hover:underline inline-flex items-center gap-1">
                            Buka di Tab Baru
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                    <dd class="rounded-xl overflow-hidden border border-slate-200 shadow-sm bg-slate-50">
                        <iframe src="{{ asset('storage/' . $social->file_path) }}" class="w-full h-[750px] border-0"></iframe>
                    </dd>
                </div>
            @endif
        </div>
    </x-card>
</div>
@endsection
