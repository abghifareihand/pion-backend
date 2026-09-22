<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Login') - SP PION</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    {{-- Typography --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('css')
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col justify-between">

    @yield('content')

    {{-- Toast Notifications --}}
    <x-toast />

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    type: 'success',
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
                    message: "{{ session('error') }}"
                }
            }));
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
