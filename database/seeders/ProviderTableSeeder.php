<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderTableSeeder extends Seeder
{
    public function run(): void
    {
        Provider::create([
            'provider_name' => 'Anonymous',
            'phone' => '0000000000',
            'address' => 'N/A',
            'description' => 'Nothing',
            'rc' => '1000000',
            'article' => '1000000',
            'nif' => '1000000',
            'nis' => '1000000',
        ]);
    }
}
