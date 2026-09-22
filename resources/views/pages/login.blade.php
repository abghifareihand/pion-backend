@extends('layouts.auth')

@section('title', 'Masuk - SP PION')

@section('content')
<div class="min-h-screen flex w-full">
    <!-- Left Panel - Branding (PION Crimson Gradient) -->
    <div class="hidden lg:flex lg:w-1/2 bg-hero-gradient p-12 flex-col justify-between relative overflow-hidden">
        <!-- Background Glows -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-black/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-red-500/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Top Header Logo -->
        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white rounded-xl shadow-lg flex items-center justify-center p-1.5 overflow-hidden">
                    <img src="{{ asset('assets/images/pion/logo.png') }}" alt="Logo SP PION" class="w-full h-full object-contain">
                </div>
                <div>
                    <span class="text-xl font-extrabold text-white tracking-wide block leading-none">SP PION</span>
                    <span class="text-xs text-red-200/80 font-medium">Serikat Pekerja PION</span>
                </div>
            </div>
        </div>

        <!-- Center Presentation Text -->
        <div class="relative z-10 max-w-md my-auto py-12">
            <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md rounded-full px-4 py-1.5 mb-6 border border-white/20">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-white text-xs font-semibold tracking-wide uppercase">Sistem Informasi & Manajemen</span>
            </div>

            <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4 leading-tight tracking-tight">
                Solid, Mandiri &<br>Berintegritas.
            </h1>
            <p class="text-red-100/90 text-base leading-relaxed mb-8">
                Portal resmi pengelolaan anggota, transparansi keuangan, program sosial, dan aspirasi Serikat Pekerja PION.
            </p>

            <!-- Quick Features Badges -->
            <div class="space-y-3.5">
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm p-3 rounded-xl border border-white/10">
                    <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <span class="text-sm font-medium text-white">Otentikasi & Keamanan Data Terenkripsi</span>
                </div>

                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm p-3 rounded-xl border border-white/10">
                    <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <span class="text-sm font-medium text-white">Pemberdayaan & Layanan Aspirasi Anggota</span>
                </div>
            </div>
        </div>

        <!-- Footer Copyright in Panel -->
        <div class="relative z-10 text-xs text-red-200/60 font-medium">
            &copy; {{ date('Y') }} SP PION. Hak Cipta Dilindungi.
        </div>
    </div>

    <!-- Right Panel - Login Form -->
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-white lg:bg-slate-50">
        <div class="w-full max-w-md">
            <!-- Mobile Brand Header -->
            <div class="lg:hidden text-center mb-8">
                <div class="inline-flex w-14 h-14 bg-white rounded-2xl shadow-md items-center justify-center p-2 mb-3 border border-slate-100">
                    <img src="{{ asset('assets/images/pion/logo.png') }}" alt="Logo SP PION" class="w-full h-full object-contain">
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900">SP PION</h2>
                <p class="text-sm text-slate-500">Serikat Pekerja PION</p>
            </div>

            <!-- Login Card Container -->
            <div class="bg-white lg:border lg:border-slate-200/80 lg:rounded-2xl lg:shadow-xl lg:shadow-slate-200/50 p-8 sm:p-10">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Selamat Datang</h2>
                    <p class="text-sm text-slate-500 mt-1">Silakan masuk ke panel admin SP PION.</p>
                </div>

                {{-- Alert Error --}}
                @if (session('error'))
                    <x-alert type="danger" :dismissible="true">
                        {{ session('error') }}
                    </x-alert>
                @endif

                @if ($errors->any())
                    <x-alert type="danger" title="Gagal Masuk" :dismissible="true">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5" x-data="{ showPassword: false }">
                    @csrf

                    <div>
                        <label class="form-label" for="username">Username</label>
                        <div class="relative">
                            <input
                                id="username"
                                type="text"
                                name="username"
                                value="{{ old('username') }}"
                                class="input @error('username') border-danger-500 @enderror"
                                placeholder="Masukkan username"
                                required
                                autofocus
                                autocomplete="username"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="form-label" for="password">Password</label>
                        <div class="relative">
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                class="input pr-10 @error('password') border-danger-500 @enderror"
                                placeholder="Masukkan password"
                                required
                                autocomplete="current-password"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                            >
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary w-full shadow-primary py-3">
                            <span>Masuk ke Dashboard</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bottom Support Info -->
            <p class="text-center text-xs text-slate-400 mt-8">
                Jika mengalami kendala akun, silakan hubungi Administrator PION.
            </p>
        </div>
    </div>
</div>
@endsection
