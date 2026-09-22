@props([
    'title' => 'Belum ada data',
    'description' => null,
    'actionText' => null,
    'actionUrl' => null,
])

<div class="flex flex-col items-center justify-center text-center py-16 px-4">
    <div class="w-16 h-16 rounded-2xl bg-red-50/80 border border-red-100 flex items-center justify-center text-primary-600 mb-4 shadow-xs">
        @if (isset($icon))
            {{ $icon }}
        @else
            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        @endif
    </div>
    <h3 class="text-base font-semibold text-slate-800 tracking-tight">{{ $title }}</h3>
    @if ($description)
        <p class="text-sm text-slate-500 mt-1.5 max-w-sm mx-auto leading-relaxed">{{ $description }}</p>
    @endif
    @if ($actionText && $actionUrl)
        <a href="{{ $actionUrl }}" class="btn btn-primary mt-5 inline-flex items-center gap-2 shadow-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>{{ $actionText }}</span>
        </a>
    @endif
    {{ $slot }}
</div>
