<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        \App\Models\Article::observe(\App\Observers\ArticleObserver::class);

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\ArticlePublished::class,
            \App\Listeners\SendArticleNotification::class
        );

        \Illuminate\Support\Facades\Event::subscribe(\App\Listeners\ActivityLogSubscriber::class);

        // Implicitly grant "Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user()->can() and @can()
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });
    }
}
