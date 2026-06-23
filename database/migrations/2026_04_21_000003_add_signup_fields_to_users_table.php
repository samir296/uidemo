<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password');
            $table->string('phone', 20)->nullable()->after('role');
            $table->text('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('aadhaar_number', 12)->nullable()->unique()->after('city');
            $table->string('help_type')->nullable()->after('aadhaar_number');
            $table->text('notes')->nullable()->after('help_type');
            $table->text('mobile_token')->nullable()->after('notes');
            $table->timestamp('mobile_token_updated_at')->nullable()->after('mobile_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone',
                'address',
                'city',
                'aadhaar_number',
                'help_type',
                'notes',
                'mobile_token',
                'mobile_token_updated_at',
            ]);
        });
    }
};
