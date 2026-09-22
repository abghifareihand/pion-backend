{{-- Sidebar Overlay (Mobile) --}}
<div x-show="sidebarOpen"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-slate-900/50 z-40 lg:hidden"
     x-cloak>
</div>

{{-- Sidebar Container --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-slate-200/80 transform transition-transform duration-300 ease-in-out lg:sticky lg:top-0 lg:h-screen flex flex-col shadow-xs shrink-0">

    {{-- Logo Header --}}
    <div class="h-16 flex items-center justify-between px-4 border-b border-slate-100 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white border border-red-100 shadow-xs rounded-xl flex items-center justify-center p-1.5 shrink-0">
                <img src="{{ asset('assets/images/pion/logo.png') }}" alt="SP PION" class="w-full h-full object-contain">
            </div>
            <span class="text-lg font-extrabold text-slate-900 tracking-tight">
                SP PION
            </span>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-600 p-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Navigation Links --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 no-scrollbar">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="sidebar-link-light {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Dashboard</span>
        </a>

        {{-- Section: Keanggotaan --}}
        <div class="!mt-5 !mb-2 px-3">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Keanggotaan</span>
        </div>

        {{-- Anggota --}}
        <div x-data="{ open: {{ request()->routeIs('users.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="sidebar-link-light w-full justify-between {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Data Anggota</span>
                </span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform {{ request()->routeIs('users.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-collapse class="mt-1 sidebar-submenu-light">
                <a href="{{ route('users.index') }}" class="sidebar-sublink-light {{ request()->routeIs('users.index') ? 'active' : '' }}">Daftar Anggota</a>
                <a href="{{ route('users.create') }}" class="sidebar-sublink-light {{ request()->routeIs('users.create') ? 'active' : '' }}">Tambah Anggota</a>
            </div>
        </div>

        {{-- Pendaftaran Member Baru --}}
        <a href="{{ route('members.index') }}" class="sidebar-link-light {{ request()->routeIs('members.*') ? 'active' : '' }}">
            <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            <span>Registrasi Calon</span>
        </a>

        {{-- Struktur Organisasi --}}
        <div x-data="{ open: {{ request()->routeIs('organizations.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="sidebar-link-light w-full justify-between {{ request()->routeIs('organizations.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Struktur Organisasi</span>
                </span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform {{ request()->routeIs('organizations.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-collapse class="mt-1 sidebar-submenu-light">
                <a href="{{ route('organizations.index') }}" class="sidebar-sublink-light {{ request()->routeIs('organizations.index') ? 'active' : '' }}">Daftar Struktur</a>
                <a href="{{ route('organizations.create') }}" class="sidebar-sublink-light {{ request()->routeIs('organizations.create') ? 'active' : '' }}">Tambah Struktur</a>
            </div>
        </div>

        {{-- Section: Publikasi & Edukasi --}}
        <div class="!mt-5 !mb-2 px-3">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Publikasi & Edukasi</span>
        </div>

        {{-- Informasi --}}
        <div x-data="{ open: {{ request()->routeIs('informations.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="sidebar-link-light w-full justify-between {{ request()->routeIs('informations.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <span>Informasi & Berita</span>
                </span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform {{ request()->routeIs('informations.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-collapse class="mt-1 sidebar-submenu-light">
                <a href="{{ route('informations.index') }}" class="sidebar-sublink-light {{ request()->routeIs('informations.index') ? 'active' : '' }}">Data Informasi</a>
                <a href="{{ route('informations.create') }}" class="sidebar-sublink-light {{ request()->routeIs('informations.create') ? 'active' : '' }}">Buat Informasi</a>
            </div>
        </div>

        {{-- Materi Belajar --}}
        <div x-data="{ open: {{ request()->routeIs('learnings.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="sidebar-link-light w-full justify-between {{ request()->routeIs('learnings.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>Materi Belajar</span>
                </span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform {{ request()->routeIs('learnings.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-collapse class="mt-1 sidebar-submenu-light">
                <a href="{{ route('learnings.index') }}" class="sidebar-sublink-light {{ request()->routeIs('learnings.index') ? 'active' : '' }}">Data Materi</a>
                <a href="{{ route('learnings.create') }}" class="sidebar-sublink-light {{ request()->routeIs('learnings.create') ? 'active' : '' }}">Buat Materi</a>
            </div>
        </div>

        {{-- Section: Operasional & Program --}}
        <div class="!mt-5 !mb-2 px-3">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Operasional</span>
        </div>

        {{-- Keuangan --}}
        <div x-data="{ open: {{ request()->routeIs('financials.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="sidebar-link-light w-full justify-between {{ request()->routeIs('financials.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Laporan Keuangan</span>
                </span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform {{ request()->routeIs('financials.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-collapse class="mt-1 sidebar-submenu-light">
                <a href="{{ route('financials.index') }}" class="sidebar-sublink-light {{ request()->routeIs('financials.index') ? 'active' : '' }}">Data Laporan</a>
                <a href="{{ route('financials.create') }}" class="sidebar-sublink-light {{ request()->routeIs('financials.create') ? 'active' : '' }}">Tambah Catatan</a>
            </div>
        </div>

        {{-- Program Sosial --}}
        <div x-data="{ open: {{ request()->routeIs('socials.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="sidebar-link-light w-full justify-between {{ request()->routeIs('socials.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span>Program Sosial</span>
                </span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform {{ request()->routeIs('socials.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-collapse class="mt-1 sidebar-submenu-light">
                <a href="{{ route('socials.index') }}" class="sidebar-sublink-light {{ request()->routeIs('socials.index') ? 'active' : '' }}">Data Program</a>
                <a href="{{ route('socials.create') }}" class="sidebar-sublink-light {{ request()->routeIs('socials.create') ? 'active' : '' }}">Tambah Program</a>
            </div>
        </div>

        {{-- Serikat SP PION --}}
        <div x-data="{ open: {{ request()->routeIs('unions.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="sidebar-link-light w-full justify-between {{ request()->routeIs('unions.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Serikat SP PION</span>
                </span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform {{ request()->routeIs('unions.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-collapse class="mt-1 sidebar-submenu-light">
                <a href="{{ route('unions.index') }}" class="sidebar-sublink-light {{ request()->routeIs('unions.index') ? 'active' : '' }}">Data Serikat</a>
                <a href="{{ route('unions.create') }}" class="sidebar-sublink-light {{ request()->routeIs('unions.create') ? 'active' : '' }}">Tambah Serikat</a>
            </div>
        </div>

        {{-- Pemilu / Voting --}}
        <div x-data="{ open: {{ request()->routeIs('votes.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="sidebar-link-light w-full justify-between {{ request()->routeIs('votes.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span>Pemilu / E-Vote</span>
                </span>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform {{ request()->routeIs('votes.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-collapse class="mt-1 sidebar-submenu-light">
                <a href="{{ route('votes.index') }}" class="sidebar-sublink-light {{ request()->routeIs('votes.index') ? 'active' : '' }}">Data Pemilu</a>
                <a href="{{ route('votes.create') }}" class="sidebar-sublink-light {{ request()->routeIs('votes.create') ? 'active' : '' }}">Buat Pemilu</a>
            </div>
        </div>

        {{-- Section: Komunikasi & Sistem --}}
        <div class="!mt-5 !mb-2 px-3">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Komunikasi & Sistem</span>
        </div>

        {{-- Pesan / Tiket --}}
        <a href="{{ route('tickets.index') }}" class="sidebar-link-light {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
            <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            <span>Pesan & Aspirasi</span>
        </a>

        {{-- Broadcasts --}}
        <a href="{{ route('broadcasts.index') }}" class="sidebar-link-light {{ request()->routeIs('broadcasts.*') ? 'active' : '' }}">
            <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            <span>Broadcast Pesan</span>
        </a>

        {{-- Perangkat --}}
        <a href="{{ route('devices.index') }}" class="sidebar-link-light {{ request()->routeIs('devices.*') ? 'active' : '' }}">
            <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            <span>Perangkat Aktif</span>
        </a>

        {{-- Visi Misi --}}
        <a href="{{ route('vision.edit') }}" class="sidebar-link-light {{ request()->routeIs('vision.*') ? 'active' : '' }}">
            <svg class="sidebar-icon-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span>Visi & Misi</span>
        </a>
    </nav>
</aside>
