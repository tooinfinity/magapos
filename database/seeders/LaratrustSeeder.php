<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class LaratrustSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Truncating User, Role and Permission tables');
        $this->truncateLaratrustTables();

        $config = config('laratrust_seeder.roles_structure');
        $userPermission = config('laratrust_seeder.permission_structure');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $key => $modules) {
            $role = Role::create([
                'name' => $key,
                'display_name' => ucwords(str_replace('_', ' ', $key)),
                'description' => ucwords(str_replace('_', ' ', $key)),
            ]);

            $this->command->info('Creating Role ' . strtoupper($key));
            $permissions = [];

            foreach ($modules as $module => $value) {
                foreach (explode(',', $value) as $perm) {
                    $permissionValue = $mapPermission->get($perm);

                    $permissions[] = Permission::firstOrCreate([
                        'name' => $permissionValue . '_' . $module,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                    ])->id;

                    $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
                }
            }

            $role->syncPermissions($permissions);
            $this->command->info("Creating '{$key}' role");
        }

        if (! empty($userPermission)) {
            foreach ($userPermission as $key => $modules) {
                foreach ($modules as $module => $value) {
                    $user = User::firstOrCreate(
                        ['email' => $key . '@app.com'],
                        [
                            'first_name' => ucwords(str_replace('_', ' ', $key)),
                            'last_name' => 'User',
                            'password' => bcrypt('password'),
                            'remember_token' => Str::random(10),
                        ]
                    );

                    $permissions = [];
                    foreach (explode(',', $value) as $perm) {
                        $permissionValue = $mapPermission->get($perm);

                        $permissions[] = Permission::firstOrCreate([
                            'name' => $permissionValue . '-' . $module,
                            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                            'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        ])->id;

                        $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
                    }

                    $user->syncPermissions($permissions);
                }
            }
        }
    }

    public function truncateLaratrustTables(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
        User::truncate();
        Role::truncate();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
