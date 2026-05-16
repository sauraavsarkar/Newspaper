<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleVersion;
use Illuminate\Support\Facades\Auth;

class VersionService
{
    /**
     * Create a new snapshot of the article.
     * 
     * @param Article $article
     * @param string $triggerType auto, manual, submitted, approved, rejected, published
     * @param int|null $userId
     * @return ArticleVersion
     */
    public function snapshot(Article $article, string $triggerType, ?int $userId = null): ArticleVersion
    {
        $userId = $userId ?? Auth::id();
        
        $lastVersion = $article->versions()->orderBy('version_number', 'desc')->first();
        $nextVersionNumber = $lastVersion ? $lastVersion->version_number + 1 : 1;

        return $article->versions()->create([
            'version_number' => $nextVersionNumber,
            'title' => $article->title,
            'excerpt' => $article->excerpt,
            'content' => $article->content,
            'featured_image' => $article->featured_image,
            'seo_metadata' => $article->seo_metadata,
            'user_id' => $userId,
            'trigger_type' => $triggerType,
        ]);
    }

    /**
     * Restore a previous version.
     * This creates a new snapshot of the current state before replacing,
     * so no history is lost.
     * 
     * @param Article $article
     * @param ArticleVersion $version
     * @param int|null $userId
     * @return Article
     */
    public function restore(Article $article, ArticleVersion $version, ?int $userId = null): Article
    {
        $userId = $userId ?? Auth::id();

        // First, snapshot the current state just in case, marking it as a pre-restore auto-save
        $this->snapshot($article, 'auto', $userId);

        // Now replace article content with the selected version
        $article->update([
            'title' => $version->title,
            'excerpt' => $version->excerpt,
            'content' => $version->content,
            'featured_image' => $version->featured_image,
            'seo_metadata' => $version->seo_metadata,
        ]);

        // Create a new explicit snapshot of the restored version
        $this->snapshot($article, 'manual', $userId);

        if ($article->user_id && $userId !== $article->user_id) {
            $restorer = \App\Models\User::find($userId);
            if ($restorer) {
                $article->author->notify(new \App\Notifications\VersionRestoredNotification($article, $version, $restorer));
            }
        }

        return $article;
    }

    /**
     * Get two versions for comparison.
     * 
     * @param Article $article
     * @param int $oldVersionId
     * @param int $newVersionId
     * @return array
     */
    public function compare(Article $article, int $oldVersionId, int $newVersionId): array
    {
        $oldVersion = $article->versions()->findOrFail($oldVersionId);
        $newVersion = $article->versions()->findOrFail($newVersionId);

        return [
            'old' => $oldVersion,
            'new' => $newVersion,
        ];
    }

    /**
     * Save a temporary draft (auto-save).
     * 
     * @param Article $article
     * @param array $data
     * @param int|null $userId
     * @return \App\Models\ArticleDraft
     */
    public function saveDraft(Article $article, array $data, ?int $userId = null)
    {
        $userId = $userId ?? Auth::id();

        return $article->drafts()->updateOrCreate(
            ['user_id' => $userId],
            [
                'title' => $data['title'] ?? $article->title,
                'excerpt' => $data['excerpt'] ?? $article->excerpt,
                'content' => $data['content'] ?? $article->content,
                'featured_image' => $data['featured_image'] ?? $article->featured_image,
                'seo_metadata' => $data['seo_metadata'] ?? $article->seo_metadata,
            ]
        );
    }

    /**
     * Get the draft for a specific user and article.
     */
    public function getDraft(Article $article, ?int $userId = null)
    {
        $userId = $userId ?? Auth::id();
        return $article->drafts()->where('user_id', $userId)->first();
    }
}
