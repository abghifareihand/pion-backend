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
    public function model(array $row)
    {
        // Skip header or empty rows or sample row
        if (!isset($row['nama']) || empty($row['nama']) || $row['nama'] == 'John Doe' || $row['nama'] == 'Nama') {
            return null;
        }

        $birthDate = null;
        if (!empty($row['tanggal_lahir'])) {
            try {
                // Handle different date formats or scientific notation from Excel
                $birthDate = Carbon::createFromFormat('d/m/Y', $row['tanggal_lahir'])->format('Y-m-d');
            } catch (\Exception $e) {
                // If it's a numeric date from Excel (Excel serial date)
                if (is_numeric($row['tanggal_lahir'])) {
                    $birthDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']))->format('Y-m-d');
                }
            }
        }

        $gender = null;
        if (!empty($row['jenis_kelamin'])) {
            $val = strtolower($row['jenis_kelamin']);
            $gender = ($val == 'laki-laki') ? 'male' : 'female';
        }

        // Use the correct heading slug for phone number: no_telp_wa
        $phone = $row['no_telp_wa'] ?? $row['no_telepon'] ?? null;

        return new User([
            'name'           => $row['nama'],
            'nik_ktp'        => (string)$row['nik_ktp'],
            'nik_karyawan'   => (string)$row['nik_karyawan'],
            'username'       => (string)$row['nik_ktp'],
            'kta_number'     => (string)$row['nomor_kta'],
            'barcode_number' => (string)$row['nomor_barcode'],
            'email'          => $row['email'],
            'department'     => $row['departemen'],
            'phone'          => (string)$phone,
            'birth_place'    => $row['tempat_lahir'],
            'birth_date'     => $birthDate,
            'gender'         => $gender,
            'religion'       => $row['agama'],
            'education'      => $row['pendidikan'],
            'address'        => $row['alamat'],
            'role'           => 'user',
            'pin'            => Hash::make((string)$row['pin_6_digit']),
            'password'       => Hash::make((string)$row['password']),
        ]);
    }

    public function rules(): array
    {
        return [
            'nama'           => 'required|string|max:255',
            'nik_ktp'        => 'required|unique:users,nik_ktp',
            'nik_karyawan'   => 'nullable|unique:users,nik_karyawan',
            'nomor_kta'      => 'nullable|unique:users,kta_number',
            'nomor_barcode'  => 'nullable|unique:users,barcode_number',
            'email'          => 'nullable|email|unique:users,email',
            'pin_6_digit'    => 'required|digits:6',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik_ktp.unique'      => 'NIK KTP :input sudah digunakan.',
            'nik_karyawan.unique' => 'NIK Karyawan :input sudah digunakan.',
            'nomor_kta.unique'    => 'Nomor KTA :input sudah digunakan.',
            'nomor_barcode.unique' => 'Nomor barcode :input sudah digunakan.',
            'email.unique'        => 'Email :input sudah digunakan.',
            'pin_6_digit.required' => 'PIN wajib diisi.',
            'pin_6_digit.digits'   => 'PIN harus berupa 6 digit angka.',
        ];
    }
}
