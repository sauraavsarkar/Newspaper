<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ArticleViewSeeder extends Seeder
{
    /**
     * Seed demo article views for analytics testing.
     */
    public function run(): void
    {
        $articles = Article::where('status', 'published')->get();

        if ($articles->isEmpty()) {
            $this->command->warn('No published articles found. Skipping view seeder.');
            return;
        }

        $ips = [
            '192.168.1.10', '192.168.1.20', '10.0.0.5', '10.0.0.15',
            '172.16.0.1', '172.16.0.2', '203.0.113.1', '203.0.113.50',
            '198.51.100.1', '198.51.100.25', '192.0.2.1', '192.0.2.100',
            '100.0.0.1', '100.0.0.2', '100.0.0.3', '100.0.0.4',
        ];

        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/125.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/605.1',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0) Mobile/15E148',
            'Mozilla/5.0 (Linux; Android 14) Chrome/125.0 Mobile',
            'Mozilla/5.0 (iPad; CPU OS 17_0) AppleWebKit/605.1',
        ];

        $referers = [
            'https://www.google.com', 'https://twitter.com', 'https://facebook.com',
            'https://news.ycombinator.com', null, null, null,
        ];

        $totalViews = 0;

        foreach ($articles as $article) {
            // Give each article a random number of views (more for featured)
            $viewCount = $article->is_featured
                ? rand(40, 120)
                : rand(5, 60);

            for ($i = 0; $i < $viewCount; $i++) {
                // Spread views across the last 30 days, with more recent being heavier
                $daysAgo = $this->weightedRandom(30);
                $hoursAgo = rand(0, 23);
                $minutesAgo = rand(0, 59);

                $viewedAt = Carbon::now()
                    ->subDays($daysAgo)
                    ->subHours($hoursAgo)
                    ->subMinutes($minutesAgo);

                ArticleView::create([
                    'article_id' => $article->id,
                    'user_id' => rand(0, 3) === 0 ? null : rand(1, max(1, \App\Models\User::count())),
                    'ip_address' => $ips[array_rand($ips)],
                    'user_agent' => $agents[array_rand($agents)],
                    'referer' => $referers[array_rand($referers)],
                    'viewed_at' => $viewedAt,
                ]);

                $totalViews++;
            }
        }

        $this->command->info("Seeded {$totalViews} article views across {$articles->count()} articles.");
    }

    /**
     * Generate a weighted random number (bias toward lower values = more recent).
     */
    private function weightedRandom(int $max): int
    {
        // Square root distribution — biases toward recent days
        $rand = mt_rand(0, 10000) / 10000;
        return (int) floor(pow($rand, 1.5) * $max);
    }
}
