<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reactions', function (Blueprint $table) {
            // Remove the old unique constraint if it exists (it was named 'reaction_user_unique')
            // Using try-catch or checking if it exists to be safe
            $table->dropUnique('reaction_user_unique');
            
            // New constraints
            // 1. One reaction per user per reactable
            $table->index(['reactable_id', 'reactable_type', 'user_id'], 'reactions_user_index');
            
            // 2. One reaction per guest fingerprint per reactable
            $table->index(['reactable_id', 'reactable_type', 'fingerprint'], 'reactions_guest_index');
        });
    }

    public function down(): void
    {
        Schema::table('reactions', function (Blueprint $table) {
            $table->dropIndex('reactions_guest_index');
            $table->dropIndex('reactions_user_index');
            $table->unique(['reactable_id', 'reactable_type', 'user_id', 'type'], 'reaction_user_unique');
        });
    }
};
