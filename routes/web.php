<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Admin\Categories\CategoryManager;
use App\Livewire\Admin\Articles\ArticleManager;
use App\Livewire\Admin\Analytics\AnalyticsDashboard;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\ArticleShow;

Route::get('/', Home::class)->name('home');
Route::get('/article/{slug}', ArticleShow::class)->name('article.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('admin/categories', CategoryManager::class)->name('admin.categories');
    Route::get('admin/articles', ArticleManager::class)->name('admin.articles');
    Route::get('admin/analytics', AnalyticsDashboard::class)->name('admin.analytics');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
