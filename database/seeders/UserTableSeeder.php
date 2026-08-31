<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'admin@magapos.app',
            'password' => bcrypt('password'),
            'image' => 'admin.png',
        ]);
        $user->addRole('super_admin');
    }
}
