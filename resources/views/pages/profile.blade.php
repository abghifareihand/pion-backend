@extends('layouts.master')

@section('title', 'Profil Akun Saya')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Profil Saya</span>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pengaturan Profil Pengguna</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola identitas akun administrator, email, foto profil, dan kata sandi.</p>
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
            <h3 class="card-title">Informasi Akun</h3>
        </div>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Nama --}}
                    <div>
                        <label class="form-label" for="name">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input class="input @error('name') border-red-500 @enderror" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required />
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Username --}}
                    <div>
                        <label class="form-label" for="username">Username Login <span class="text-red-500">*</span></label>
                        <input class="input @error('username') border-red-500 @enderror" type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required />
                        @error('username') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="form-label" for="email">Alamat Email <span class="text-red-500">*</span></label>
                        <input class="input @error('email') border-red-500 @enderror" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required />
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="form-label" for="password">Kata Sandi Baru (Opsional)</label>
                        <input class="input @error('password') border-red-500 @enderror" type="text" id="password" name="password" value="{{ old('password', $user->password_hint) }}" placeholder="Ketik kata sandi baru" />
                        <p class="form-help text-xs text-slate-500">Kata sandi saat ini: <strong class="text-primary-700">{{ $user->password_hint ?? '-' }}</strong></p>
                        @error('password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Section Foto --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <label class="form-label font-semibold text-slate-800">Foto Profil Administrator</label>
                    <div class="flex items-center gap-4">
                        @if ($user->image_path)
                            <img src="{{ asset('storage/' . $user->image_path) }}" alt="" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-xs" />
                        @else
                            <div class="w-16 h-16 rounded-xl bg-primary-600 text-white font-bold text-xl flex items-center justify-center shadow-xs">
                                {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <x-file-input id="image_path" name="image_path" accept="image/*" />
                            <p class="form-help text-xs text-slate-500 mt-1">Format: JPG, PNG, JPEG (Maks: 5MB)</p>
                        </div>
                    </div>
                    @error('image_path') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="card-footer flex items-center justify-end gap-3">
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Perbarui Profil</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
