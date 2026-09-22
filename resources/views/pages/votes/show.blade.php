@extends('layouts.master')

@section('title')
    Detail Pemilu
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-800">Detail Pemilu & E-Vote</h2>
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

    <!-- Main Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Vote Info & Candidates -->
        <div class="lg:col-span-1 space-y-6">
            <x-card title="Informasi Pemilu">
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Judul Acara</span>
                        <p class="text-base font-semibold text-slate-800 mt-0.5">{{ $vote->title }}</p>
                    </div>

                    <div class="border-t border-slate-100 pt-3">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Status</span>
                        <div class="mt-1">
                            @if ($vote->is_active)
                                <span class="badge badge-success">Aktif Berlangsung</span>
                            @else
                                <span class="badge badge-danger">Tidak Aktif / Selesai</span>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card title="Daftar Kandidat">
                <div class="space-y-3">
                    @foreach ($vote->options as $option)
                        <div class="p-3 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-white transition-colors">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center">
                                    {{ $loop->iteration }}
                                </span>
                                <span class="font-semibold text-sm text-slate-800">{{ $option->label }}</span>
                            </div>
                            @if ($option->vision)
                                <div class="mt-2 pl-3 border-l-2 border-primary/40 text-xs text-slate-600 leading-relaxed">
                                    <span class="font-semibold text-slate-700">Visi:</span> {{ $option->vision }}
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

            <!-- Total Participation Summary Card -->
            <div class="bg-gradient-to-r from-primary to-primary-hover text-white rounded-2xl p-6 shadow-lg shadow-primary/15">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-white/70">Partisipasi Pemilih</span>
                        <div class="mt-1 flex items-baseline gap-2">
                            <span id="total-votes-count" class="text-3xl font-extrabold tracking-tight">{{ $totalVotesCount }}</span>
                            <span class="text-sm text-white/80">dari <span id="total-eligible-users">{{ $totalEligibleUsers }}</span> hak suara</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span id="total-participation-rate" class="text-3xl font-black">{{ $participationRate }}</span>
                        <span class="text-lg font-bold">%</span>
                        <p class="text-xs text-white/70">Tingkat Partisipasi</p>
                    </div>
                </div>

                <div class="mt-4 w-full bg-white/20 rounded-full h-3 overflow-hidden p-0.5">
                    <div id="total-progress-bar" class="bg-white rounded-full h-2 transition-all duration-500" style="width: {{ $participationRate }}%"></div>
                </div>
            </div>

            <!-- Candidate Vote Counts -->
            <x-card title="Hasil Perolehan Suara Kandidat">
                <div class="space-y-4">
                    @foreach ($vote->options as $option)
                        @php
                            $optionPercentage = $totalVotesCount > 0 ? round(($option->results_count / $totalVotesCount) * 100, 1) : 0;
                        @endphp
                        <div class="p-4 rounded-xl border border-slate-200/80 bg-white hover:border-slate-300 transition-all shadow-sm">
                            <div class="flex items-center gap-4">
                                @if ($option->user && $option->user->image_path)
                                    <img src="{{ asset('storage/' . $option->user->image_path) }}" alt="{{ $option->label }}" class="w-14 h-14 rounded-full object-cover ring-2 ring-primary/20 shrink-0">
                                @else
                                    <div class="w-14 h-14 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-lg ring-2 ring-primary/20 shrink-0">
                                        {{ substr($option->label, 0, 1) }}
                                    </div>
                                @endif

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 mb-1.5">
                                        <div class="flex items-center gap-2 truncate">
                                            <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-700 text-xs font-bold flex items-center justify-center shrink-0">
                                                {{ $loop->iteration }}
                                            </span>
                                            <h4 class="text-sm font-semibold text-slate-800 truncate">{{ $option->label }}</h4>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="text-sm font-bold text-slate-800">
                                                <span id="results-count-{{ $option->id }}">{{ $option->results_count }}</span> suara
                                            </span>
                                            <span class="text-xs font-semibold text-primary ml-1">
                                                (<span id="percentage-{{ $option->id }}">{{ $optionPercentage }}</span>%)
                                            </span>
                                        </div>
                                    </div>

                                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                        <div id="progress-bar-{{ $option->id }}" class="bg-primary h-2.5 rounded-full transition-all duration-500" style="width: {{ $optionPercentage }}%"></div>
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
