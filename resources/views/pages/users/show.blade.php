@extends('layouts.master')

@section('title', 'Detail Anggota: ' . $user->name)

@section('breadcrumb')
    <a href="{{ route('users.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Data Anggota</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">{{ $user->name }}</span>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Detail Anggota Serikat</h1>
            <p class="text-slate-500 text-sm mt-0.5">Informasi profil lengkap, nomor KTA, dan kredensial anggota.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary shadow-primary gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Data</span>
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-ghost gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- Profile Hero Card --}}
    <div class="card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                @if ($user->image_path)
                    <img src="{{ asset('storage/' . $user->image_path) }}" alt="" class="w-20 h-20 rounded-2xl object-cover border border-slate-200 shadow-sm" />
                @else
                    <div class="w-20 h-20 rounded-2xl bg-primary-600 text-white font-bold text-2xl flex items-center justify-center shadow-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h2 class="text-xl font-bold text-slate-900 leading-tight">{{ $user->name }}</h2>
                        <x-badge variant="primary">KTA: {{ $user->kta_number ?? '-' }}</x-badge>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Departemen: <span class="font-semibold text-slate-700">{{ $user->department ?? '-' }}</span> &bull; NIK: <span class="font-semibold text-slate-700">{{ $user->nik_karyawan }}</span></p>
                    <div class="mt-2 flex items-center gap-2">
                        <a href="{{ route('users.kta', $user->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-primary-700 hover:bg-red-100 rounded-lg text-xs font-semibold border border-red-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Preview KTA</span>
                        </a>
                        <a href="{{ route('users.kta', $user->id) }}?mode=download" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-lg text-xs font-semibold border border-emerald-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Download KTA</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Barcode --}}
            <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-center self-start sm:self-auto">
                <span class="text-[11px] font-bold text-slate-400 block mb-1.5">BARCODE KTA</span>
                @if ($user->barcode_number)
                    <div class="inline-block bg-white p-2 rounded border border-slate-100">
                        {!! DNS1D::getBarcodeHTML($user->barcode_number, 'C128', 1.5, 40) !!}
                    </div>
                    <span class="text-[11px] font-mono text-slate-600 block mt-1">{{ $user->barcode_number }}</span>
                @else
                    <span class="text-xs text-slate-400">-</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Details Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Identitas & Kontak --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Identitas & Kontak</h3>
            </div>
            <div class="card-body divide-y divide-slate-100">
                <div class="py-2.5 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">NIK KTP</span>
                    <span class="font-semibold text-slate-800">{{ $user->nik_ktp ?? '-' }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">NIK Karyawan</span>
                    <span class="font-semibold text-slate-800">{{ $user->nik_karyawan }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">No. Telepon / WhatsApp</span>
                    <span class="font-semibold text-slate-800">{{ $user->phone ?? '-' }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Email</span>
                    <span class="font-semibold text-slate-800">{{ $user->email ?? '-' }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Tanggal Bergabung</span>
                    <span class="font-semibold text-slate-800">{{ $user->joint_date ? \Carbon\Carbon::parse($user->joint_date)->translatedFormat('j F Y') : '-' }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Alamat Domisili</span>
                    <span class="font-semibold text-slate-800 text-right max-w-[220px]">{{ $user->address ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Data Pribadi & Keamanan --}}
        <div class="space-y-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pribadi</h3>
                </div>
                <div class="card-body divide-y divide-slate-100">
                    <div class="py-2.5 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Tempat, Tanggal Lahir</span>
                        <span class="font-semibold text-slate-800">
                            {{ $user->birth_place ?? '-' }}, {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->translatedFormat('j F Y') : '-' }}
                        </span>
                    </div>
                    <div class="py-2.5 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Jenis Kelamin</span>
                        <span class="font-semibold text-slate-800">{{ $user->gender == 'male' ? 'Laki-laki' : ($user->gender == 'female' ? 'Perempuan' : '-') }}</span>
                    </div>
                    <div class="py-2.5 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Agama</span>
                        <span class="font-semibold text-slate-800">{{ $user->religion ?? '-' }}</span>
                    </div>
                    <div class="py-2.5 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Pendidikan Terakhir</span>
                        <span class="font-semibold text-slate-800">{{ $user->education ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Kredensial Keamanan Akun --}}
            <div class="card p-5 bg-gradient-to-br from-red-50/50 to-white border-red-100">
                <h4 class="text-xs font-bold uppercase tracking-wider text-primary-800 mb-3">Kredensial Keamanan Akun Mobile</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-white rounded-xl border border-red-100 shadow-xs">
                        <span class="text-[11px] text-slate-400 block font-medium">PIN Aplikasi</span>
                        <span class="text-base font-mono font-bold text-primary-700 tracking-widest">{{ $user->pin_hint ?? '123456' }}</span>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-red-100 shadow-xs">
                        <span class="text-[11px] text-slate-400 block font-medium">Password Default</span>
                        <span class="text-base font-mono font-bold text-primary-700">{{ $user->password_hint ?? 'password123' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
