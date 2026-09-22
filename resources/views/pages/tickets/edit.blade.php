@extends('layouts.master')

@section('title', 'Balas Pesan & Aspirasi')

@section('breadcrumb')
    <a href="{{ route('tickets.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Pesan & Aspirasi</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Balas Pesan</span>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Balas Aspirasi Anggota</h1>
            <p class="text-slate-500 text-sm mt-0.5">Thread percakapan langsung dan penyelesaian keluhan anggota.</p>
        </div>
        <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-ghost gap-1.5 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Info Card --}}
    <div class="card p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <span class="text-xs text-slate-400 font-medium block">Pengirim</span>
                <span class="text-sm font-bold text-slate-800">{{ $ticket->user->name ?? 'Anggota' }}</span>
                <span class="text-xs text-slate-500 block">NIK: {{ $ticket->user->nik_karyawan ?? '-' }}</span>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-medium block">Kategori</span>
                @if ($ticket->type == 'report')
                    <x-badge variant="danger">Laporan</x-badge>
                @elseif ($ticket->type == 'question')
                    <x-badge variant="info">Pertanyaan</x-badge>
                @else
                    <x-badge variant="primary">Saran</x-badge>
                @endif
            </div>
            <div>
                <span class="text-xs text-slate-400 font-medium block">Status Saat Ini</span>
                <x-badge variant="{{ $ticket->status == 'done' ? 'success' : ($ticket->status == 'pending' ? 'warning' : 'info') }}" dot>
                    {{ ucfirst($ticket->status) }}
                </x-badge>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-medium block">Tanggal Masuk</span>
                <span class="text-xs font-semibold text-slate-700">{{ $ticket->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        @if ($ticket->attachment)
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500 font-medium">Lampiran dari Anggota:</span>
                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-600 hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    <span>Lihat Berkas Lampiran</span>
                </a>
            </div>
        @endif
    </div>

    {{-- Chat Thread Container --}}
    <div class="card overflow-hidden">
        <div class="card-header bg-slate-50/70 border-b border-slate-100 flex items-center justify-between py-3">
            <h3 class="card-title text-sm font-semibold">Riwayat Percakapan</h3>
            <span class="text-xs text-slate-400">Pembaruan otomatis tiap 5 detik</span>
        </div>

        <div id="chat-container" class="p-5 space-y-4 max-h-[460px] overflow-y-auto bg-slate-100/50">
            {{-- Initial Message from Member --}}
            <div class="flex justify-start">
                <div class="bg-white p-4 rounded-2xl rounded-tl-xs shadow-xs border border-slate-200/80 max-w-xl">
                    <div class="flex items-center justify-between gap-4 mb-1">
                        <span class="text-xs font-bold text-slate-900">{{ $ticket->user->name ?? 'Anggota' }}</span>
                        <span class="text-[10px] text-slate-400">{{ $ticket->created_at->format('d M, H:i') }}</span>
                    </div>
                    @if ($ticket->title)
                        <h5 class="text-xs font-bold text-primary-700 mb-1">{{ $ticket->title }}</h5>
                    @endif
                    <p class="text-xs text-slate-700 leading-relaxed whitespace-pre-line">{{ $ticket->description }}</p>
                </div>
            </div>

            {{-- Thread Replies --}}
            @php $lastReplyId = 0; @endphp
            @foreach ($ticket->replies as $reply)
                @php 
                    $isMe = $reply->user_id == Auth::id(); 
                    $lastReplyId = $reply->id;
                @endphp
                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                    <div class="{{ $isMe ? 'bg-primary-600 text-white rounded-tr-xs shadow-primary/20' : 'bg-white text-slate-800 rounded-tl-xs border border-slate-200/80' }} p-4 rounded-2xl shadow-xs max-w-xl">
                        <div class="flex items-center justify-between gap-4 mb-1">
                            <span class="text-xs font-bold {{ $isMe ? 'text-white' : 'text-slate-900' }}">
                                {{ $isMe ? 'Admin (Anda)' : ($ticket->user->name ?? 'Anggota') }}
                            </span>
                            <span class="text-[10px] {{ $isMe ? 'text-white/70' : 'text-slate-400' }}">
                                {{ $reply->created_at->format('d M, H:i') }}
                            </span>
                        </div>
                        <p class="text-xs leading-relaxed whitespace-pre-line">{{ $reply->message }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Reply Form --}}
        <div class="p-4 bg-white border-t border-slate-200/70">
            <form method="POST" id="reply-form" action="{{ route('tickets.reply', $ticket->id) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="form-label" for="reply-message">Tulis Pesan Balasan <span class="text-red-500">*</span></label>
                    <textarea class="input" name="message" id="reply-message" rows="3" placeholder="Ketik respon, penjelasan, atau solusi untuk anggota..." required>{{ old('message') }}</textarea>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-medium text-slate-700 whitespace-nowrap">Perbarui Status:</label>
                        <select class="input py-1.5 text-xs max-w-[200px]" name="status" required>
                            <option value="responded" {{ $ticket->status == 'responded' ? 'selected' : '' }}>Responded (Dibalas)</option>
                            <option value="processed" {{ $ticket->status == 'processed' ? 'selected' : '' }}>Processed (Sedang Diproses)</option>
                            <option value="done" {{ $ticket->status == 'done' ? 'selected' : '' }}>Done (Selesai)</option>
                            <option value="rejected" {{ $ticket->status == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary shadow-primary gap-1.5 self-end sm:self-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Kirim Balasan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let lastReplyId = {{ $lastReplyId }};
        const ticketId = {{ $ticket->id }};
        const chatContainer = document.getElementById('chat-container');

        function scrollToBottom() {
            if (chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        scrollToBottom();

        setInterval(function() {
            fetch(`/tickets/${ticketId}/replies?last_id=${lastReplyId}`)
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success' && result.data.length > 0) {
                        result.data.forEach(reply => {
                            const isMe = reply.is_me;
                            const html = `
                                <div class="flex ${isMe ? 'justify-end' : 'justify-start'}">
                                    <div class="${isMe ? 'bg-primary-600 text-white rounded-tr-xs shadow-primary/20' : 'bg-white text-slate-800 rounded-tl-xs border border-slate-200/80'} p-4 rounded-2xl shadow-xs max-w-xl">
                                        <div class="flex items-center justify-between gap-4 mb-1">
                                            <span class="text-xs font-bold ${isMe ? 'text-white' : 'text-slate-900'}">${reply.sender}</span>
                                            <span class="text-[10px] ${isMe ? 'text-white/70' : 'text-slate-400'}">${reply.date}</span>
                                        </div>
                                        <p class="text-xs leading-relaxed whitespace-pre-line">${reply.message}</p>
                                    </div>
                                </div>
                            `;
                            chatContainer.insertAdjacentHTML('beforeend', html);
                            lastReplyId = reply.id;
                        });
                        scrollToBottom();
                    }
                })
                .catch(err => console.error(err));
        }, 5000);
    });
</script>
@endpush
@endsection
