<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleView;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrendingAndTickerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_trending_six_hours_scope_filters_correctly(): void
    {
        $author = User::factory()->create();

        // Create 3 published articles
        $articleA = Article::factory()->create([
            'user_id' => $author->id,
            'title' => 'Article A',
            'status' => 'published',
            'published_at' => now()->subHours(2),
        ]);

        $articleB = Article::factory()->create([
            'user_id' => $author->id,
            'title' => 'Article B',
            'status' => 'published',
            'published_at' => now()->subHours(12),
        ]);

        $articleC = Article::factory()->create([
            'user_id' => $author->id,
            'title' => 'Article C',
            'status' => 'published',
            'published_at' => now()->subHours(3),
        ]);

        // Seed views for Article A: 5 views in the last hour
        for ($i = 0; $i < 5; $i++) {
            ArticleView::create([
                'article_id' => $articleA->id,
                'viewed_at' => now()->subMinutes(30),
                'ip_address' => '192.168.1.' . $i,
            ]);
        }

        // Seed views for Article B: 10 views 12 hours ago (outside 6 hours window)
        for ($i = 0; $i < 10; $i++) {
            ArticleView::create([
                'article_id' => $articleB->id,
                'viewed_at' => now()->subHours(12),
                'ip_address' => '192.168.2.' . $i,
            ]);
        }

        // Seed views for Article C: 2 views 2 hours ago (inside 6 hours window)
        for ($i = 0; $i < 2; $i++) {
            ArticleView::create([
                'article_id' => $articleC->id,
                'viewed_at' => now()->subHours(2),
                'ip_address' => '192.168.3.' . $i,
            ]);
        }

        // Get trending articles in last 6 hours
        $trending = Article::trendingSixHours(5)->get();

        // Assertions
        $this->assertCount(3, $trending);

        // Article A should be first (score = 5)
        $this->assertEquals($articleA->id, $trending[0]->id);
        $this->assertEquals(5, $trending[0]->trending_score);

        // Article C should be second (score = 2)
        $this->assertEquals($articleC->id, $trending[1]->id);
        $this->assertEquals(2, $trending[1]->trending_score);

        // Article B should be third (score = 0)
        $this->assertEquals($articleB->id, $trending[2]->id);
        $this->assertEquals(0, $trending[2]->trending_score);
    }

    public function test_breaking_news_ticker_shows_only_published_breaking_news(): void
    {
        $author = User::factory()->create();

        // Create a published breaking news article
        $breakingPublished = Article::factory()->create([
            'user_id' => $author->id,
            'title' => 'Breaking News 1',
            'status' => 'published',
            'is_breaking' => true,
            'published_at' => now(),
        ]);

        // Create a draft breaking news article
        $breakingDraft = Article::factory()->create([
            'user_id' => $author->id,
            'title' => 'Draft Breaking',
            'status' => 'draft',
            'is_breaking' => true,
        ]);

        // Create a non-breaking published article
        $regularPublished = Article::factory()->create([
            'user_id' => $author->id,
            'title' => 'Regular News',
            'status' => 'published',
            'is_breaking' => false,
            'published_at' => now(),
        ]);

        // Test Livewire Breaking News Ticker component
        \Livewire\Livewire::test(\App\Livewire\Shared\BreakingNewsTicker::class)
            ->assertSee($breakingPublished->title)
            ->assertDontSee($breakingDraft->title)
            ->assertDontSee($regularPublished->title);
    }
}
