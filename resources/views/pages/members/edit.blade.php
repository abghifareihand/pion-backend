@extends('layouts.master')

@section('title', 'Edit Registrasi Calon Anggota')

@section('breadcrumb')
    <a href="{{ route('members.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Registrasi Calon</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Edit Pendaftaran</span>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Pendaftaran Calon Anggota</h1>
            <p class="text-slate-500 text-sm mt-0.5">Perbaiki atau verifikasi data registrasi formulir anggota SP PION.</p>
        </div>
        <a href="{{ route('members.index') }}" class="btn btn-sm btn-ghost gap-1.5 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Alert Errors --}}
    @if ($errors->any())
        <x-alert type="danger" title="Terjadi Kesalahan Input">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulir Data Calon Anggota</h3>
        </div>
        <form method="POST" action="{{ route('members.update', $member->id) }}">
            @csrf
            @method('PUT')
            <div class="card-body space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="form-label" for="name">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input class="input @error('name') border-red-500 @enderror" type="text" id="name" name="name" value="{{ old('name', $member->name) }}" required />
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIK KTP --}}
                    <div>
                        <label class="form-label" for="nik_ktp">NIK KTP <span class="text-red-500">*</span></label>
                        <input class="input @error('nik_ktp') border-red-500 @enderror" type="text" id="nik_ktp" name="nik_ktp" value="{{ old('nik_ktp', $member->nik_ktp) }}" required />
                        @error('nik_ktp') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIK Karyawan --}}
                    <div>
                        <label class="form-label" for="nik_karyawan">NIK Karyawan <span class="text-red-500">*</span></label>
                        <input class="input @error('nik_karyawan') border-red-500 @enderror" type="text" id="nik_karyawan" name="nik_karyawan" value="{{ old('nik_karyawan', $member->nik_karyawan) }}" required />
                        @error('nik_karyawan') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Departemen --}}
                    <div>
                        <label class="form-label" for="department">Departemen <span class="text-red-500">*</span></label>
                        <input class="input @error('department') border-red-500 @enderror" type="text" id="department" name="department" value="{{ old('department', $member->department) }}" required />
                        @error('department') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- No Telepon / WA --}}
                    <div>
                        <label class="form-label" for="phone">No Telepon / WhatsApp <span class="text-red-500">*</span></label>
                        <input class="input @error('phone') border-red-500 @enderror" type="text" id="phone" name="phone" value="{{ old('phone', $member->phone) }}" required />
                        @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div>
                        <label class="form-label" for="birth_place">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input class="input @error('birth_place') border-red-500 @enderror" type="text" id="birth_place" name="birth_place" value="{{ old('birth_place', $member->birth_place) }}" required />
                        @error('birth_place') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Lahir (Format: d/m/Y) --}}
                    <div>
                        <label class="form-label" for="birth_date">Tanggal Lahir (DD/MM/YYYY) <span class="text-red-500">*</span></label>
                        <input class="input @error('birth_date') border-red-500 @enderror" type="text" id="birth_date" name="birth_date"
                            value="{{ old('birth_date', $member->birth_date ? \Carbon\Carbon::parse($member->birth_date)->format('d/m/Y') : '') }}"
                            placeholder="Contoh: 17/08/1995" required />
                        @error('birth_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="form-label" for="gender">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select class="input @error('gender') border-red-500 @enderror" id="gender" name="gender" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Agama --}}
                    <div>
                        <label class="form-label" for="religion">Agama</label>
                        <select class="input" id="religion" name="religion">
                            <option value="">-- Pilih Agama --</option>
                            @php $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya']; @endphp
                            @foreach ($religions as $item)
                                <option value="{{ $item }}" {{ old('religion', $member->religion) == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pendidikan --}}
                    <div>
                        <label class="form-label" for="education">Pendidikan Terakhir</label>
                        <select class="input" id="education" name="education">
                            <option value="">-- Pilih Pendidikan --</option>
                            @php $educations = ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3']; @endphp
                            @foreach ($educations as $item)
                                <option value="{{ $item }}" {{ old('education', $member->education) == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label class="form-label" for="address">Alamat Domisili <span class="text-red-500">*</span></label>
                        <textarea class="input @error('address') border-red-500 @enderror" id="address" name="address" rows="3" required>{{ old('address', $member->address) }}</textarea>
                        @error('address') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer flex items-center justify-end gap-3">
                <a href="{{ route('members.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
