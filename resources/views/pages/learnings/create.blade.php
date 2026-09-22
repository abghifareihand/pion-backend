@extends('layouts.master')

@section('title', 'Tambah Materi Belajar')

@section('breadcrumb')
    <a href="{{ route('learnings.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Materi Belajar</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Tambah Materi</span>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Tambah Materi Belajar</h1>
            <p class="text-slate-500 text-sm mt-0.5">Unggah modul edukasi, materi serikat, atau peraturan perundangan.</p>
        </div>
        <a href="{{ route('learnings.index') }}" class="btn btn-sm btn-ghost gap-1.5 self-start sm:self-auto">
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
            <h3 class="card-title">Detail Modul Materi</h3>
        </div>
        <form method="POST" action="{{ route('learnings.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body space-y-5">
                {{-- Judul --}}
                <div>
                    <label class="form-label" for="title">Judul Materi Belajar <span class="text-red-500">*</span></label>
                    <input class="input @error('title') border-red-500 @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Masukkan judul materi edukasi" required />
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="form-label" for="description">Deskripsi Ringkas</label>
                    <textarea class="input @error('description') border-red-500 @enderror" id="description" name="description" rows="4" placeholder="Uraian atau sinopsis singkat mengenai materi ini">{{ old('description') }}</textarea>
                    @error('description') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Foto Cover --}}
                    <div>
                        <label class="form-label" for="image">Foto Sampul / Cover</label>
                        <input class="input @error('image') border-red-500 @enderror" type="file" id="image" name="image" accept=".jpg,.jpeg,.png" />
                        <p class="form-help text-xs text-slate-500">Format: JPG, PNG (Maks 2MB)</p>
                        @error('image') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- File Modul --}}
                    <div>
                        <label class="form-label" for="file">Berkas Modul / Materi (PDF)</label>
                        <input class="input @error('file') border-red-500 @enderror" type="file" id="file" name="file" accept=".pdf,.doc,.docx" />
                        <p class="form-help text-xs text-slate-500">Format: PDF, DOC, DOCX (Maks 10MB)</p>
                        @error('file') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer flex items-center justify-end gap-3">
                <a href="{{ route('learnings.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Materi</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
