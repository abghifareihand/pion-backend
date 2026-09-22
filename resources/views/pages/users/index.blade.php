@extends('layouts.master')

@section('title', 'Data Anggota')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Data Anggota</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola seluruh data anggota Serikat Pekerja PION.</p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('users.template') }}" class="btn btn-secondary" title="Unduh Template Excel">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Template</span>
            </a>

            <button type="button" @click="$dispatch('open-modal', 'import-modal')" class="btn btn-secondary" title="Impor Data dari Excel">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <span>Import</span>
            </button>

            <a href="{{ route('users.export') }}" class="btn btn-secondary" title="Ekspor Data ke Excel">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Export</span>
            </a>

            <a href="{{ route('users.create') }}" class="btn btn-primary shadow-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Anggota</span>
            </a>
        </div>
    </div>

    {{-- Error Flash Messages --}}
    @if (session('error_html'))
        <x-alert type="danger" title="Kesalahan Validasi Berkas">
            {!! session('error_html') !!}
        </x-alert>
    @endif

    @if ($errors->any())
        <x-alert type="danger" title="Terjadi Kesalahan">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    {{-- Data Table Card --}}
    <div class="card">
        @if ($users->count() > 0)
            <x-table>
                <x-slot name="header">
                    <th class="w-12 text-center">No</th>
                    <th>Nama Anggota</th>
                    <th>NIK KTP</th>
                    <th>NIK Karyawan</th>
                    <th>KTA</th>
                    <th>Departemen</th>
                    <th>Tgl Join</th>
                    <th>Gender</th>
                    <th>Tempat Lahir</th>
                    <th>Tgl Lahir</th>
                    <th>No Telepon</th>
                    <th class="text-right">Aksi</th>
                </x-slot>

                @foreach ($users as $user)
                    <tr>
                        <td class="text-center font-medium text-slate-400 text-xs">{{ $loop->iteration }}</td>

                        <td>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-red-50 text-primary-700 font-bold text-xs flex items-center justify-center border border-red-100 flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('users.show', $user->id) }}" class="font-semibold text-slate-800 hover:text-primary-600 block truncate transition-colors">
                                        {{ $user->name }}
                                    </a>
                                </div>
                            </div>
                        </td>

                        <td class="font-mono text-xs text-slate-600">{{ $user->nik_ktp ?? '-' }}</td>
                        <td class="font-mono text-xs text-slate-600">{{ $user->nik_karyawan ?? '-' }}</td>
                        <td>
                            @if ($user->kta_number)
                                <a href="{{ route('users.kta', $user->id) }}" target="_blank" class="inline-flex items-center gap-1 font-mono text-xs text-primary-600 hover:underline">
                                    <span>{{ $user->kta_number }}</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="text-slate-700 text-xs font-medium">{{ $user->department ?? '-' }}</td>
                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $user->joint_date ? \Carbon\Carbon::parse($user->joint_date)->format('d-m-Y') : '-' }}
                        </td>
                        <td>
                            @if ($user->gender == 'male')
                                <span class="badge badge-info">Laki-laki</span>
                            @elseif ($user->gender == 'female')
                                <span class="badge bg-pink-50 text-pink-700 border border-pink-200">Perempuan</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="text-slate-600 text-xs">{{ $user->birth_place ?? '-' }}</td>
                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') : '-' }}
                        </td>
                        <td class="font-mono text-xs text-slate-600">{{ $user->phone ?? '-' }}</td>

                        <td>
                            <div class="flex items-center justify-end gap-1">
                                {{-- KTA PDF Button --}}
                                <a href="{{ route('users.kta', $user->id) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Lihat KTA">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                </a>

                                {{-- Show Detail Button --}}
                                <a href="{{ route('users.show', $user->id) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Detail Anggota">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>

                                {{-- Edit Button --}}
                                <a href="{{ route('users.edit', $user->id) }}" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit Anggota">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                {{-- Delete Button via Alpine Dialog --}}
                                <button
                                    type="button"
                                    @click="$dispatch('confirm-dialog', {
                                        title: 'Hapus Data Anggota',
                                        message: 'Apakah Anda yakin ingin menghapus data anggota {{ addslashes($user->name) }}?',
                                        confirmText: 'Ya, Hapus',
                                        type: 'danger',
                                        formAction: '{{ route('users.destroy', $user->id) }}'
                                    })"
                                    class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus Anggota"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="empty-state-title">Belum ada data anggota</h3>
                <p class="empty-state-description">Mulai tambahkan data anggota atau impor berkas dari Excel.</p>
                <div class="flex items-center justify-center gap-2">
                    <button type="button" @click="$dispatch('open-modal', 'import-modal')" class="btn btn-sm btn-secondary">
                        Import Excel
                    </button>
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                        Tambah Anggota
                    </a>
                </div>
            </div>
        @endif
    </div>

</div>

{{-- Import Modal --}}
<x-modal name="import-modal" title="Impor Data Anggota dari Excel" size="md">
    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="form-label" for="import-file">Pilih Berkas Excel (.xlsx, .xls)</label>
            <x-file-input id="import-file" name="file" required accept=".xlsx, .xls" />
            <p class="form-help text-xs text-slate-500 mt-1">
                Gunakan template resmi SP PION untuk memastikan kolom sesuai format sistem.
            </p>
        </div>

        <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 flex items-start gap-2">
            <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>Pastikan NIK KTP dan NIK Karyawan tidak duplikat dengan anggota yang sudah terdaftar.</span>
        </div>

        <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
            <button type="button" @click="$dispatch('close-modal', 'import-modal')" class="btn btn-sm btn-ghost">
                Batal
            </button>
            <button type="submit" class="btn btn-sm btn-primary">
                Unggah & Impor
            </button>
        </div>
    </form>
</x-modal>
@endsection
