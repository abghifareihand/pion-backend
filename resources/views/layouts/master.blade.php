<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - SP PION</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Page / Plugin CSS --}}
    @stack('css')
</head>
<body class="font-sans antialiased bg-slate-100/70 text-slate-800">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

        {{-- Sidebar Component --}}
        @include('layouts.partials.sidebar')

        {{-- Main Wrapper --}}
        <div class="flex-1 flex flex-col min-w-0 min-h-screen bg-slate-100/70">
            {{-- Top Navbar --}}
            @include('layouts.partials.header')

            {{-- Main Page Content --}}
            <main class="flex-1 p-4 lg:p-6 overflow-y-auto">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="py-4 px-6 border-t border-slate-200/60 bg-white/60 text-center flex items-center justify-center text-xs text-slate-400">
                <div>
                    &copy; {{ date('Y') }} <span class="font-semibold text-slate-600">Serikat Pekerja PION</span>. Hak Cipta Dilindungi.
                </div>
            </footer>
        </div>
    </div>

    {{-- Toast System --}}
    <x-toast />

    {{-- Global Confirmation Dialog --}}
    <x-confirm-dialog />

    {{-- Core jQuery for existing DataTables & Page scripts --}}
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>

    {{-- Session Toast Trigger Handlers --}}
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    type: 'success',
                    title: 'Berhasil',
                    message: "{{ session('success') }}"
                }
            }));
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    type: 'danger',
                    title: 'Gagal',
                    message: "{{ session('error') }}"
                }
            }));
        });
    </script>
    @endif

    @if (session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    type: 'info',
                    message: "{{ session('status') }}"
                }
            }));
        });
    </script>
    @endif

    {{-- PAGE SCRIPTS --}}
    @stack('scripts')
</body>
</html>
