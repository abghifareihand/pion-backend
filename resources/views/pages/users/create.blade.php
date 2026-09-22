@extends('layouts.master')

@section('title', 'Buat Anggota')

@section('breadcrumb')
    <a href="{{ route('users.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">Data Anggota</a>
    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-700 font-medium">Buat Anggota</span>
@endsection

@section('content')
<div class="w-full space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Buat Anggota Baru</h1>
            <p class="text-slate-500 text-sm mt-0.5">Lengkapi formulir di bawah untuk menambahkan data anggota SP PION.</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-ghost gap-1.5 self-start sm:self-auto">
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

    <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
        @csrf

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
                        <input class="input @error('name') border-danger-500 @enderror" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required />
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIK KTP --}}
                    <div>
                        <label class="form-label" for="nik_ktp">NIK KTP</label>
                        <input class="input @error('nik_ktp') border-danger-500 @enderror" type="text" id="nik_ktp" name="nik_ktp" value="{{ old('nik_ktp') }}" maxlength="20" pattern="\d*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="16 digit NIK KTP" />
                        @error('nik_ktp') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIK Karyawan --}}
                    <div>
                        <label class="form-label" for="nik_karyawan">NIK Karyawan <span class="text-danger-500">*</span></label>
                        <input class="input @error('nik_karyawan') border-danger-500 @enderror" type="text" id="nik_karyawan" name="nik_karyawan" value="{{ old('nik_karyawan') }}" maxlength="20" required placeholder="Nomor induk karyawan" />
                        @error('nik_karyawan') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nomor KTA --}}
                    <div>
                        <label class="form-label" for="kta_number">Nomor KTA <span class="text-danger-500">*</span></label>
                        <input class="input @error('kta_number') border-danger-500 @enderror" type="text" id="kta_number" name="kta_number" value="{{ old('kta_number') }}" maxlength="15" pattern="\d*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required placeholder="Nomor KTA serikat" />
                        @error('kta_number') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nomor Barcode --}}
                    <div>
                        <label class="form-label" for="barcode_number">Nomor Barcode <span class="text-danger-500">*</span></label>
                        <input class="input @error('barcode_number') border-danger-500 @enderror" type="text" id="barcode_number" name="barcode_number" value="{{ old('barcode_number') }}" maxlength="20" pattern="\d*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required placeholder="Nomor barcode KTA" />
                        @error('barcode_number') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Departemen --}}
                    <div>
                        <label class="form-label" for="department">Departemen <span class="text-danger-500">*</span></label>
                        <input class="input @error('department') border-danger-500 @enderror" type="text" id="department" name="department" value="{{ old('department') }}" required placeholder="Contoh: Produksi, IT, HRD" />
                        @error('department') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Join --}}
                    <div>
                        <label class="form-label" for="joint_date">Tanggal Bergabung</label>
                        <input class="input @error('joint_date') border-danger-500 @enderror" type="date" id="joint_date" name="joint_date" value="{{ old('joint_date') }}" />
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
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- No Telepon / WA --}}
                    <div>
                        <label class="form-label" for="phone">No Telepon / WhatsApp</label>
                        <input class="input @error('phone') border-danger-500 @enderror" type="text" id="phone" name="phone" value="{{ old('phone') }}" maxlength="15" pattern="\d*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="08xxxxxxxxxx" />
                        @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="form-label" for="email">Alamat Email</label>
                        <input class="input @error('email') border-danger-500 @enderror" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" />
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div>
                        <label class="form-label" for="birth_place">Tempat Lahir</label>
                        <input class="input @error('birth_place') border-danger-500 @enderror" type="text" id="birth_place" name="birth_place" value="{{ old('birth_place') }}" placeholder="Kota kelahiran" />
                        @error('birth_place') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="form-label" for="birth_date">Tanggal Lahir</label>
                        <input class="input @error('birth_date') border-danger-500 @enderror" type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" />
                        @error('birth_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Agama --}}
                    <div>
                        <label class="form-label" for="religion">Agama <span class="text-danger-500">*</span></label>
                        <select class="input @error('religion') border-danger-500 @enderror" id="religion" name="religion" required>
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Khonghucu" {{ old('religion') == 'Khonghucu' || old('religion') == 'Konghucu' ? 'selected' : '' }}>Khonghucu</option>
                            <option value="Lainnya" {{ old('religion') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('religion') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Pendidikan --}}
                    <div>
                        <label class="form-label" for="education">Pendidikan Terakhir <span class="text-danger-500">*</span></label>
                        <select class="input @error('education') border-danger-500 @enderror" id="education" name="education" required>
                            <option value="">-- Pilih Pendidikan --</option>
                            <option value="SD" {{ old('education') == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('education') == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA/SMK" {{ old('education') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ old('education') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('education') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('education') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('education') == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('education') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label class="form-label" for="address">Alamat Domisili <span class="text-danger-500">*</span></label>
                        <textarea class="input @error('address') border-danger-500 @enderror" id="address" name="address" rows="3" required placeholder="Alamat lengkap tempat tinggal">{{ old('address') }}</textarea>
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
                        <label class="form-label" for="pin">PIN Aplikasi (6 Digit) <span class="text-danger-500">*</span></label>
                        <input class="input font-mono @error('pin') border-danger-500 @enderror" type="text" id="pin" name="pin" value="{{ old('pin', '123456') }}" maxlength="6" pattern="\d*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required />
                        <p class="form-help text-xs text-slate-500">Default: 123456 (dapat diubah anggota via aplikasi)</p>
                        @error('pin') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="form-label" for="password">Password Default <span class="text-danger-500">*</span></label>
                        <input class="input @error('password') border-danger-500 @enderror" type="text" id="password" name="password" value="{{ old('password', 'password123') }}" required />
                        <p class="form-help text-xs text-slate-500">Default: password123</p>
                        @error('password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Card Footer Submit --}}
            <div class="card-footer flex items-center justify-end gap-3">
                <a href="{{ route('users.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary shadow-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Anggota</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
