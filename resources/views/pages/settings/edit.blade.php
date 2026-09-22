@extends('layouts.master')

@section('title', 'Pengaturan Sistem')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Pengaturan Sistem</span>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pengaturan Sistem & Dokumen</h1>
            <p class="text-slate-500 text-sm mt-0.5">Konfigurasi variabel global, kop surat PDF, dan dasar hukum surat kuasa.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Parameter Konfigurasi</h3>
        </div>
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body space-y-6">
                @foreach ($settings as $key => $setting)
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="form-label font-bold text-slate-900 mb-0">{{ $setting->label }}</label>
                            @if ($setting->key === \App\Models\Setting::DASAR_HUKUM)
                                <button type="button" class="btn btn-sm btn-primary gap-1" onclick="addPoin()">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span>Tambah Poin</span>
                                </button>
                            @endif
                        </div>

                        @if ($setting->key === \App\Models\Setting::DASAR_HUKUM)
                            @php
                                $poinList = json_decode($setting->value, true) ?? [];
                            @endphp
                            <div id="dasarHukumList" class="space-y-2 pt-2">
                                @foreach($poinList as $i => $poin)
                                    <div class="flex items-center gap-2 dasar-hukum-row">
                                        <span class="w-7 h-7 rounded-lg bg-primary-600 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 poin-number">
                                            {{ $i + 1 }}
                                        </span>
                                        <input type="text" class="input flex-1"
                                            name="settings[dasar_hukum][]"
                                            value="{{ $poin }}"
                                            placeholder="Teks dasar hukum...">
                                        @if($i >= 2)
                                            <button type="button" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg flex-shrink-0 transition-colors"
                                                onclick="removePoin(this)" title="Hapus Poin">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-slate-400 mt-2">
                                Digunakan pada: <strong>PDF Surat Kuasa Member</strong>
                            </p>

                        @elseif ($setting->key === \App\Models\Setting::KUASA_TEKS)
                            <textarea class="input"
                                name="settings[{{ $key }}]"
                                rows="4"
                                placeholder="Masukkan teks kuasa...">{{ $setting->value }}</textarea>
                            <p class="text-xs text-slate-400 mt-1">
                                Digunakan pada: <strong>PDF Surat Kuasa Member</strong>
                            </p>

                        @else
                            <input type="text" class="input"
                                name="settings[{{ $key }}]"
                                value="{{ $setting->value }}"
                                placeholder="Masukkan nilai...">
                            <p class="text-xs text-slate-400 mt-1">
                                Digunakan pada:
                                <strong>
                                    @if ($setting->key === \App\Models\Setting::EMAIL_ORGANISASI)
                                        Header Kop PDF (Member & Pesan)
                                    @else
                                        Sistem Administrasi
                                    @endif
                                </strong>
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="card-footer flex items-center justify-end gap-3">
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    function addPoin() {
        const list = document.getElementById('dasarHukumList');
        const rows = list.querySelectorAll('.dasar-hukum-row');
        const newIndex = rows.length + 1;
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 dasar-hukum-row';
        div.innerHTML = `
            <span class="w-7 h-7 rounded-lg bg-primary-600 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 poin-number">${newIndex}</span>
            <input type="text" class="input flex-1" name="settings[dasar_hukum][]" placeholder="Teks dasar hukum...">
            <button type="button" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg flex-shrink-0 transition-colors" onclick="removePoin(this)" title="Hapus">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        `;
        list.appendChild(div);
        renumberPoin();
    }

    function removePoin(btn) {
        btn.closest('.dasar-hukum-row').remove();
        renumberPoin();
    }

    function renumberPoin() {
        const rows = document.querySelectorAll('#dasarHukumList .dasar-hukum-row');
        rows.forEach((row, i) => {
            const num = row.querySelector('.poin-number');
            if (num) num.textContent = i + 1;
        });
    }
</script>
@endpush
@endsection
