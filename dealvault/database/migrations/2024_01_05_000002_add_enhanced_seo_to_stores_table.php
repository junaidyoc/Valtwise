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
        Schema::table('stores', function (Blueprint $table) {
            // Open Graph fields
            $table->string('og_title', 90)->nullable()->after('focus_keyword');
            $table->string('og_description', 200)->nullable()->after('og_title');
            $table->string('og_image', 500)->nullable()->after('og_description');

            // Twitter fields
            $table->string('twitter_title', 90)->nullable()->after('og_image');
            $table->string('twitter_description', 200)->nullable()->after('twitter_title');
            $table->string('twitter_image', 500)->nullable()->after('twitter_description');

            // Technical SEO fields
            $table->string('canonical_url', 500)->nullable()->after('twitter_image');
            $table->enum('robots_index', ['index', 'noindex'])->default('index')->after('canonical_url');
            $table->enum('robots_follow', ['follow', 'nofollow'])->default('follow')->after('robots_index');
            $table->string('schema_type', 50)->default('Store')->after('robots_follow');

            // Sitemap & Breadcrumb
            $table->boolean('sitemap_include')->default(true)->after('schema_type');
            $table->boolean('breadcrumb_enable')->default(true)->after('sitemap_include');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'og_title',
                'og_description',
                'og_image',
                'twitter_title',
                'twitter_description',
                'twitter_image',
                'canonical_url',
                'robots_index',
                'robots_follow',
                'schema_type',
                'sitemap_include',
                'breadcrumb_enable',
            ]);
        });
    }
};
