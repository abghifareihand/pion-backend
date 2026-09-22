@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Welcome Hero Card --}}
    <div class="bg-gradient-to-r from-primary-900 via-primary-700 to-primary-600 rounded-2xl p-6 lg:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-1/3 -top-10 w-48 h-48 bg-white/5 rounded-full blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold tracking-wide uppercase">
                    <span>👋 Halo, {{ Auth::user()->name ?? 'Administrator' }}</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight">
                    Dashboard Serikat Pekerja PION
                </h1>
                <p class="text-red-100/90 text-sm max-w-xl">
                    Pantau data keanggotaan, transparansi keuangan, program sosial, dan aspirasi anggota secara real-time.
                </p>
            </div>

            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('users.create') }}" class="btn btn-sm bg-white text-primary-700 hover:bg-red-50 font-bold shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>Tambah Anggota</span>
                </a>
                <a href="{{ route('informations.create') }}" class="btn btn-sm bg-white/20 hover:bg-white/30 text-white border border-white/20 font-semibold backdrop-blur-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Buat Berita</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        {{-- Total Anggota --}}
        <div class="stat-card flex items-center justify-between">
            <div class="space-y-1">
                <span class="stat-card-label">Total Anggota</span>
                <div class="stat-card-value">{{ number_format($totalUsers, 0, ',', '.') }}</div>
                <span class="text-xs text-slate-400">Anggota aktif terdaftar</span>
            </div>
            <div class="stat-card-icon bg-red-50 text-primary-600 border border-red-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>

        {{-- Total Informasi --}}
        <div class="stat-card flex items-center justify-between">
            <div class="space-y-1">
                <span class="stat-card-label">Informasi & Berita</span>
                <div class="stat-card-value">{{ number_format($totalInformations, 0, ',', '.') }}</div>
                <span class="text-xs text-slate-400">Artikel dipublikasikan</span>
            </div>
            <div class="stat-card-icon bg-sky-50 text-sky-600 border border-sky-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
        </div>

        {{-- Materi Belajar --}}
        <div class="stat-card flex items-center justify-between">
            <div class="space-y-1">
                <span class="stat-card-label">Materi Edukasi</span>
                <div class="stat-card-value">{{ number_format($totalLearnings, 0, ',', '.') }}</div>
                <span class="text-xs text-slate-400">Modul pembelajaran</span>
            </div>
            <div class="stat-card-icon bg-amber-50 text-amber-600 border border-amber-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
        </div>

        {{-- Laporan Keuangan --}}
        <div class="stat-card flex items-center justify-between">
            <div class="space-y-1">
                <span class="stat-card-label">Laporan Keuangan</span>
                <div class="stat-card-value">{{ number_format($totalFinancials, 0, ',', '.') }}</div>
                <span class="text-xs text-slate-400">Catatan transaksi kas</span>
            </div>
            <div class="stat-card-icon bg-emerald-50 text-emerald-600 border border-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        {{-- Struktur Organisasi --}}
        <div class="stat-card flex items-center justify-between">
            <div class="space-y-1">
                <span class="stat-card-label">Struktur Organisasi</span>
                <div class="stat-card-value">{{ number_format($totalOrganizations, 0, ',', '.') }}</div>
                <span class="text-xs text-slate-400">Posisi & Pengurus</span>
            </div>
            <div class="stat-card-icon bg-purple-50 text-purple-600 border border-purple-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>

        {{-- Program Sosial --}}
        <div class="stat-card flex items-center justify-between">
            <div class="space-y-1">
                <span class="stat-card-label">Program Sosial</span>
                <div class="stat-card-value">{{ number_format($totalSocials, 0, ',', '.') }}</div>
                <span class="text-xs text-slate-400">Agenda kegiatan</span>
            </div>
            <div class="stat-card-icon bg-rose-50 text-rose-600 border border-rose-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
        </div>

        {{-- Serikat SP PION --}}
        <div class="stat-card flex items-center justify-between">
            <div class="space-y-1">
                <span class="stat-card-label">Serikat SP PION</span>
                <div class="stat-card-value">{{ number_format($totalUnions, 0, ',', '.') }}</div>
                <span class="text-xs text-slate-400">Cabang & Unit kerja</span>
            </div>
            <div class="stat-card-icon bg-indigo-50 text-indigo-600 border border-indigo-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        {{-- Pemilu --}}
        <div class="stat-card flex items-center justify-between">
            <div class="space-y-1">
                <span class="stat-card-label">Pemilu / E-Vote</span>
                <div class="stat-card-value">{{ number_format($totalVotes, 0, ',', '.') }}</div>
                <span class="text-xs text-slate-400">Sesi pemungutan suara</span>
            </div>
            <div class="stat-card-icon bg-teal-50 text-teal-600 border border-teal-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
        </div>

        {{-- Tiket / Aspirasi --}}
        <div class="stat-card flex items-center justify-between">
            <div class="space-y-1">
                <span class="stat-card-label">Pesan & Aspirasi</span>
                <div class="stat-card-value">{{ number_format($totalTickets, 0, ',', '.') }}</div>
                <span class="text-xs text-slate-400">Aspirasi masuk</span>
            </div>
            <div class="stat-card-icon bg-orange-50 text-orange-600 border border-orange-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
        </div>

    </div>

    {{-- Recent Members Registrations Table Card --}}
    <div class="card">
        <div class="card-header flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="card-title text-base font-bold">Pendaftaran Anggota Terbaru</h3>
                <p class="text-xs text-slate-500 mt-0.5">Calon anggota yang baru mengajukan pendaftaran</p>
            </div>
            <a href="{{ route('members.index') }}" class="btn btn-sm btn-ghost text-primary-600 hover:text-primary-700 hover:bg-red-50 gap-1 self-start sm:self-auto">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="table-container border-0 rounded-none">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIK KTP</th>
                        <th>Jenis Kelamin</th>
                        <th>Departemen</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentMembers as $member)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $member->name }}</div>
                            </td>
                            <td class="font-mono text-xs text-slate-600">{{ $member->nik_ktp }}</td>
                            <td>
                                @if ($member->gender == 'male')
                                    <span class="badge badge-info">Laki-laki</span>
                                @elseif($member->gender == 'female')
                                    <span class="badge bg-pink-50 text-pink-700 border border-pink-200">Perempuan</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="text-slate-600">{{ $member->department }}</td>
                            <td class="text-xs text-slate-500">{{ $member->created_at->translatedFormat('d M Y') }}</td>
                            <td>
                                @if ($member->status == 'pending')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($member->status == 'approved')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($member->status == 'rejected')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($member->status) }}</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('members.show', $member->id) }}" class="btn btn-sm btn-ghost text-primary-600 hover:bg-red-50 py-1 px-2.5">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-400 text-sm">
                                Belum ada permohonan pendaftaran anggota terbaru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
