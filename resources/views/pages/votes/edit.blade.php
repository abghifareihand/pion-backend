@extends('layouts.master')

@section('title', 'Edit Pemilu')

@section('breadcrumb')
    <a href="{{ route('votes.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Pemilu & E-Vote</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Edit Pemilu</span>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Agenda Pemilu</h1>
            <p class="text-slate-500 text-sm mt-0.5">Perbarui informasi pemilihan, visi-misi kandidat, atau aktifkan/nonaktifkan voting.</p>
        </div>
        <a href="{{ route('votes.index') }}" class="btn btn-sm btn-ghost gap-1.5 self-start sm:self-auto">
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
            <h3 class="card-title">Edit Detail Pemilu</h3>
        </div>
        <form method="POST" action="{{ route('votes.update', $vote->id) }}">
            @csrf
            @method('PUT')
            <div class="card-body space-y-6">
                {{-- Judul --}}
                <div>
                    <label class="form-label" for="title">Judul Pemilu <span class="text-red-500">*</span></label>
                    <input class="input @error('title') border-red-500 @enderror" type="text" id="title" name="title" value="{{ old('title', $vote->title) }}" required />
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="form-label" for="description">Deskripsi & Ketentuan</label>
                    <textarea class="input @error('description') border-red-500 @enderror" id="description" name="description" rows="3">{{ old('description', $vote->description) }}</textarea>
                    @error('description') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Status Aktif Switch --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-slate-800">Status Voting Aktif</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Jika aktif, anggota dapat memberikan hak suaranya di aplikasi mobile.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ $vote->is_active ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:width-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                {{-- Kandidat & Visi --}}
                <div>
                    <label class="form-label font-bold text-slate-900 mb-3">Visi & Misi Kandidat</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($vote->options as $option)
                            <div class="p-4 bg-white border border-slate-200 rounded-xl space-y-2">
                                <div class="font-bold text-sm text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
                                    <span class="w-5 h-5 rounded-full bg-primary-600 text-white text-[11px] font-bold flex items-center justify-center">{{ $loop->iteration }}</span>
                                    <span>{{ $option->label }}</span>
                                </div>
                                <div>
                                    <label class="text-xs text-slate-500 mb-1 block">Visi & Misi</label>
                                    <textarea class="input" name="visions[{{ $option->id }}]" rows="3" placeholder="Masukkan visi misi...">{{ old('visions.' . $option->id, $option->vision) }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer flex items-center justify-end gap-3">
                <a href="{{ route('votes.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
