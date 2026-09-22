@extends('layouts.master')

@section('title', 'Buat Broadcast Pesan')

@section('breadcrumb')
    <a href="{{ route('broadcasts.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Broadcast Pesan</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Buat Pesan</span>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kirim Broadcast Notifikasi</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kirim push notification langsung ke smartphone anggota yang memiliki perangkat terdaftar.</p>
        </div>
        <a href="{{ route('broadcasts.index') }}" class="btn btn-sm btn-ghost gap-1.5 self-start sm:self-auto">
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
            <h3 class="card-title">Formulir Pesan Broadcast</h3>
        </div>
        <form method="POST" action="{{ route('broadcasts.store') }}" id="broadcastForm">
            @csrf
            <div class="card-body space-y-6">
                {{-- Judul --}}
                <div>
                    <label class="form-label" for="title">Judul Notifikasi <span class="text-red-500">*</span></label>
                    <input class="input @error('title') border-red-500 @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Pengumuman Rapat Anggota Tahunan" required />
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Isi Broadcast --}}
                <div>
                    <label class="form-label" for="body">Isi Pesan / Notifikasi <span class="text-red-500">*</span></label>
                    <textarea class="input @error('body') border-red-500 @enderror" id="body" name="body" rows="4" placeholder="Tulis rincian pesan notifikasi di sini..." required>{{ old('body') }}</textarea>
                    @error('body') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                {{-- Target Anggota --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="form-label font-semibold text-slate-800 mb-0">Pilih Penerima Khusus (Opsional)</label>
                        <span class="text-xs text-slate-500">Kosongkan jika ingin mengirim ke <strong>Semua Anggota</strong></span>
                    </div>
                    <div class="p-3 border border-slate-200 rounded-xl max-h-60 overflow-y-auto bg-slate-50/50">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach ($users as $user)
                                <label for="user_{{ $user->id }}" class="flex items-center gap-2.5 p-2 bg-white border border-slate-200 rounded-lg hover:border-primary-500 cursor-pointer text-xs transition-colors">
                                    <input class="rounded text-primary-600 focus:ring-primary-500"
                                        id="user_{{ $user->id }}" type="checkbox" name="users[]"
                                        value="{{ $user->id }}" {{ in_array($user->id, old('users', [])) ? 'checked' : '' }}>
                                    <span class="font-medium text-slate-800 truncate">{{ $user->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer flex items-center justify-end gap-3">
                <a href="{{ route('broadcasts.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary" onclick="this.disabled=true; this.form.submit();">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <span>Kirim Broadcast Sekarang</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
