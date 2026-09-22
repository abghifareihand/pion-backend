@props([
    'name',
    'id' => null,
    'accept' => null,
    'required' => false,
    'placeholder' => 'No file chosen',
    'value' => null,
    'class' => '',
])

@php
    $inputId = $id ?? $name . '_' . Str::random(6);
    $hasError = $errors->has($name);
@endphp

<div 
    x-data="{
        filename: '{{ $value ? basename($value) : '' }}',
        hasFile: {{ $value ? 'true' : 'false' }},
        isDragging: false,
        updateFile(e) {
            const input = this.$refs.fileInput;
            const file = e ? (e.target.files && e.target.files[0]) : (input.files && input.files[0]);
            if (file) {
                this.filename = file.name;
                this.hasFile = true;
            } else {
                this.clear();
            }
        },
        handleDrop(e) {
            this.isDragging = false;
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                this.$refs.fileInput.files = e.dataTransfer.files;
                this.updateFile();
            }
        },
        clear() {
            this.$refs.fileInput.value = '';
            this.filename = '';
            this.hasFile = false;
            this.$refs.fileInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }" 
    class="relative w-full {{ $class }}"
    @dragover.prevent="isDragging = true"
    @dragleave.prevent="isDragging = false"
    @drop.prevent="handleDrop($event)"
>
    <!-- Actual Hidden Native File Input -->
    <input 
        type="file" 
        id="{{ $inputId }}" 
        name="{{ $name }}" 
        x-ref="fileInput"
        @change="updateFile($event)"
        @if($accept) accept="{{ $accept }}" @endif
        @if($required) :required="!hasFile" @endif
        class="sr-only"
        tabindex="-1"
    />

    <!-- Visual Styled Container with default project field border (#cbd5e1) -->
    <div 
        @click="$refs.fileInput.click()"
        :class="{
            'border-[#AA2224] ring-2 ring-[#AA2224]/10 bg-red-50/20': isDragging,
            'border-red-500 ring-1 ring-red-200': {{ $hasError ? 'true' : 'false' }},
            'border-[#cbd5e1] hover:border-[#94a3b8]': !isDragging && !{{ $hasError ? 'true' : 'false' }}
        }"
        class="w-full flex items-center justify-between border bg-white rounded-[10px] px-3 py-2 text-sm transition-colors cursor-pointer select-none group min-h-[42px]"
    >
        <!-- Left: Choose File Pill (Crimson brand theme) & File Name -->
        <div class="flex items-center gap-3 min-w-0 flex-1">
            <button 
                type="button" 
                class="inline-flex items-center justify-center px-3 py-1 bg-red-50 group-hover:bg-red-100 text-[#AA2224] text-xs font-semibold rounded-lg border border-red-200/80 transition-colors cursor-pointer shrink-0"
                tabindex="-1"
            >
                Choose File
            </button>

            <span 
                class="truncate text-sm"
                :class="hasFile ? 'text-slate-800 font-medium' : 'text-slate-500'"
                x-text="hasFile ? filename : '{{ $placeholder }}'"
            >
                {{ $value ? basename($value) : $placeholder }}
            </span>
        </div>

        <!-- Right: Clear [X] Button (Shown when a file is selected) -->
        <button 
            type="button" 
            x-show="hasFile" 
            x-cloak
            @click.stop="clear()" 
            class="p-1 text-slate-400 hover:text-[#AA2224] hover:bg-red-50 rounded-md transition-colors cursor-pointer shrink-0 ml-2"
            title="Hapus berkas terpilih"
            aria-label="Hapus berkas"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
