<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Admin\Categories\CategoryManager;
use App\Livewire\Admin\Articles\ArticleManager;
use App\Livewire\Admin\Analytics\AnalyticsDashboard;
use App\Livewire\Admin\Roles\RoleManager;
use App\Livewire\Admin\Users\UserManager;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\ArticleShow;

Route::get('/', Home::class)->name('home');
Route::get('/article/{slug}', ArticleShow::class)->name('article.show');

Route::get('dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('Reader')) {
        return redirect()->route('reader.dashboard');
    }
    // For Admin, Editor, Journalist, Moderator
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('reader/dashboard', \App\Livewire\Reader\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('reader.dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('admin/categories', CategoryManager::class)->name('admin.categories');
    Route::get('admin/articles', ArticleManager::class)->name('admin.articles');
    Route::get('admin/analytics', AnalyticsDashboard::class)->name('admin.analytics');
    Route::get('admin/roles', RoleManager::class)->name('admin.roles');
    Route::get('admin/users', UserManager::class)->name('admin.users');
    Route::get('admin/users/{user}/edit', \App\Livewire\Profile\ProfileEditor::class)->name('admin.users.edit');
    Route::get('admin/activity', \App\Livewire\Admin\ActivityFeed::class)->name('admin.activity');
});

Route::middleware(['auth'])->group(function () {
    Route::get('account/activity', \App\Livewire\Reader\AccountActivity::class)->name('reader.activity');
    Route::get('profile', \App\Livewire\Profile\ProfileEditor::class)->name('profile');
    Route::get('profile/edit', \App\Livewire\Profile\ProfileEditor::class)->name('profile.edit');
});

require __DIR__.'/auth.php';
