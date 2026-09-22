@extends('layouts.master')

@section('title', 'Registrasi Calon Anggota')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Registrasi Calon</span>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pendaftaran Calon Anggota</h1>
            <p class="text-slate-500 text-sm mt-0.5">Daftar calon anggota serikat yang mendaftar dan menunggu verifikasi.</p>
        </div>
    </div>

    {{-- Data Table Card --}}
    <div class="card">
        @if ($members->count() > 0)
            <x-table>
                <x-slot name="header">
                    <th class="w-12 text-center">No</th>
                    <th>Nama Calon</th>
                    <th>Jenis Kelamin</th>
                    <th>Status Verifikasi</th>
                    <th>Direferensikan Oleh</th>
                    <th>Tanggal Daftar</th>
                    <th class="text-right">Aksi</th>
                </x-slot>

                @foreach ($members as $member)
                    <tr>
                        <td class="text-center font-medium text-slate-400 text-xs">{{ $loop->iteration }}</td>

                        <td>
                            <div class="font-semibold text-slate-800">{{ $member->name }}</div>
                            <div class="text-xs text-slate-400">{{ $member->email ?? $member->phone ?? '-' }}</div>
                        </td>

                        <td>
                            @if ($member->gender == 'male')
                                <span class="text-xs text-slate-600 font-medium">Laki-laki</span>
                            @elseif ($member->gender == 'female')
                                <span class="text-xs text-slate-600 font-medium">Perempuan</span>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>

                        <td>
                            @if ($member->status == 'pending')
                                <x-badge variant="warning" dot>Menunggu Persetujuan</x-badge>
                            @elseif ($member->status == 'approved')
                                <x-badge variant="success" dot>Disetujui</x-badge>
                            @elseif ($member->status == 'rejected')
                                <x-badge variant="danger" dot>Ditolak</x-badge>
                            @else
                                <x-badge variant="secondary">{{ ucfirst($member->status) }}</x-badge>
                            @endif
                        </td>

                        <td>
                            <div class="text-xs font-medium text-slate-700">{{ $member->referrer->name ?? '-' }}</div>
                        </td>

                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $member->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('members.pdf', $member->id) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Unduh Formulir PDF">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>

                                <a href="{{ route('members.show', $member->id) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>

                                <a href="{{ route('members.edit', $member->id) }}" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Verifikasi / Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                @if($member->status == 'approved' || $member->status == 'rejected')
                                    <button
                                        type="button"
                                        @click="$dispatch('confirm-dialog', {
                                            title: 'Hapus Data Calon Anggota',
                                            message: 'Apakah Anda yakin ingin menghapus data calon anggota {{ addslashes($member->name) }}?',
                                            confirmText: 'Ya, Hapus',
                                            type: 'danger',
                                            formAction: '{{ route('members.destroy', $member->id) }}'
                                        })"
                                        class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <h3 class="empty-state-title">Belum ada pendaftaran calon anggota</h3>
                <p class="empty-state-description">Data formulir registrasi yang diajukan akan ditampilkan pada tabel ini.</p>
            </div>
        @endif
    </div>

</div>
@endsection
