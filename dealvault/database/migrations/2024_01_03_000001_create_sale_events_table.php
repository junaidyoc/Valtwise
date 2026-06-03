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
        Schema::create('sale_events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('emoji', 10)->nullable();
            $table->string('subtitle_tags')->nullable();
            $table->date('event_date');
            $table->date('end_date')->nullable();
            $table->enum('region', ['uk', 'pk', 'global'])->default('global');
            $table->longText('description')->nullable();
            $table->string('categories')->nullable();
            $table->json('checklist')->nullable();
            $table->json('event_table')->nullable();
            $table->enum('density', ['low', 'medium', 'high', 'peak'])->default('medium');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('event_date');
            $table->index('end_date');
            $table->index('region');
            $table->index('is_active');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_events');
    }
};
