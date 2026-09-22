@extends('layouts.master')

@section('title', 'Pesan & Aspirasi')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Pesan & Aspirasi</span>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pesan & Aspirasi Anggota</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola pertanyaan, laporan ketenagakerjaan, dan aspirasi anggota serikat.</p>
        </div>
    </div>

    {{-- Data Table Card --}}
    <div class="card">
        @if ($tickets->count() > 0)
            <x-table>
                <x-slot name="header">
                    <th class="w-12 text-center">No</th>
                    <th>Nama Anggota</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal Masuk</th>
                    <th>Dokumen / Lampiran</th>
                    <th class="text-right">Aksi</th>
                </x-slot>

                @foreach ($tickets as $ticket)
                    <tr id="ticket-row-{{ $ticket->id }}">
                        <td class="text-center font-medium text-slate-400 text-xs">{{ $loop->iteration }}</td>

                        <td>
                            <div class="font-semibold text-slate-800 flex items-center gap-1.5">
                                <span>{{ $ticket->user->name ?? 'Anggota' }}</span>
                                <span id="unread-badge-container-{{ $ticket->id }}">
                                    @if ($ticket->unread_count > 0)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 animate-pulse">
                                            {{ $ticket->unread_count }} baru
                                        </span>
                                    @endif
                                </span>
                            </div>
                            <div class="text-xs text-slate-400">NIK: {{ $ticket->user->nik_karyawan ?? '-' }}</div>
                        </td>

                        <td>
                            @if ($ticket->type == 'report')
                                <x-badge variant="danger">Laporan</x-badge>
                            @elseif ($ticket->type == 'question')
                                <x-badge variant="info">Pertanyaan</x-badge>
                            @else
                                <x-badge variant="primary">Saran / Aspirasi</x-badge>
                            @endif
                        </td>

                        <td id="status-container-{{ $ticket->id }}">
                            @switch($ticket->status)
                                @case('pending')
                                    <x-badge variant="warning" dot>Menunggu</x-badge>
                                    @break
                                @case('responded')
                                    <x-badge variant="info" dot>Dibalas</x-badge>
                                    @break
                                @case('processed')
                                    <x-badge variant="secondary" dot>Diproses</x-badge>
                                    @break
                                @case('done')
                                    <x-badge variant="success" dot>Selesai</x-badge>
                                    @break
                                @case('rejected')
                                    <x-badge variant="danger" dot>Ditolak</x-badge>
                                    @break
                                @default
                                    <x-badge variant="secondary">{{ ucfirst($ticket->status) }}</x-badge>
                            @endswitch
                        </td>

                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('tickets.pdf', $ticket->id) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded text-xs font-semibold transition-colors" title="Download PDF Lengkap">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>PDF</span>
                                </a>

                                @if ($ticket->attachment)
                                    <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-1 bg-sky-50 text-sky-700 hover:bg-sky-100 rounded text-xs font-semibold transition-colors" title="Lihat Lampiran">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        <span>File</span>
                                    </a>
                                @endif
                            </div>
                        </td>

                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-primary-600 text-white rounded-lg text-xs font-semibold hover:bg-primary-700 transition-colors shadow-xs" title="Balas Pesan">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    <span>Balas</span>
                                </a>

                                <button
                                    type="button"
                                    @click="$dispatch('confirm-dialog', {
                                        title: 'Hapus Pesan Aspirasi',
                                        message: 'Apakah Anda yakin ingin menghapus pesan dari {{ addslashes($ticket->user->name ?? 'Anggota') }}?',
                                        confirmText: 'Ya, Hapus',
                                        type: 'danger',
                                        formAction: '{{ route('tickets.destroy', $ticket->id) }}'
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
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
                <h3 class="empty-state-title">Belum ada pesan masuk</h3>
                <p class="empty-state-description">Aspirasi atau pertanyaan dari anggota akan otomatis masuk ke sini.</p>
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    let currentTotalTickets = {{ $tickets->count() }};
    let currentUnreadTotal = {{ $tickets->sum('unread_count') }};

    function playNotificationSound() {
        const audio = new Audio("{{ asset('assets/audio/notification.mp3') }}");
        audio.play().catch(e => console.log('Audio error:', e));
    }

    function fetchUnreadData() {
        fetch("{{ route('tickets.unread.data') }}")
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {
                    let newUnreadTotal = 0;
                    if (result.total_tickets_count > currentTotalTickets) {
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                type: 'info',
                                title: 'Pesan Baru Masuk',
                                message: 'Ada aspirasi baru dari anggota. Silakan muat ulang halaman.'
                            }
                        }));
                        playNotificationSound();
                        currentTotalTickets = result.total_tickets_count;
                    }

                    result.data.forEach(ticket => {
                        newUnreadTotal += ticket.unread_count;
                        const badgeContainer = document.getElementById(`unread-badge-container-${ticket.id}`);
                        if (badgeContainer) {
                            badgeContainer.innerHTML = ticket.unread_count > 0 ?
                                `<span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 animate-pulse">${ticket.unread_count} baru</span>` : '';
                        }
                    });

                    if (newUnreadTotal > currentUnreadTotal) {
                        playNotificationSound();
                    }
                    currentUnreadTotal = newUnreadTotal;
                }
            })
            .catch(err => console.error(err));
    }

    setInterval(fetchUnreadData, 5000);
</script>
@endpush
@endsection
