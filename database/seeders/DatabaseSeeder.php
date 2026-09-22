<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Seed Settings (Pengaturan Default)
        $this->call(SettingSeeder::class);

        // 2. Seed Full Dummy Data (Admin, Abghi Fareihan, Karyawan, Informasi, Organisasi, Sosial, Finansial, Pembelajaran, Serikat, Visi, Voting, Broadcast, Tiket, Registrasi)
        $this->call(DummyDataSeeder::class);
    }
}