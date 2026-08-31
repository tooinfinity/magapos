<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LaratrustSeeder::class,
            UserTableSeeder::class,
            ClientTableSeeder::class,
            ProviderTableSeeder::class,
            GeneralSettingTableSeeder::class,
        ]);
    }
}
