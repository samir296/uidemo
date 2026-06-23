<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('provider_offerings', function (Blueprint $table) {
            $table->string('service_subtype')->nullable()->after('service_type');
            $table->string('pricing_model')->nullable()->after('service_mode');
            $table->decimal('price_amount', 10, 2)->nullable()->after('pricing_model');
            $table->unsignedTinyInteger('experience_years')->nullable()->after('price_amount');
            $table->json('service_attributes')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('provider_offerings', function (Blueprint $table) {
            $table->dropColumn([
                'service_subtype',
                'pricing_model',
                'price_amount',
                'experience_years',
                'service_attributes',
            ]);
        });
    }
};
