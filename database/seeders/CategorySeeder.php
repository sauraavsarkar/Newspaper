<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Politics', 'slug' => 'politics'],
            ['name' => 'Technology', 'slug' => 'technology'],
            ['name' => 'Sports', 'slug' => 'sports'],
            ['name' => 'Business', 'slug' => 'business'],
            ['name' => 'Entertainment', 'slug' => 'entertainment'],
            ['name' => 'Health', 'slug' => 'health'],
            ['name' => 'Science', 'slug' => 'science'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
