<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Seed Super Admin
        User::create([
            'name' => 'Super Admin',
            'nik' => '12345678',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '08123456789',
            'department' => 'IT System',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'pin' => Hash::make('000000'),
        ]);

        // 2. Daftar 15 User Biasa
        $users = [
            ['name' => 'Abghi Fareihan', 'nik' => '10000001', 'username' => 'abghi', 'email' => 'abghi@gmail.com', 'phone' => '087777711022', 'dept' => 'IT', 'gender' => 'male'],
            ['name' => 'Agus Santoso', 'nik' => '10000002', 'username' => 'agus', 'email' => 'agus@gmail.com', 'phone' => '08111111111', 'dept' => 'Logistik', 'gender' => 'male'],
            ['name' => 'Jatmiko Prasetyo', 'nik' => '10000003', 'username' => 'jatmiko', 'email' => 'jatmiko@gmail.com', 'phone' => '08222222222', 'dept' => 'Maintenance', 'gender' => 'male'],
            ['name' => 'Sukocai Rahman', 'nik' => '10000004', 'username' => 'sukocai', 'email' => 'sukocai@gmail.com', 'phone' => '08333333333', 'dept' => 'Produksi', 'gender' => 'male'],
            ['name' => 'Dewi Lestari', 'nik' => '10000005', 'username' => 'dewi', 'email' => 'dewi@gmail.com', 'phone' => '08444444444', 'dept' => 'HRD', 'gender' => 'female'],
            ['name' => 'Rizky Maulana', 'nik' => '10000006', 'username' => 'rizky', 'email' => 'rizky@gmail.com', 'phone' => '08555555555', 'dept' => 'Quality Control', 'gender' => 'male'],
            ['name' => 'Fajar Nugroho', 'nik' => '10000007', 'username' => 'fajar', 'email' => 'fajar@gmail.com', 'phone' => '08666666666', 'dept' => 'Logistik', 'gender' => 'male'],
            ['name' => 'Indah Permata', 'nik' => '10000008', 'username' => 'indah', 'email' => 'indah@gmail.com', 'phone' => '08777777777', 'dept' => 'Accounting', 'gender' => 'female'],
            ['name' => 'Budi Santoso', 'nik' => '10000009', 'username' => 'budi', 'email' => 'budi@gmail.com', 'phone' => '08888888888', 'dept' => 'Produksi', 'gender' => 'male'],
            ['name' => 'Siti Aminah', 'nik' => '10000010', 'username' => 'siti', 'email' => 'siti@gmail.com', 'phone' => '08999999999', 'dept' => 'Warehouse', 'gender' => 'female'],
            ['name' => 'Ahmad Fauzi', 'nik' => '10000011', 'username' => 'ahmad', 'email' => 'ahmad@gmail.com', 'phone' => '08101010101', 'dept' => 'Utility', 'gender' => 'male'],
            ['name' => 'Lestari Putri', 'nik' => '10000012', 'username' => 'lestari', 'email' => 'lestari@gmail.com', 'phone' => '08121212121', 'dept' => 'HRD', 'gender' => 'female'],
            ['name' => 'Bambang Pamungkas', 'nik' => '10000013', 'username' => 'bambang', 'email' => 'bambang@gmail.com', 'phone' => '08131313131', 'dept' => 'Security', 'gender' => 'male'],
            ['name' => 'Siska Amelia', 'nik' => '10000014', 'username' => 'siska', 'email' => 'siska@gmail.com', 'phone' => '08141414141', 'dept' => 'Finance', 'gender' => 'female'],
            ['name' => 'Eko Prasetyo', 'nik' => '10000015', 'username' => 'eko', 'email' => 'eko@gmail.com', 'phone' => '08151515151', 'dept' => 'Produksi', 'gender' => 'male'],
        ];

        // 3. Loop dan Create
        foreach ($users as $user) {
            User::create([
                'name'          => $user['name'],
                'nik'           => $user['nik'],
                'username'      => $user['username'],
                // 'email'         => $user['email'],
                'phone'         => $user['phone'],
                'department'    => $user['dept'],
                'birth_place'   => 'Bogor',
                'birth_date'    => '1990-01-01',
                'address'       => 'Jl. Raya Industri No. ' . rand(1, 100),
                'gender'        => $user['gender'],
                'religion'      => 'Islam',
                'education'     => 'SMA/K',
                'role'          => 'user',
                'password'      => Hash::make('password1234'),
                'pin'           => Hash::make('123456'),
            ]);
        }
    }
}
