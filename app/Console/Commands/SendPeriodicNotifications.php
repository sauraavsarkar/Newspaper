<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Subscription;
use App\Notifications\SystemAlertNotification;
use App\Notifications\ReaderAlertNotification;
use Illuminate\Support\Facades\Notification;

class SendPeriodicNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-periodic-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily summaries, weekly digests, and subscription expiry alerts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting periodic notifications...');
        
        $this->sendDailySummary();
        $this->sendSubscriptionExpiryAlerts();
        
        // Only on Sundays for the weekly digest
        if (now()->isSunday()) {
            $this->sendWeeklyDigest();
        }

        $this->info('Done!');
    }

    protected function sendDailySummary()
    {
        $publishedCount = Article::whereDate('published_at', now()->today())->count();
        $newUserCount = User::whereDate('created_at', now()->today())->count();
        $viewCount = ArticleView::whereDate('viewed_at', now()->today())->count();

        $admins = User::role('Admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new SystemAlertNotification('daily_summary', [
                'articles_published' => $publishedCount,
                'new_users' => $newUserCount,
                'total_views' => $viewCount,
                'date' => now()->format('M d, Y')
            ]));
        }
    }

    protected function sendSubscriptionExpiryAlerts()
    {
        $expiringSoon = Subscription::where('status', 'active')
            ->whereDate('expires_at', now()->addDays(3)->toDateString())
            ->with('user')
            ->get();

        foreach ($expiringSoon as $sub) {
            if ($sub->user) {
                $sub->user->notify(new ReaderAlertNotification('subscription_expiring', [
                    'expiry_date' => $sub->expires_at->format('M d, Y'),
                ]));
            }
        }
    }

    protected function sendWeeklyDigest()
    {
        // Simple logic: send top articles to all readers
        // Article::trending() scope should exist in Article model
        $topArticles = Article::trending(7, 5)->get();
        
        if ($topArticles->isEmpty()) return;

        $readers = User::role('Reader')->get();
        foreach ($readers as $reader) {
            $reader->notify(new ReaderAlertNotification('weekly_digest', [
                'articles_count' => $topArticles->count(),
                'url' => route('home')
            ]));
        }
    }
}
