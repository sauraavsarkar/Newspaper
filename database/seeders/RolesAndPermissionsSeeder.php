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

        // Create granular permissions
        $permissions = [
            'create article', 'edit own article', 'edit any article',
            'delete article', 'publish article', 'approve article',
            'reject article', 'toggle breaking news', 'manage categories',
            'upload media', 'manage users', 'assign roles',
            'view analytics', 'moderate comments', 'manage homepage',
            'manage ads', 'manage subscriptions', 'view logs', 'send alerts',
        ];

        foreach ($permissions as $perm) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Cleanup: Remove any permissions not in our master list
        \Spatie\Permission\Models\Permission::whereNotIn('name', $permissions)->delete();

        // Create roles and assign permissions
        $admin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $editor = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Editor']);
        $editor->syncPermissions([
            'create article', 'edit any article', 'publish article',
            'approve article', 'reject article', 'toggle breaking news',
            'manage categories', 'upload media', 'view analytics',
            'moderate comments',
        ]);

        $journalist = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Journalist']);
        $journalist->syncPermissions([
            'create article', 'edit own article', 'upload media', 'view analytics',
        ]);

        $moderator = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Moderator']);
        $moderator->syncPermissions([
            'moderate comments',
        ]);

        $reader = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Reader']);
        // Readers don't have backend permissions usually, but they can post comments (handled by guard or specific check)
    }
}
