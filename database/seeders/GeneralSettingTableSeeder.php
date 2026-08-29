<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GeneralSettingTableSeeder extends Seeder
{
    public function run(): void
    {
        GeneralSetting::create([
            'store_name' => 'MagaPOS',
            'activity' => 'Point of Sale',
            'phone' => '0000000000',
            'address' => 'N/A',
            'start_day' => Carbon::parse('2019-06-17'),
            'image' => 'logo_default.png',
            'investment_capital' => '1000000',
            'rc' => '1000000',
            'article' => '1000000',
            'nif' => '1000000',
            'nis' => '1000000',
        ]);
    }
}
