<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('provider_offering_id')->constrained('provider_offerings')->cascadeOnDelete();
            $table->string('service_type');
            $table->string('service_name');
            $table->string('address', 1000);
            $table->string('city')->nullable();
            $table->date('scheduled_date');
            $table->string('scheduled_time');
            $table->string('customer_phone', 20);
            $table->decimal('requested_price', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2)->nullable();
            $table->string('status', 30)->default('pending');
            $table->text('notes')->nullable();
            $table->text('provider_response_note')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_requests');
    }
};
