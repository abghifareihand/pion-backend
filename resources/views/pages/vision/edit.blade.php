@extends('layouts.master')

@section('title', 'Visi & Misi Serikat')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Visi & Misi</span>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Visi & Misi Serikat SP PION</h1>
            <p class="text-slate-500 text-sm mt-0.5">Atur redaksi visi dan misi resmi yang ditampilkan pada aplikasi anggota.</p>
        </div>
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
            <h3 class="card-title">Redaksi Visi & Misi</h3>
        </div>
        <form method="POST" action="{{ route('vision.update') }}">
            @csrf
            @method('PUT')
            <div class="card-body space-y-6">
                {{-- Visi --}}
                <div>
                    <label class="form-label" for="vision-editor">Visi Serikat <span class="text-red-500">*</span></label>
                    <textarea id="vision-editor" name="title" rows="4" class="input" required>{{ old('title', $vision->title) }}</textarea>
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Misi --}}
                <div>
                    <label class="form-label" for="mision-editor">Misi Serikat <span class="text-red-500">*</span></label>
                    <textarea id="mision-editor" name="subtitle" rows="6" class="input" required>{{ old('subtitle', $vision->subtitle) }}</textarea>
                    @error('subtitle') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="card-footer flex items-center justify-end gap-3">
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Visi & Misi</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('vision-editor');
            CKEDITOR.replace('mision-editor');
        }
    });
</script>
@endpush
@endsection
