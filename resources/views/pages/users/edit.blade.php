@extends('layouts.master')

@section('title', 'Edit Anggota')

@section('breadcrumb')
    <a href="{{ route('users.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Data Anggota</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Edit Anggota</span>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Data Anggota</h1>
            <p class="text-slate-500 text-sm mt-0.5">Perbarui informasi anggota <span class="font-semibold text-slate-700">{{ $user->name }}</span>.</p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-secondary gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>Lihat Detail</span>
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-ghost gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali</span>
            </a>
        </div>
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

    <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Section 1: Data Identitas & Serikat --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Identitas & Serikat</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="form-label" for="name">Nama Lengkap <span class="text-danger-500">*</span></label>
                        <input class="input @error('name') border-danger-500 @enderror" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required />
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIK KTP --}}
                    <div>
                        <label class="form-label" for="nik_ktp">NIK KTP</label>
                        <input class="input @error('nik_ktp') border-danger-500 @enderror" type="text" id="nik_ktp" name="nik_ktp" value="{{ old('nik_ktp', $user->nik_ktp) }}" maxlength="20" pattern="\d*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                        @error('nik_ktp') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIK Karyawan --}}
                    <div>
                        <label class="form-label" for="nik_karyawan">NIK Karyawan <span class="text-danger-500">*</span></label>
                        <input class="input @error('nik_karyawan') border-danger-500 @enderror" type="text" id="nik_karyawan" name="nik_karyawan" value="{{ old('nik_karyawan', $user->nik_karyawan) }}" maxlength="20" required />
                        @error('nik_karyawan') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nomor KTA --}}
                    <div>
                        <label class="form-label" for="kta_number">Nomor KTA <span class="text-danger-500">*</span></label>
                        <input class="input @error('kta_number') border-danger-500 @enderror" type="text" id="kta_number" name="kta_number" value="{{ old('kta_number', $user->kta_number) }}" maxlength="15" pattern="\d*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required />
                        @error('kta_number') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nomor Barcode --}}
                    <div>
                        <label class="form-label" for="barcode_number">Nomor Barcode <span class="text-danger-500">*</span></label>
                        <input class="input @error('barcode_number') border-danger-500 @enderror" type="text" id="barcode_number" name="barcode_number" value="{{ old('barcode_number', $user->barcode_number) }}" maxlength="20" pattern="\d*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required />
                        @error('barcode_number') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Departemen --}}
                    <div>
                        <label class="form-label" for="department">Departemen <span class="text-danger-500">*</span></label>
                        <input class="input @error('department') border-danger-500 @enderror" type="text" id="department" name="department" value="{{ old('department', $user->department) }}" required />
                        @error('department') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Join --}}
                    <div>
                        <label class="form-label" for="joint_date">Tanggal Bergabung</label>
                        <input class="input @error('joint_date') border-danger-500 @enderror" type="date" id="joint_date" name="joint_date" value="{{ old('joint_date', $user->joint_date ? \Carbon\Carbon::parse($user->joint_date)->format('Y-m-d') : '') }}" />
                        @error('joint_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Data Pribadi & Kontak --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Pribadi & Kontak</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="form-label" for="gender">Jenis Kelamin <span class="text-danger-500">*</span></label>
                        <select class="input @error('gender') border-danger-500 @enderror" id="gender" name="gender" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- No Telepon / WA --}}
                    <div>
                        <label class="form-label" for="phone">No Telepon / WhatsApp</label>
                        <input class="input @error('phone') border-danger-500 @enderror" type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" maxlength="15" pattern="\d*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                        @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="form-label" for="email">Alamat Email</label>
                        <input class="input @error('email') border-danger-500 @enderror" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" />
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div>
                        <label class="form-label" for="birth_place">Tempat Lahir</label>
                        <input class="input @error('birth_place') border-danger-500 @enderror" type="text" id="birth_place" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}" />
                        @error('birth_place') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="form-label" for="birth_date">Tanggal Lahir</label>
                        <input class="input @error('birth_date') border-danger-500 @enderror" type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}" />
                        @error('birth_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Agama --}}
                    <div>
                        <label class="form-label" for="religion">Agama <span class="text-danger-500">*</span></label>
                        <select class="input @error('religion') border-danger-500 @enderror" id="religion" name="religion" required>
                            <option value="">-- Pilih Agama --</option>
                            @php
                                $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'];
                            @endphp
                            @foreach ($religions as $item)
                                <option value="{{ $item }}" {{ old('religion', $user->religion) == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('religion') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Pendidikan --}}
                    <div>
                        <label class="form-label" for="education">Pendidikan Terakhir <span class="text-danger-500">*</span></label>
                        <select class="input @error('education') border-danger-500 @enderror" id="education" name="education" required>
                            <option value="">-- Pilih Pendidikan --</option>
                            @php
                                $educations = ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3'];
                            @endphp
                            @foreach ($educations as $item)
                                <option value="{{ $item }}" {{ old('education', $user->education) == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('education') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label class="form-label" for="address">Alamat Domisili <span class="text-danger-500">*</span></label>
                        <textarea class="input @error('address') border-danger-500 @enderror" id="address" name="address" rows="3" required>{{ old('address', $user->address) }}</textarea>
                        @error('address') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Keamanan & Akses Akun --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Keamanan & Kredensial Akun</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- PIN --}}
                    <div>
                        <label class="form-label" for="pin">PIN Aplikasi</label>
                        <input class="input font-mono @error('pin') border-danger-500 @enderror" type="text" id="pin" name="pin" value="{{ old('pin', $user->pin_hint) }}" maxlength="6" pattern="\d*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                        <p class="form-help text-xs text-slate-500">
                            PIN saat ini: <span class="font-semibold text-primary-600">{{ $user->pin_hint ?? '-' }}</span>
                        </p>
                        @error('pin') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="form-label" for="password">Password Baru (Opsional)</label>
                        <input class="input @error('password') border-danger-500 @enderror" type="text" id="password" name="password" value="{{ old('password', $user->password_hint) }}" />
                        <p class="form-help text-xs text-slate-500">
                            Password saat ini: <span class="font-semibold text-primary-600">{{ $user->password_hint ?? '-' }}</span>
                        </p>
                        @error('password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Card Footer Submit --}}
            <div class="card-footer flex items-center justify-end gap-3">
                <a href="{{ route('users.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Perbarui Data Anggota</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
