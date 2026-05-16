<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Editor', 'Journalist', 'Moderator']);
    }

    public function view(User $user, Article $article): bool
    {
        if ($user->hasAnyRole(['Admin', 'Editor'])) return true;
        if ($user->id === $article->user_id) return true;
        return $article->status === 'published';
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create article');
    }

    public function update(User $user, Article $article): bool
    {
        if ($user->hasRole(['Admin', 'Editor'])) return true;
        
        // Journalists can only edit their own drafts/submitted articles before they are in review or published
        return $user->id === $article->user_id 
            && in_array($article->status, ['draft', 'submitted', 'rejected']);
    }

    public function delete(User $user, Article $article): bool
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Editor')) return $user->id === $article->user_id;
        
        return $user->id === $article->user_id && $article->status === 'draft';
    }

    public function publish(User $user, Article $article): bool
    {
        return $user->hasPermissionTo('publish article');
    }

    public function approve(User $user, Article $article): bool
    {
        return $user->hasPermissionTo('approve article');
    }

    public function reject(User $user, Article $article): bool
    {
        return $user->hasPermissionTo('reject article');
    }

    public function restore(User $user, Article $article): bool
    {
        return $user->hasRole('Admin');
    }

    public function forceDelete(User $user, Article $article): bool
    {
        return $user->hasRole('Admin');
    }
}
