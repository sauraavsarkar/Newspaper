<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
        \Spatie\Permission\Models\Role::create(['name' => 'Editor']);
        \Spatie\Permission\Models\Role::create(['name' => 'Journalist']);
        \Spatie\Permission\Models\Role::create(['name' => 'Moderator']);
        \Spatie\Permission\Models\Role::create(['name' => 'Reader']);
    }
}
