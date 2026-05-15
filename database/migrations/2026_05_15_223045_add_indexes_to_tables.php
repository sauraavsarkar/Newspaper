<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->index(['status', 'published_at']);
            $table->index('is_featured');
            $table->index('is_breaking');
        });

        Schema::table('article_views', function (Blueprint $table) {
            $table->index('viewed_at');
            $table->index('article_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['is_breaking']);
        });

        Schema::table('article_views', function (Blueprint $table) {
            $table->dropIndex(['viewed_at']);
            $table->dropIndex(['article_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['username']);
        });
    }
};
