@extends('layouts.master')

@section('title', 'Data Serikat SP PION')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Serikat SP PION</span>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Serikat SP PION</h1>
            <p class="text-slate-500 text-sm mt-0.5">Dokumentasi, regulasi organisasi, dan dokumen resmi serikat.</p>
        </div>

        <a href="{{ route('unions.create') }}" class="btn btn-primary shadow-primary self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Dokumen</span>
        </a>
    </div>

    {{-- Data Table Card --}}
    <div class="card">
        @if ($unions->count() > 0)
            <x-table>
                <x-slot name="header">
                    <th class="w-12 text-center">No</th>
                    <th>Judul Dokumen</th>
                    <th>Foto</th>
                    <th>Berkas File</th>
                    <th>Tanggal Dibuat</th>
                    <th class="text-right">Aksi</th>
                </x-slot>

                @foreach ($unions as $union)
                    <tr>
                        <td class="text-center font-medium text-slate-400 text-xs">{{ $loop->iteration }}</td>

                        <td>
                            <div class="font-semibold text-slate-800">{{ $union->title }}</div>
                        </td>

                        <td>
                            @if ($union->image_path)
                                <a href="{{ asset('storage/' . $union->image_path) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-sky-600 hover:text-sky-700 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Lihat Foto</span>
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>

                        <td>
                            @if ($union->file_path)
                                <a href="{{ asset('storage/' . $union->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Unduh File</span>
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>

                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $union->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('unions.show', $union->id) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>

                                <a href="{{ route('unions.edit', $union->id) }}" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                <button
                                    type="button"
                                    @click="$dispatch('confirm-dialog', {
                                        title: 'Hapus Dokumen Serikat',
                                        message: 'Apakah Anda yakin ingin menghapus dokumen {{ addslashes($union->title) }}?',
                                        confirmText: 'Ya, Hapus',
                                        type: 'danger',
                                        formAction: '{{ route('unions.destroy', $union->id) }}'
                                    })"
                                    class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus"
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
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="empty-state-title">Belum ada data dokumen serikat</h3>
                <p class="empty-state-description">Tambahkan dokumen resmi atau arsip serikat SP PION pertama Anda.</p>
                <a href="{{ route('unions.create') }}" class="btn btn-sm btn-primary">
                    Tambah Dokumen Baru
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
