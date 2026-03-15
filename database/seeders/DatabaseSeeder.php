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
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Super Admin',
                'nik_ktp' => '12345678',
                'nik_karyawan' => '12345678',
                'email' => 'admin@gmail.com',
                'phone' => '08123456789',
                'department' => 'IT System',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'pin' => Hash::make('000000'),
            ]
        );

        // 2. Seed 10 Users
        $users = [
            ['name' => 'Budi Santoso', 'username' => 'budi'],
            ['name' => 'Siti Aminah', 'username' => 'siti'],
            ['name' => 'Agus Setiawan', 'username' => 'agus'],
            ['name' => 'Ani Wijaya', 'username' => 'ani'],
            ['name' => 'Bambang Hartono', 'username' => 'bambang'],
            ['name' => 'Ratna Sari', 'username' => 'ratna'],
            ['name' => 'Dedi Kurniawan', 'username' => 'dedi'],
            ['name' => 'Linda Permata', 'username' => 'linda'],
            ['name' => 'Eko Prasetyo', 'username' => 'eko'],
            ['name' => 'Maya Indah', 'username' => 'maya'],
        ];

        foreach ($users as $index => $u) {
            User::updateOrCreate(
                ['username' => $u['username']],
                [
                    'name' => $u['name'],
                    'nik_ktp' => '3201' . str_pad($index + 1, 12, '0', STR_PAD_LEFT),
                    'nik_karyawan' => 'K' . str_pad($index + 1, 7, '0', STR_PAD_LEFT),
                    'kta_number' => 'KTA-' . str_pad($index + 1, 8, '0', STR_PAD_LEFT),
                    'barcode_number' => 'BAR-' . str_pad($index + 1, 8, '0', STR_PAD_LEFT),
                    'email' => $u['username'] . '@example.com',
                    'phone' => '0812' . str_pad($index + 1, 8, '0', STR_PAD_LEFT),
                    'department' => 'Staff Operasional',
                    'birth_place' => fake()->randomElement(['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang', 'Makassar']),
                    'birth_date' => fake()->date('Y-m-d', '2000-01-01'),
                    'address' => fake()->address() . ', Kelurahan ' . fake()->streetName() . ', Kecamatan ' . fake()->city() . ', Provinsi ' . fake()->state() . ', Indonesia',
                    'gender' => ($index % 2 == 0) ? 'male' : 'female',
                    'religion' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                    'education' => fake()->randomElement(['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2']),
                    'role' => 'user',
                    'password' => Hash::make('password123'),
                    'pin' => Hash::make('123456'),
                ]
            );
        }

        // 3. Seed Settings (Pengaturan Default)
        $this->call(SettingSeeder::class);
    }
}
        