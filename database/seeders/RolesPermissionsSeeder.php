<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage weddings',
            'manage users',
            'manage events',
            'manage services',
            'manage guests',
            'manage settings',
            'scan guests',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $superAdminRole = Role::findOrCreate('superadmin', 'web');
        $superAdminRole->syncPermissions($permissions);

        $adminRole = Role::findOrCreate('admin', 'web');
        $adminRole->syncPermissions(['manage users', 'manage events', 'manage services', 'manage guests']);

        $scannerRole = Role::findOrCreate('scanner', 'web');
        $scannerRole->syncPermissions(['scan guests']);

        $superadmin = User::query()->firstOrCreate(
            ['email' => 'superadmin@wedding.local'],
            [
                'name' => 'Wedding Super Admin',
                'phone_number' => '+243826869063',
                'password' => 'password',
                'is_active' => true,
            ]
        );

        $superadmin->assignRole('superadmin');
    }
}
