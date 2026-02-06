<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '08123456789',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // 10 user biasa
        $users = [
            [
                'name' => 'Abghi Fareihan',
                'username' => 'abghifareihand',
                'email' => 'abghidesailie@gmail.com',
                'phone' => '087777711022',
                'pin' => '123456',
            ],
            [
                'name' => 'Agus Santoso',
                'username' => 'agus',
                'email' => 'agus@gmail.com',
                'phone' => '08111111111',
                'pin' => '111111',
            ],
            [
                'name' => 'Jatmiko Prasetyo',
                'username' => 'jatmiko',
                'email' => 'jatmiko@gmail.com',
                'phone' => '08222222222',
                'pin' => '222222',
            ],
            [
                'name' => 'Sukocai Rahman',
                'username' => 'sukocai',
                'email' => 'sukocai@gmail.com',
                'phone' => '08333333333',
                'pin' => '333333',
            ],
            [
                'name' => 'Dewi Lestari',
                'username' => 'dewi',
                'email' => 'dewi@gmail.com',
                'phone' => '08444444444',
                'pin' => '444444',
            ],
            [
                'name' => 'Rizky Maulana',
                'username' => 'rizky',
                'email' => 'rizky@gmail.com',
                'phone' => '08555555555',
                'pin' => '555555',
            ],
            [
                'name' => 'Fajar Nugroho',
                'username' => 'fajar',
                'email' => 'fajar@gmail.com',
                'phone' => '08666666666',
                'pin' => '666666',
            ],
            [
                'name' => 'Indah Permata',
                'username' => 'indah',
                'email' => 'indah@gmail.com',
                'phone' => '08777777777',
                'pin' => '777777',
            ],
            [
                'name' => 'Budi Santoso',
                'username' => 'budi',
                'email' => 'budi@gmail.com',
                'phone' => '08888888888',
                'pin' => '888888',
            ],
            [
                'name' => 'Siti Aminah',
                'username' => 'siti',
                'email' => 'siti@gmail.com',
                'phone' => '08999999999',
                'pin' => '999999',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'username' => 'ahmad',
                'email' => 'ahmad@gmail.com',
                'phone' => '08100000000',
                'pin' => '000000',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'role' => 'user',
                'pin' => $user['pin'],
                'password' => Hash::make('password123'), // default password untuk semua user
            ]);
        }
    }
}
