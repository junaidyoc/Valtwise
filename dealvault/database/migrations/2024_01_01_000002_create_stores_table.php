<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();          // path or URL
            $table->string('website_url');
            $table->text('description')->nullable();
            $table->decimal('cashback_rate', 5, 2)->default(0); // e.g. 3.50 = 3.5%
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('affiliate_url_template')->nullable(); // {destination} placeholder
            $table->string('network')->nullable();       // commission_factory, cj, rakuten
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
