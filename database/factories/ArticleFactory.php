<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(8);
        return [
            'user_id' => User::factory(),
            'category_id' => Category::all()->random()->id ?? Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(10, true),
            'excerpt' => $this->faker->paragraph(3),
            'featured_image' => 'https://picsum.photos/1200/800?random=' . $this->faker->unique()->numberBetween(1, 1000),
            'status' => $this->faker->randomElement(['draft', 'published', 'scheduled', 'archived']),
            'is_featured' => $this->faker->boolean(10),
            'is_breaking' => $this->faker->boolean(5),
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the article is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the article is breaking news.
     */
    public function breaking(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_breaking' => true,
            'status' => 'published',
        ]);
    }
}
