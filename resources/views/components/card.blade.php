@props([
    'title' => null,
    'description' => null,
    'action' => null,
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'card ' . $class]) }}>
    @if ($title || $action)
        <div class="card-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                @if ($title)
                    <h3 class="card-title">{{ $title }}</h3>
                @endif
                @if ($description)
                    <p class="card-description">{{ $description }}</p>
                @endif
            </div>
            @if ($action)
                <div class="flex items-center gap-2">
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
