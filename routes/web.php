<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

use App\Livewire\Admin\Categories\CategoryManager;
use App\Livewire\Admin\Articles\ArticleManager;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('admin/categories', CategoryManager::class)->name('admin.categories');
    Route::get('admin/articles', ArticleManager::class)->name('admin.articles');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
