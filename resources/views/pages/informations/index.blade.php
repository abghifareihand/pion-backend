@extends('layouts.master')

@section('title', 'Data Informasi')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Informasi & Berita</span>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Informasi & Berita</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola publikasi berita, pengumuman, dan artikel untuk anggota.</p>
        </div>

        <a href="{{ route('informations.create') }}" class="btn btn-primary shadow-primary self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Buat Informasi</span>
        </a>
    </div>

    {{-- Data Table Card --}}
    <div class="card">
        @if ($informations->count() > 0)
            <x-table>
                <x-slot name="header">
                    <th class="w-12 text-center">No</th>
                    <th>Judul Informasi</th>
                    <th>Foto</th>
                    <th>Berkas File</th>
                    <th>Tanggal Dibuat</th>
                    <th class="text-right">Aksi</th>
                </x-slot>

                @foreach ($informations as $info)
                    <tr>
                        <td class="text-center font-medium text-slate-400 text-xs">{{ $loop->iteration }}</td>

                        <td>
                            <div class="font-semibold text-slate-800">{{ $info->title }}</div>
                        </td>

                        <td>
                            @if ($info->image_path)
                                <a href="{{ asset('storage/' . $info->image_path) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-sky-600 hover:text-sky-700 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Lihat Foto</span>
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>

                        <td>
                            @if ($info->file_path)
                                <a href="{{ asset('storage/' . $info->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Lihat File</span>
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>

                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $info->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('informations.show', $info->id) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>

                                <a href="{{ route('informations.edit', $info->id) }}" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                <button
                                    type="button"
                                    @click="$dispatch('confirm-dialog', {
                                        title: 'Hapus Informasi',
                                        message: 'Apakah Anda yakin ingin menghapus informasi {{ addslashes($info->title) }}?',
                                        confirmText: 'Ya, Hapus',
                                        type: 'danger',
                                        formAction: '{{ route('informations.destroy', $info->id) }}'
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
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h3 class="empty-state-title">Belum ada data informasi</h3>
                <p class="empty-state-description">Buat informasi atau pengumuman pertama Anda untuk para anggota.</p>
                <a href="{{ route('informations.create') }}" class="btn btn-sm btn-primary">
                    Buat Informasi Baru
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
