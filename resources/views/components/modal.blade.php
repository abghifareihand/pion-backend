@props([
    'name',
    'title' => '',
    'size' => 'md', // sm, md, lg, xl
    'show' => false
])

@php
$sizeClasses = [
    'sm' => 'max-w-md',
    'md' => 'max-w-lg',
    'lg' => 'max-w-2xl',
    'xl' => 'max-w-4xl',
][$size] ?? 'max-w-lg';
@endphp

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:keydown.escape.window="show = false"
    style="display: {{ $show ? 'block' : 'none' }};"
    class="fixed inset-0 z-50 overflow-y-auto"
    x-cloak
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
        @click="show = false"
    ></div>

    {{-- Modal Panel --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div
            x-show="show"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full {{ $sizeClasses }} bg-white rounded-2xl shadow-2xl overflow-hidden"
            @click.stop
        >
            @if ($title)
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">{{ $title }}</h3>
                <button @click="show = false" class="text-slate-400 hover:text-slate-600 rounded-lg p-1 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            <div class="p-6">
                {{ $slot }}
            </div>

            @isset($footer)
            <div class="flex items-center justify-end gap-3 px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $footer }}
            </div>
            @endisset
        </div>
    </div>
</div>
