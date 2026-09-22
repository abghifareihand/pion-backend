@extends('layouts.master')

@section('title')
    Detail Pemilu
@endsection

@section('content')
<div class="w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">Detail Pemilu & E-Vote</h2>
            <p class="text-sm text-slate-500 mt-1">Pemantauan hasil dan perolehan suara pemilu secara real-time.</p>
        </div>
        <div>
            <a href="{{ route('votes.index') }}" class="btn btn-secondary inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Vote Info & Candidates -->
        <div class="lg:col-span-1 space-y-6">
            <x-card title="Informasi Pemilu">
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Judul Acara</span>
                        <p class="text-base font-bold text-slate-800 mt-1">{{ $vote->title }}</p>
                    </div>

                    @if($vote->description)
                        <div class="border-t border-slate-100 pt-3">
                            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Keterangan</span>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $vote->description }}</p>
                        </div>
                    @endif

                    <div class="border-t border-slate-100 pt-3">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Status Pemilu</span>
                        <div class="mt-1.5">
                            @if ($vote->is_active)
                                <x-badge variant="success" dot>Aktif Berlangsung</x-badge>
                            @else
                                <x-badge variant="danger">Tidak Aktif / Selesai</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card title="Daftar Kandidat">
                <div class="space-y-3">
                    @foreach ($vote->options as $option)
                        <div class="p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/60 hover:bg-white hover:border-slate-300 transition-all">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-lg bg-red-50 text-[#AA2224] border border-red-200/80 font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                    {{ $loop->iteration }}
                                </span>
                                <span class="font-bold text-sm text-slate-800">{{ $option->label }}</span>
                            </div>
                            @if ($option->vision)
                                <div class="mt-2.5 pl-3 border-l-2 border-[#AA2224] text-xs text-slate-600 leading-relaxed bg-white/80 p-2 rounded-r-lg border border-slate-100">
                                    <span class="font-bold text-slate-700">Visi:</span> {{ $option->vision }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>

        <!-- Right: Results & Live Polling -->
        <div class="lg:col-span-2 space-y-6">
            @php
                $totalVotesCount = $vote->options->sum('results_count');
                $totalEligibleUsers = \App\Models\User::where('role', 'user')->count();
                $participationRate = $totalEligibleUsers > 0 ? round(($totalVotesCount / $totalEligibleUsers) * 100, 1) : 0;
            @endphp

            <!-- Total Participation Summary Card with Deep Crimson Gradient -->
            <div class="bg-gradient-to-br from-[#AA2224] via-[#8f1a1c] to-[#671012] text-white rounded-2xl p-6 sm:p-7 shadow-xl shadow-red-900/15 relative overflow-hidden border border-red-900/30">
                <!-- Decorative background elements -->
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute right-32 -bottom-10 w-32 h-32 bg-white/5 rounded-full blur-xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-red-200">Partisipasi Pemilih</span>
                        <div class="mt-1.5 flex items-baseline gap-2">
                            <span id="total-votes-count" class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white">{{ $totalVotesCount }}</span>
                            <span class="text-sm font-medium text-red-100">dari <span id="total-eligible-users" class="font-bold text-white">{{ $totalEligibleUsers }}</span> hak suara</span>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <div class="flex items-baseline sm:justify-end gap-1">
                            <span id="total-participation-rate" class="text-4xl sm:text-5xl font-black text-white">{{ $participationRate }}</span>
                            <span class="text-2xl font-bold text-red-200">%</span>
                        </div>
                        <p class="text-xs font-medium text-red-200 mt-0.5">Tingkat Partisipasi</p>
                    </div>
                </div>

                <div class="relative z-10 mt-5 w-full bg-black/25 rounded-full h-3.5 overflow-hidden p-0.5 border border-white/15">
                    <div id="total-progress-bar" class="bg-white rounded-full h-2.5 transition-all duration-500 shadow-xs" style="width: {{ $participationRate }}%"></div>
                </div>
            </div>

            <!-- Candidate Vote Counts -->
            <x-card title="Hasil Perolehan Suara Kandidat">
                <div class="space-y-4">
                    @php
                        $avatarThemes = [
                            1 => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200 ring-amber-100', 'bar' => 'from-amber-500 to-amber-600', 'pill' => 'bg-amber-50 text-amber-800 border-amber-200'],
                            2 => ['bg' => 'bg-blue-50 text-blue-800 border-blue-200 ring-blue-100', 'bar' => 'from-blue-500 to-blue-600', 'pill' => 'bg-blue-50 text-blue-800 border-blue-200'],
                            3 => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200 ring-emerald-100', 'bar' => 'from-emerald-500 to-emerald-600', 'pill' => 'bg-emerald-50 text-emerald-800 border-emerald-200'],
                            4 => ['bg' => 'bg-purple-50 text-purple-800 border-purple-200 ring-purple-100', 'bar' => 'from-purple-500 to-purple-600', 'pill' => 'bg-purple-50 text-purple-800 border-purple-200'],
                        ];
                    @endphp

                    @foreach ($vote->options as $option)
                        @php
                            $optionPercentage = $totalVotesCount > 0 ? round(($option->results_count / $totalVotesCount) * 100, 1) : 0;
                            $theme = $avatarThemes[$loop->iteration] ?? ['bg' => 'bg-red-50 text-[#AA2224] border-red-200 ring-red-100', 'bar' => 'from-[#AA2224] to-red-500', 'pill' => 'bg-red-50 text-[#AA2224] border-red-200'];
                        @endphp
                        <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-slate-300 transition-all shadow-xs">
                            <div class="flex items-center gap-4">
                                @if ($option->user && $option->user->image_path)
                                    <img src="{{ asset('storage/' . $option->user->image_path) }}" alt="{{ $option->label }}" class="w-14 h-14 rounded-xl object-cover ring-2 {{ $theme['ring'] }} border border-slate-200 shrink-0">
                                @else
                                    <div class="w-14 h-14 rounded-xl {{ $theme['bg'] }} border font-black text-xl flex items-center justify-center shrink-0 shadow-2xs">
                                        {{ $loop->iteration }}
                                    </div>
                                @endif

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 mb-2">
                                        <div class="flex items-center gap-2 truncate">
                                            <h4 class="text-sm font-bold text-slate-900 truncate">{{ $option->label }}</h4>
                                        </div>
                                        <div class="text-right shrink-0 flex items-center gap-2">
                                            <span class="text-sm font-extrabold text-slate-800">
                                                <span id="results-count-{{ $option->id }}">{{ $option->results_count }}</span> suara
                                            </span>
                                            <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $theme['pill'] }} border shadow-2xs">
                                                <span id="percentage-{{ $option->id }}">{{ $optionPercentage }}</span>%
                                            </span>
                                        </div>
                                    </div>

                                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden p-0.5 border border-slate-200/70">
                                        <div id="progress-bar-{{ $option->id }}" class="bg-gradient-to-r {{ $theme['bar'] }} h-2 rounded-full transition-all duration-500 shadow-2xs" style="width: {{ $optionPercentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const voteId = {{ $vote->id }};

        // Polling hasil voting setiap 5 detik
        setInterval(function() {
            fetch(`/votes/${voteId}/results`)
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        const data = result.data;
                        
                        // Update individual options
                        data.options.forEach(option => {
                            const countElem = document.getElementById(`results-count-${option.id}`);
                            const percentElem = document.getElementById(`percentage-${option.id}`);
                            const progressElem = document.getElementById(`progress-bar-${option.id}`);

                            if (countElem) countElem.innerText = option.results_count;
                            if (percentElem) percentElem.innerText = option.percentage;
                            if (progressElem) {
                                progressElem.style.width = option.percentage + '%';
                            }
                        });

                        // Update total summary
                        const totalVotesElem = document.getElementById('total-votes-count');
                        const totalEligibleElem = document.getElementById('total-eligible-users');
                        const participationRateElem = document.getElementById('total-participation-rate');
                        const totalProgressElem = document.getElementById('total-progress-bar');

                        if (totalVotesElem) totalVotesElem.innerText = data.total_votes_count;
                        if (totalEligibleElem) totalEligibleElem.innerText = data.total_eligible_users;
                        if (participationRateElem) participationRateElem.innerText = data.participation_rate;
                        if (totalProgressElem) totalProgressElem.style.width = data.participation_rate + '%';
                    }
                })
                .catch(error => console.error('Error polling vote results:', error));
        }, 5000);
    });
</script>
@endpush
@endsection
