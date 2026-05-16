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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('password');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('location')->nullable()->after('bio');
            $table->string('website')->nullable()->after('location');
            $table->string('twitter_url')->nullable()->after('website');
            $table->string('linkedin_url')->nullable()->after('twitter_url');
            $table->string('phone')->nullable()->after('linkedin_url');

            // Journalist only
            $table->string('beat')->nullable()->after('phone');
            $table->string('byline')->nullable()->after('beat');

            // Preferences (JSON)
            $table->json('preferences')->nullable()->after('byline');

            // Security
            $table->timestamp('last_login_at')->nullable()->after('preferences');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->boolean('two_factor_enabled')->default(false)->after('last_login_ip');

            // Status
            $table->enum('status', ['active', 'suspended', 'banned'])->default('active')->after('two_factor_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar', 'bio', 'location', 'website', 'twitter_url', 
                'linkedin_url', 'phone', 'beat', 'byline', 'preferences', 
                'last_login_at', 'last_login_ip', 'two_factor_enabled', 'status'
            ]);
        });
    }
};
