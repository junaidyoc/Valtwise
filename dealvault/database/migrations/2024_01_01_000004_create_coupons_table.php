<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('title');                         // "20% Off Sitewide"
            $table->text('description')->nullable();
            $table->string('code')->nullable();              // null = no code needed (deal)
            $table->enum('type', ['code', 'deal', 'sale'])->default('code');
            $table->string('discount_value')->nullable();    // "20%", "$10", "BOGO"
            $table->string('destination_url')->nullable();   // product/landing page URL
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_exclusive')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('click_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['store_id', 'is_active']);
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
