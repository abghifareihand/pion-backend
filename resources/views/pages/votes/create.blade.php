@extends('layouts.master')

@section('title', 'Buat Pemilu')

@section('breadcrumb')
    <a href="{{ route('votes.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Pemilu & E-Vote</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Buat Pemilu</span>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Buat Agenda Pemilu Baru</h1>
            <p class="text-slate-500 text-sm mt-0.5">Tentukan judul, pilih hingga maksimal 8 kandidat, dan isi visi-misi masing-masing calon.</p>
        </div>
        <a href="{{ route('votes.index') }}" class="btn btn-sm btn-ghost gap-1.5 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Alert Errors --}}
    @if ($errors->any())
        <x-alert type="danger" title="Terjadi Kesalahan Input">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <form method="POST" action="{{ route('votes.store') }}" class="space-y-6">
        @csrf

        {{-- Section 1: Info Pemilu --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Agenda Pemilu</h3>
            </div>
            <div class="card-body space-y-5">
                <div>
                    <label class="form-label" for="title">Judul Pemilu <span class="text-red-500">*</span></label>
                    <input class="input @error('title') border-red-500 @enderror" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Pemilihan Ketua Serikat Pekerja PION Periode 2025-2028" required />
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label" for="description">Deskripsi & Ketentuan Voting</label>
                    <textarea class="input @error('description') border-red-500 @enderror" id="description" name="description" rows="3" placeholder="Uraikan informasi mengenai tata cara pemilihan...">{{ old('description') }}</textarea>
                    @error('description') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Section 2: Pilih Kandidat --}}
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div>
                    <h3 class="card-title">Pilih Kandidat</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih maksimal 8 kandidat dari daftar anggota serikat aktif.</p>
                </div>
                <span id="selectedCountBadge" class="text-xs font-semibold px-2.5 py-1 bg-red-50 text-primary-700 rounded-full border border-red-100">
                    0 / 8 Terpilih
                </span>
            </div>
            <div class="card-body space-y-4">
                {{-- Search Box --}}
                <div class="relative">
                    <input type="text" id="candidateSearch" class="input pl-9" placeholder="Cari nama anggota atau kandidat..." />
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <div class="p-3 border border-slate-200 rounded-xl max-h-72 overflow-y-auto bg-slate-50/50">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach ($users as $user)
                            <div class="candidate-item">
                                <label for="user_{{ $user->id }}" class="flex items-center gap-3 p-2.5 bg-white border border-slate-200 rounded-lg hover:border-primary-500 hover:bg-red-50/20 cursor-pointer transition-colors">
                                    <input class="candidate-checkbox rounded text-primary-600 focus:ring-primary-500"
                                        id="user_{{ $user->id }}" type="checkbox" name="options[]"
                                        value="{{ $user->id }}" data-name="{{ $user->name }}"
                                        {{ in_array($user->id, old('options', [])) ? 'checked' : '' }}>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-slate-800 candidate-name truncate">{{ $user->name }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $user->department ?? 'NIK: ' . ($user->nik_karyawan ?? '-') }}</p>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Visi Misi Kandidat Terpilih --}}
        <div class="card" id="visiMisiContainer" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Visi & Misi Kandidat Terpilih</h3>
                <p class="text-xs text-slate-500 mt-0.5">Isi visi & misi untuk masing-masing kandidat terpilih.</p>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="visiMisiList">
                    @foreach ($users as $user)
                        <div class="vision-wrapper" id="vision_wrapper_{{ $user->id }}"
                            style="{{ in_array($user->id, old('options', [])) ? '' : 'display: none;' }}">
                            <div class="p-4 bg-white border border-slate-200 rounded-xl space-y-2">
                                <div class="candidate-vision-label font-bold text-sm text-slate-900 border-b border-slate-100 pb-2 flex items-center gap-2">
                                    Visi Misi: {{ $user->name }}
                                </div>
                                <textarea class="input" name="visions[{{ $user->id }}]" rows="3"
                                    placeholder="Ketik visi & misi untuk kandidat ini...">{{ old('visions.' . $user->id) }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card-footer flex items-center justify-end gap-3">
                <a href="{{ route('votes.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan & Publikasikan Pemilu</span>
                </button>
            </div>
        </div>
    </form>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('candidateSearch');
        const candidateItems = document.querySelectorAll('.candidate-item');
        const checkboxes = document.querySelectorAll('.candidate-checkbox');
        const maxCandidates = 8;
        const visiMisiContainer = document.getElementById('visiMisiContainer');
        const countBadge = document.getElementById('selectedCountBadge');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const term = this.value.toLowerCase();
                candidateItems.forEach(item => {
                    const name = item.querySelector('.candidate-name').textContent.toLowerCase();
                    item.style.display = name.includes(term) ? 'block' : 'none';
                });
            });
        }

        function updateVisibility() {
            const checkedBoxes = document.querySelectorAll('.candidate-checkbox:checked');
            const count = checkedBoxes.length;

            if (countBadge) {
                countBadge.textContent = `${count} / ${maxCandidates} Terpilih`;
            }

            if (count > maxCandidates) {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        type: 'danger',
                        title: 'Batas Maksimal',
                        message: 'Maksimal kandidat yang dapat dipilih adalah 8 orang.'
                    }
                }));
                return false;
            }

            if (count > 0) {
                visiMisiContainer.style.display = 'block';
            } else {
                visiMisiContainer.style.display = 'none';
            }

            document.querySelectorAll('.vision-wrapper').forEach(vw => {
                vw.style.display = 'none';
            });

            checkedBoxes.forEach((cb, index) => {
                const wrapper = document.getElementById(`vision_wrapper_${cb.value}`);
                if (wrapper) {
                    wrapper.style.display = 'block';
                    const label = wrapper.querySelector('.candidate-vision-label');
                    label.innerHTML = `<span class="w-5 h-5 rounded-full bg-primary-600 text-white text-[11px] font-bold flex items-center justify-center">${index + 1}</span> <span>${cb.dataset.name}</span>`;
                }
            });

            return true;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const success = updateVisibility();
                if (!success) {
                    this.checked = false;
                    updateVisibility();
                }
            });
        });

        updateVisibility();
    });
</script>
@endpush
@endsection
