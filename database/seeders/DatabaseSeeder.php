<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles and Permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // 2. Admin User
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@newspaper.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');

        // 3. Journalists
        $journalists = User::factory(5)->create();
        foreach ($journalists as $journalist) {
            $journalist->assignRole('Journalist');
        }

        // 4. Editors
        $editors = User::factory(2)->create();
        foreach ($editors as $editor) {
            $editor->assignRole('Editor');
        }

        // 5. Categories and Tags
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
        ]);

        // 6. Articles and Views
        $this->call(ArticleSeeder::class);
    }
}
