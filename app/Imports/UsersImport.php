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

        // --- Proses Nomor Telepon ---
        $phone = $row['no_telepon'] ?? $row['no_telp_wa'] ?? null;

        return new User([
            'name' => $row['nama'],
            'nik_ktp' => (string)$row['ktp'],
            'nik_karyawan' => (string)($row['nik'] ?? ''),
            'username' => (string)$row['ktp'],
            'kta_number' => (string)($row['kta'] ?? ''),
            'barcode_number' => (string)($row['barcode'] ?? ''),
            'email' => $row['email'] ?? null,
            'department' => $row['bagian'] ?? null,
            'phone' => (string)$phone,
            'birth_place' => $row['tempat_lahir'] ?? null, // Tempat lahir was removed from template as per header list
            'birth_date' => $birthDate,
            'gender' => $gender,
            'religion' => $row['agama'] ?? null,
            'education' => $row['pendidikan'] ?? null,
            'address' => $row['alamat'] ?? null,
            'role' => 'user',
            'pin' => Hash::make((string)($row['pin'] ?? '123456')),
            'password' => Hash::make((string)($row['password'] ?? 'password')),
        ]);
    }

    public function rules(): array
    {
        /**
         * Menggunakan 'sometimes' agar jika baris dihapus di prepareForValidation,
         * rules ini tidak dijalankan untuk baris tersebut.
         */
        return [
            'nama' => 'sometimes|required|string|max:255',
            'ktp' => 'sometimes|required',
            'pin' => 'sometimes|required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Baris :index: NAMA wajib diisi.',
            'ktp.required' => 'Baris :index: KTP wajib diisi.',
            'pin.required' => 'Baris :index: PIN wajib diisi.',
        ];
    }
}