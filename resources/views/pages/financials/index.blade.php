@extends('layouts.master')

@section('title', 'Data Laporan Keuangan')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Laporan Keuangan</span>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Laporan Keuangan</h1>
            <p class="text-slate-500 text-sm mt-0.5">Catatan dan transparansi laporan keuangan Serikat Pekerja PION.</p>
        </div>

        <a href="{{ route('financials.create') }}" class="btn btn-primary shadow-primary self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Catatan</span>
        </a>
    </div>

    {{-- Data Table Card --}}
    <div class="card">
        @if ($financials->count() > 0)
            <x-table>
                <x-slot name="header">
                    <th class="w-12 text-center">No</th>
                    <th>Judul Laporan</th>
                    <th>Lampiran Foto</th>
                    <th>Dokumen Berkas</th>
                    <th>Tanggal Dibuat</th>
                    <th class="text-right">Aksi</th>
                </x-slot>

                @foreach ($financials as $finance)
                    <tr>
                        <td class="text-center font-medium text-slate-400 text-xs">{{ $loop->iteration }}</td>

                        <td>
                            <div class="font-semibold text-slate-800">{{ $finance->title }}</div>
                        </td>

                        <td>
                            @if ($finance->image_path)
                                <a href="{{ asset('storage/' . $finance->image_path) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-sky-600 hover:text-sky-700 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Lihat Foto</span>
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>

                        <td>
                            @if ($finance->file_path)
                                <a href="{{ asset('storage/' . $finance->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Unduh Dokumen</span>
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>

                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $finance->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('financials.show', $finance->id) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>

                                <a href="{{ route('financials.edit', $finance->id) }}" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                <button
                                    type="button"
                                    @click="$dispatch('confirm-dialog', {
                                        title: 'Hapus Laporan Keuangan',
                                        message: 'Apakah Anda yakin ingin menghapus laporan {{ addslashes($finance->title) }}?',
                                        confirmText: 'Ya, Hapus',
                                        type: 'danger',
                                        formAction: '{{ route('financials.destroy', $finance->id) }}'
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
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="empty-state-title">Belum ada data keuangan</h3>
                <p class="empty-state-description">Buat catatan laporan kas atau keuangan pertama Anda.</p>
                <a href="{{ route('financials.create') }}" class="btn btn-sm btn-primary">
                    Buat Laporan Baru
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
