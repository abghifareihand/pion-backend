<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key'   => 'iuran_bulanan_nominal',
                'label' => 'Nominal Iuran Bulanan (Angka)',
                'value' => 'Rp 5.000,00',
            ],
            [
                'key'   => 'iuran_bulanan_terbilang',
                'label' => 'Iuran Bulanan Terbilang',
                'value' => 'Lima Ribu Rupiah',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
