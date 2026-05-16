<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class JournalistUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $journalist = User::firstOrCreate(
            ['email' => 'journalist@newsflow.com'],
            [
                'name' => 'John Journalist',
                'username' => 'johnj',
                'password' => Hash::make('1'),
            ]
        );

        $journalist->assignRole('Journalist');
    }
}
