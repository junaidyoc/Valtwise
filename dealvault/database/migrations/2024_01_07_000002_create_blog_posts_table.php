<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->string('featured_image')->nullable();

            // Relationships
            $table->foreignId('category_id')->nullable()->constrained('blog_categories')->nullOnDelete();

            // SEO Fields
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->string('focus_keyword', 50)->nullable();
            $table->string('og_title', 90)->nullable();
            $table->string('og_description', 200)->nullable();
            $table->string('og_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->enum('robots_index', ['index', 'noindex'])->default('index');
            $table->enum('robots_follow', ['follow', 'nofollow'])->default('follow');
            $table->boolean('sitemap_include')->default(true);

            // Publishing
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
