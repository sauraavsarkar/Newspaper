<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PublishScheduledArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish articles that are scheduled to be published now or in the past.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Starting article:publish-scheduled command.');
        $this->info('Starting article:publish-scheduled command...');

        try {
            /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Article> $articles */
            $articles = \App\Models\Article::where('status', 'scheduled')
                ->where('published_at', '<=', now())
                ->get();

            Log::info("Found {$articles->count()} articles to publish.");
            $this->info("Found {$articles->count()} articles to publish.");

            foreach ($articles as $article) {
                Log::info("Processing article ID: {$article->id} ('{$article->title}')");
                
                $article->update(['status' => 'published']);
                
                Log::info("Status updated to 'published' for article ID: {$article->id}");
                $this->info("Published article: {$article->title}");
            }

            if ($articles->isEmpty()) {
                Log::info('No scheduled articles found to publish.');
                $this->info('No scheduled articles to publish.');
            }

            Log::info('Completed article:publish-scheduled command.');
            $this->info('Command execution finished successfully.');

        } catch (\Exception $e) {
            Log::error('Error occurred during article:publish-scheduled command: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}

