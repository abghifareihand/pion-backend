<header class="h-16 bg-white/80 backdrop-blur-sm border-b border-slate-200/60 flex items-center justify-between px-4 lg:px-6 sticky top-0 z-30 shadow-xs">
    {{-- Left: Mobile menu + Breadcrumb --}}
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        {{-- Breadcrumb --}}
        <nav class="hidden sm:flex items-center gap-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Dashboard</a>
            @hasSection('breadcrumb')
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                @yield('breadcrumb')
            @endif
        </nav>
    </div>

    {{-- Right: Notifications & Profile Dropdown --}}
    <div class="flex items-center gap-3">
        {{-- Profile Dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-slate-100 transition-colors focus:outline-none">
                <div class="w-9 h-9 bg-primary-600 rounded-xl flex items-center justify-center text-white text-sm font-bold shadow-xs">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-bold text-slate-800 leading-tight">{{ Auth::user()->name ?? 'Super Admin' }}</p>
                    <p class="text-xs text-slate-500 font-medium">SP PION</p>
                </div>
                <svg class="w-4 h-4 text-slate-400 hidden md:block transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Dropdown Menu (Exact Match with Reference Image 4) --}}
            <div x-show="open" 
                 @click.outside="open = false" 
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 x-cloak 
                 class="absolute right-0 top-full mt-2 w-72 bg-white rounded-2xl border border-slate-200 shadow-2xl z-50 overflow-hidden origin-top-right">
                
                {{-- User Info Header --}}
                <div class="p-4 border-b border-slate-100 bg-white">
                    <p class="text-sm font-bold text-slate-900 leading-tight">{{ Auth::user()->name ?? 'Super Admin' }}</p>
                    <p class="text-xs text-slate-500 mt-0.5 truncate">{{ Auth::user()->email ?? 'admin@pion.org' }}</p>
                    <div class="mt-2.5 flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-primary-700 text-xs font-semibold rounded-lg border border-red-100/70">
                            <svg class="w-3.5 h-3.5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            SP PION
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-lg">
                            {{ ucfirst(Auth::user()->role ?? 'Admin') }}
                        </span>
                    </div>
                </div>

                {{-- Links --}}
                <div class="py-1.5 px-1">
                    <a href="{{ route('profile.index') }}" class="dropdown-item flex items-center gap-2.5 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg transition-colors font-medium">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Profil</span>
                    </a>
                    <a href="{{ route('settings.edit') }}" class="dropdown-item flex items-center gap-2.5 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg transition-colors font-medium">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Pengaturan</span>
                    </a>
                </div>

                <div class="border-t border-slate-100 my-1"></div>

                {{-- Logout Button --}}
                <div class="py-1 px-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors font-medium text-left">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
