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
                'label' => 'Nominal Iuran Bulanan',
                'value' => 'Rp 5.000,00',
            ],
            [
                'key'   => 'iuran_bulanan_terbilang',
                'label' => 'Terbilang Iuran Bulanan',
                'value' => 'Lima Ribu Rupiah',
            ],
            [
                'key'   => 'email_organisasi',
                'label' => 'Email SP PION',
                'value' => 'sppion18@gmail.com',
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
