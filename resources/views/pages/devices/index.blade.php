@extends('layouts.master')

@section('title', 'Data Perangkat Aktif')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Perangkat Aktif</span>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Perangkat Aktif</h1>
            <p class="text-slate-500 text-sm mt-0.5">Daftar token dan ID perangkat smartphone anggota yang terhubung ke sistem PION.</p>
        </div>
    </div>

    {{-- Data Table Card --}}
    <div class="card">
        @if ($devices->count() > 0)
            <x-table>
                <x-slot name="header">
                    <th class="w-12 text-center">No</th>
                    <th>Nama Pengguna</th>
                    <th>ID / Token Perangkat</th>
                    <th>Tanggal Terdaftar</th>
                    <th class="text-right">Aksi</th>
                </x-slot>

                @foreach ($devices as $device)
                    <tr>
                        <td class="text-center font-medium text-slate-400 text-xs">{{ $loop->iteration }}</td>

                        <td>
                            <div class="font-semibold text-slate-800">{{ $device->user->name ?? '-' }}</div>
                            <div class="text-xs text-slate-400">NIK: {{ $device->user->nik_karyawan ?? '-' }}</div>
                        </td>

                        <td>
                            <code class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded text-xs font-mono break-all">
                                {{ $device->device_id }}
                            </code>
                        </td>

                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $device->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <button
                                    type="button"
                                    @click="$dispatch('confirm-dialog', {
                                        title: 'Hapus Sesi Perangkat',
                                        message: 'Apakah Anda yakin ingin menghapus sesi perangkat untuk {{ addslashes($device->user->name ?? 'Pengguna') }}?',
                                        confirmText: 'Ya, Putuskan Sesi',
                                        type: 'danger',
                                        formAction: '{{ route('devices.destroy', $device->id) }}'
                                    })"
                                    class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Putuskan Perangkat"
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
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="empty-state-title">Belum ada perangkat terdaftar</h3>
                <p class="empty-state-description">Perangkat anggota yang melakukan login di aplikasi mobile akan tercatat di sini.</p>
            </div>
        @endif
    </div>

</div>
@endsection
