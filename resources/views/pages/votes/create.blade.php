@extends('layouts.master')

@section('title')
    Buat Pemilu
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterange-picker.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Header Create -->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Teks di kiri --}}
                        <h5 class="fw-bold mb-0">Buat Pemilu</h5>

                        {{-- Tombol di kanan --}}
                        <a class="btn btn-primary" href="{{ route('votes.index') }}">
                            <i class="fa fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Create -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{-- Alert sukses --}}
                        @if (session('success'))
                            <div class="alert alert-soft-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Alert Error --}}
                        @if ($errors->any())
                            <div class="alert alert-soft-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
@endif


                        <form method="POST" action="{{ route('votes.store') }}">
                            @csrf

                            <!-- Input Title -->
                            <div class="mb-3">
                                <label>Judul</label>
                                <input class="form-control" type="text" name="title"
                                    value="{{ old('title') }}" required />
                            </div>

                            <!-- Input Description -->
                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>


                            {{-- Select Candidates --}}
                            <div class="mb-3">
                                <label>Pilih Kandidat (Maksimal 8)</label>
                                <div class="row">
                                    @foreach ($users as $user)
                                        <div class="col-md-6 mb-3">
                                            <div class="candidate-container p-2 border rounded">
                                                <label class="d-flex align-items-center mb-1 cursor-pointer" for="user_{{ $user->id }}">
                                                    <input class="checkbox_animated candidate-checkbox" id="user_{{ $user->id }}"
                                                        type="checkbox" name="options[]" value="{{ $user->id }}"
                                                        {{ in_array($user->id, old('options', [])) ? 'checked' : '' }}>
                                                    <span class="ms-2">{{ $user->name }}</span>
                                                </label>
                                                
                                                <div class="vision-field mt-2 {{ in_array($user->id, old('options', [])) ? '' : 'd-none' }}" id="vision_container_{{ $user->id }}">
                                                    <label class="small text-muted mb-1">Visi Misi Kandidat</label>
                                                    <textarea class="form-control form-control-sm" name="visions[{{ $user->id }}]" rows="2" placeholder="Masukkan visi misi untuk {{ $user->name }}...">{{ old('visions.' . $user->id) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <!-- Button Submit -->
                            <div class="text-end">
                                <button class="btn btn-success" type="submit">
                                    <i class="fa fa-save me-1"></i> Submit
                                </button>
                            </div>
                        </form>
                        {{-- End Form --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.candidate-checkbox');
            const maxCandidates = 8;

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const userId = this.value;
                    const visionContainer = document.getElementById(`vision_container_${userId}`);
                    
                    // Toggle vision field visibility
                    if (this.checked) {
                        visionContainer.classList.remove('d-none');
                    } else {
                        visionContainer.classList.add('d-none');
                    }

                    // Count checked
                    const checkedCount = document.querySelectorAll('.candidate-checkbox:checked').length;

                    if (checkedCount > maxCandidates) {
                        this.checked = false;
                        visionContainer.classList.add('d-none');
                        alert('Maksimal kandidat yang dapat dipilih adalah 8 orang.');
                    }
                });
            });
        });
    </script>
    <style>
        .cursor-pointer { cursor: pointer; }
        .candidate-container:hover { background-color: #f8f9fa; }
    </style>
    @endpush
@endsection
