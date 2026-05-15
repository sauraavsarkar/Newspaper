<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;

$article = Article::first();
if ($article) {
    $article->update([
        'is_featured' => true,
        'is_breaking' => true,
        'status' => 'published',
        'published_at' => now(),
    ]);
    echo "Article {$article->id} updated successfully.\n";
} else {
    echo "No articles found.\n";
}
