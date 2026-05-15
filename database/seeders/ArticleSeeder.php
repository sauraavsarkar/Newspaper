<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        if ($tags->isEmpty()) {
            $this->call(TagSeeder::class);
            $tags = Tag::all();
        }

        // Create 50 articles
        Article::factory(50)->create([
            'user_id' => fn() => $users->random()->id,
            'category_id' => fn() => $categories->random()->id,
        ])->each(function ($article) use ($tags) {
            // Attach random tags
            $article->tags()->attach(
                $tags->random(rand(2, 4))->pluck('id')->toArray()
            );

            // Create some views for each article
            if ($article->status === 'published') {
                ArticleView::factory(rand(10, 100))->create([
                    'article_id' => $article->id,
                    'viewed_at' => $this->faker()->dateTimeBetween($article->published_at, 'now'),
                ]);
            }
        });

        // Ensure we have some featured and breaking news
        Article::where('status', 'published')->limit(5)->update(['is_featured' => true]);
        Article::where('status', 'published')->where('is_featured', false)->limit(3)->update(['is_breaking' => true]);
    }

    private function faker()
    {
        return \Faker\Factory::create();
    }
}
