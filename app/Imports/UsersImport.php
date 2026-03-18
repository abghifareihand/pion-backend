<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * TRICK UTAMA: Membersihkan data sebelum divalidasi.
     * Jika baris kosong atau baris contoh, kita gagalkan validasinya secara halus
     * agar tidak muncul pesan error "Wajib diisi".
     */
    public function prepareForValidation($data, $index)
    {
        // Jika Nama atau NIK kosong, atau ini baris contoh 'John Doe', kita kembalikan array kosong
        if (empty($data['nama']) || $data['nama'] == 'John Doe' || $data['nama'] == 'NAMA') {
            return [];
        }

        return $data;
    }

    public function model(array $row)
    {
        // Pengamanan tambahan: jika data kosong setelah dibersihkan prepareForValidation
        if (empty($row['nama'])) {
            return null;
        }

        // --- Proses Tanggal Lahir (Handle Excel Serial Date & String) ---
        $birthDate = null;
        if (!empty($row['tanggal_lahir'])) {
            try {
                if (is_numeric($row['tanggal_lahir'])) {
                    $birthDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']))->format('Y-m-d');
                }
                else {
                    $birthDate = Carbon::parse($row['tanggal_lahir'])->format('Y-m-d');
                }
            }
            catch (\Exception $e) {
                $birthDate = null;
            }
        }

        // --- Proses Jenis Kelamin ---
        $gender = null;
        if (!empty($row['jenis_kelamin'])) {
            $val = strtolower($row['jenis_kelamin']);
            $gender = (str_contains($val, 'laki')) ? 'male' : 'female';
        }

        // --- Proses Joint Date ---
        $jointDate = null;
        if (!empty($row['joint_date'])) {
            try {
                if (is_numeric($row['joint_date'])) {
                    $jointDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['joint_date']))->format('Y-m-d');
                }
                else {
                    $jointDate = Carbon::parse($row['joint_date'])->format('Y-m-d');
                }
            }
            catch (\Exception $e) {
                $jointDate = null;
            }
        }

        // --- Proses Nomor Telepon ---
        $phone = $row['no_telepon'] ?? $row['no_telp_wa'] ?? null;

        return new User([
            'name' => $row['nama'],
            'nik_ktp' => (string)($row['ktp'] ?? ''),
            'nik_karyawan' => (string)($row['nik'] ?? ''),
            'username' => (string)($row['ktp'] ?? ''),
            'kta_number' => (string)($row['kta'] ?? ''),
            'barcode_number' => (string)($row['barcode'] ?? ''),
            'email' => $row['email'] ?? null,
            'department' => $row['bagian'] ?? null,
            'phone' => (string)$phone,
            'birth_place' => $row['tempat_lahir'] ?? null, // Tempat lahir was removed from template as per header list
            'birth_date' => $birthDate,
            'joint_date' => $jointDate,
            'gender' => $gender,
            'religion' => $row['agama'] ?? null,
            'education' => $row['pendidikan'] ?? null,
            'address' => $row['alamat'] ?? null,
            'role' => 'user',
            'pin' => Hash::make((string)($row['pin'] ?? '123456')),
            'password' => Hash::make((string)($row['password'] ?? 'password123')),
            'pin_hint' => (string)($row['pin'] ?? '123456'),
            'password_hint' => (string)($row['password'] ?? 'password123'),
        ]);
    }

    public function rules(): array
    {
        /**
         * Menggunakan 'sometimes' agar jika baris dihapus di prepareForValidation,
         * rules ini tidak dijalankan untuk baris tersebut.
         */
        return [
            'nik' => 'sometimes|required',
            'kta' => 'sometimes|required',
            'nama' => 'sometimes|required|string|max:255',
            'ktp' => 'sometimes|nullable|string|max:255',
            'alamat' => 'sometimes|required',
            'tempat_lahir' => 'sometimes|required',
            'tanggal_lahir' => 'sometimes|required',
            'joint_date' => 'sometimes|required',
            'jenis_kelamin' => 'sometimes|required',
            'bagian' => 'sometimes|required',
            'agama' => 'sometimes|required',
            'email' => 'sometimes|nullable',
            'pendidikan' => 'sometimes|required',
            'no_telepon' => 'sometimes|nullable',
            'barcode' => 'sometimes|required',
            'pin' => 'sometimes|required',
            'password' => 'sometimes|required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK wajib diisi.',
            'kta.required' => 'KTA wajib diisi.',
            'nama.required' => 'NAMA wajib diisi.',
            'alamat.required' => 'ALAMAT wajib diisi.',
            'tempat_lahir.required' => 'TEMPAT LAHIR wajib diisi.',
            'tanggal_lahir.required' => 'TANGGAL LAHIR wajib diisi.',
            'joint_date.required' => 'JOINT DATE wajib diisi.',
            'jenis_kelamin.required' => 'JENIS KELAMIN wajib diisi.',
            'bagian.required' => 'BAGIAN wajib diisi.',
            'agama.required' => 'AGAMA wajib diisi.',
            'pendidikan.required' => 'PENDIDIKAN wajib diisi.',
            'barcode.required' => 'BARCODE wajib diisi.',
            'pin.required' => 'PIN wajib diisi.',
            'password.required' => 'PASSWORD wajib diisi.',
        ];
    }
}