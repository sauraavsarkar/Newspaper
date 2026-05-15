<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Breaking News', 'slug' => 'breaking-news'],
            ['name' => 'World News', 'slug' => 'world-news'],
            ['name' => 'Local News', 'slug' => 'local-news'],
            ['name' => 'Opinion', 'slug' => 'opinion'],
            ['name' => 'Feature', 'slug' => 'feature'],
            ['name' => 'Investigation', 'slug' => 'investigation'],
            ['name' => 'Trending', 'slug' => 'trending'],
        ];

        foreach ($tags as $tag) {
            \App\Models\Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }
    }
}
