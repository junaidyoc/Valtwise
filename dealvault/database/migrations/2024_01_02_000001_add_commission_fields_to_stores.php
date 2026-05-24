<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Commission type: CPC (per click) or CPA (per action/sale)
            $table->enum('commission_type', ['cpc', 'cpa', 'both'])->default('cpa')->after('network');

            // Commission rate: CPC rate (e.g., $0.15) or CPA rate (e.g., 5%)
            $table->string('commission_rate')->nullable()->after('commission_type');

            // CPC rate specifically (in USD cents for precision)
            $table->decimal('cpc_rate', 8, 4)->nullable()->after('commission_rate');

            // CPA rate as percentage
            $table->decimal('cpa_rate', 5, 2)->nullable()->after('cpc_rate');
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['commission_type', 'commission_rate', 'cpc_rate', 'cpa_rate']);
        });
    }
};
