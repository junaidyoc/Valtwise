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
        Schema::table('sale_events', function (Blueprint $table) {
            // Basic SEO
            $table->string('meta_title', 70)->nullable()->after('description');
            $table->string('meta_description', 160)->nullable()->after('meta_title');
            $table->string('focus_keyword', 50)->nullable()->after('meta_description');

            // Open Graph
            $table->string('og_title', 90)->nullable()->after('focus_keyword');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');

            // Technical SEO
            $table->string('canonical_url')->nullable()->after('og_image');
            $table->string('robots_index', 10)->default('index')->after('canonical_url');
            $table->string('robots_follow', 10)->default('follow')->after('robots_index');
            $table->boolean('sitemap_include')->default(true)->after('robots_follow');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_events', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title', 'meta_description', 'focus_keyword',
                'og_title', 'og_description', 'og_image',
                'canonical_url', 'robots_index', 'robots_follow', 'sitemap_include',
            ]);
        });
    }
};
