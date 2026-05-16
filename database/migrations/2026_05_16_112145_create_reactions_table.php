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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('reactable');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('fingerprint')->nullable();
            $table->string('type');
            $table->timestamps();
            
            // Note: Since user_id or fingerprint can be null, a composite unique constraint
            // might have issues with nulls depending on the database. 
            // We'll enforce the uniqueness logic in the application layer or use partial indexes if supported.
            // For now, let's keep it simple and rely on application logic for guest uniqueness 
            // to avoid multiple nulls causing issues in standard unique constraints.
            $table->unique(['reactable_id', 'reactable_type', 'user_id', 'type'], 'reaction_user_unique')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
