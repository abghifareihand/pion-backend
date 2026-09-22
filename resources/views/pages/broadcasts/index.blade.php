@extends('layouts.master')

@section('title', 'Broadcast Pesan')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Broadcast Pesan</span>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Broadcast Notifikasi</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kirim pesan dan push notification massal ke seluruh atau kelompok anggota.</p>
        </div>

        <a href="{{ route('broadcasts.create') }}" class="btn btn-primary shadow-primary self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Kirim Siaran Baru</span>
        </a>
    </div>

    {{-- Data Table Card --}}
    <div class="card">
        @if($broadcasts->count() > 0)
            <x-table>
                <x-slot name="header">
                    <th class="w-12 text-center">No</th>
                    <th>Judul Pesan</th>
                    <th>Target Penerima</th>
                    <th>Tanggal Kirim</th>
                    <th class="text-right">Aksi</th>
                </x-slot>

                @foreach ($broadcasts as $broadcast)
                    <tr>
                        <td class="text-center font-medium text-slate-400 text-xs">{{ $loop->iteration }}</td>

                        <td>
                            <div class="font-semibold text-slate-800">{{ $broadcast->title }}</div>
                            @if ($broadcast->body)
                                <div class="text-xs text-slate-500 truncate max-w-md">{{ Str::limit($broadcast->body, 60) }}</div>
                            @endif
                        </td>

                        <td>
                            @if ($broadcast->users && $broadcast->users->count())
                                <span class="text-xs text-slate-700 font-medium">
                                    {{ $broadcast->users->pluck('name')->take(3)->join(', ') }}
                                    @if ($broadcast->users->count() > 3)
                                        <span class="text-slate-400">+{{ $broadcast->users->count() - 3 }} lainnya</span>
                                    @endif
                                </span>
                            @else
                                <x-badge variant="info">Semua Anggota</x-badge>
                            @endif
                        </td>

                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $broadcast->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <button
                                    type="button"
                                    @click="$dispatch('confirm-dialog', {
                                        title: 'Hapus Pesan Broadcast',
                                        message: 'Apakah Anda yakin ingin menghapus arsip broadcast {{ addslashes($broadcast->title) }}?',
                                        confirmText: 'Ya, Hapus',
                                        type: 'danger',
                                        formAction: '{{ route('broadcasts.destroy', $broadcast->id) }}'
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
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <h3 class="empty-state-title">Belum ada siaran broadcast</h3>
                <p class="empty-state-description">Kirim pengumuman penting langsung ke notifikasi ponsel anggota.</p>
                <a href="{{ route('broadcasts.create') }}" class="btn btn-sm btn-primary">
                    Buat Broadcast Baru
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
