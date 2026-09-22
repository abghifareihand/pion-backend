@extends('layouts.master')

@section('title', 'Detail Calon Anggota: ' . $member->name)

@section('breadcrumb')
    <a href="{{ route('members.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Registrasi Calon</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">{{ $member->name }}</span>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Detail Calon Anggota</h1>
            <p class="text-slate-500 text-sm mt-0.5">Verifikasi data pendaftaran anggota dan proses persetujuan akun.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('members.pdf', $member->id) }}" target="_blank" class="btn btn-sm btn-primary shadow-primary gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Lihat Formulir PDF</span>
            </a>
            <a href="{{ route('members.index') }}" class="btn btn-sm btn-ghost gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- Status Banner --}}
    <div class="card p-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs text-slate-400 font-medium block">Status Pendaftaran</span>
                <div class="mt-1 flex items-center gap-3">
                    @if ($member->status == 'pending')
                        <x-badge variant="warning" dot>Menunggu Persetujuan</x-badge>
                    @elseif ($member->status == 'approved')
                        <x-badge variant="success" dot>Sudah Disetujui (Akun Aktif)</x-badge>
                    @elseif ($member->status == 'rejected')
                        <x-badge variant="danger" dot>Pendaftaran Ditolak</x-badge>
                    @endif
                    <span class="text-xs text-slate-500">Direferensikan oleh: <strong>{{ $member->referrer->name ?? '-' }}</strong></span>
                </div>
            </div>

            @if ($member->status == 'pending')
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        @click="$dispatch('confirm-dialog', {
                            title: 'Tolak Pendaftaran',
                            message: 'Apakah Anda yakin ingin menolak pendaftaran calon anggota {{ addslashes($member->name) }}?',
                            confirmText: 'Ya, Tolak',
                            type: 'danger',
                            formAction: '{{ route('members.reject', $member->id) }}',
                            method: 'POST'
                        })"
                        class="btn btn-sm btn-danger"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Tolak Pendaftaran</span>
                    </button>

                    <button
                        type="button"
                        @click="$dispatch('confirm-dialog', {
                            title: 'Setujui Calon Anggota',
                            message: 'Akun mobile akan dibuatkan otomatis untuk {{ addslashes($member->name) }} dengan kredensial default Password: password123 dan PIN: 123456.',
                            confirmText: 'Ya, Setujui & Buat Akun',
                            type: 'primary',
                            formAction: '{{ route('members.approve', $member->id) }}',
                            method: 'POST'
                        })"
                        class="btn btn-sm btn-primary shadow-primary"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Setujui Anggota</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Details Card --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Formulir Registrasi</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-xs text-slate-400 font-medium block">Nama Lengkap</span>
                        <span class="text-sm font-bold text-slate-800">{{ $member->name }}</span>
                    </div>
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-xs text-slate-400 font-medium block">NIK KTP</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $member->nik_ktp }}</span>
                    </div>
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-xs text-slate-400 font-medium block">NIK Karyawan</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $member->nik_karyawan }}</span>
                    </div>
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-xs text-slate-400 font-medium block">Departemen</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $member->department }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">No Telepon / WhatsApp</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $member->phone ?? '-' }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-xs text-slate-400 font-medium block">Tempat, Tanggal Lahir</span>
                        <span class="text-sm font-semibold text-slate-800">
                            {{ $member->birth_place }}, {{ $member->birth_date ? \Carbon\Carbon::parse($member->birth_date)->translatedFormat('j F Y') : '-' }}
                        </span>
                    </div>
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-xs text-slate-400 font-medium block">Jenis Kelamin</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $member->gender == 'male' ? 'Laki-laki' : ($member->gender == 'female' ? 'Perempuan' : '-') }}</span>
                    </div>
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-xs text-slate-400 font-medium block">Agama / Pendidikan</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $member->religion ?? '-' }} &bull; {{ $member->education ?? '-' }}</span>
                    </div>
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-xs text-slate-400 font-medium block">Tanggal Registrasi</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $member->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Alamat Domisili</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $member->address }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
