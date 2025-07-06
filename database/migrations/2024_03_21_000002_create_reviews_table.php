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
        // Check if service_requests table exists before creating reviews table
        if (Schema::hasTable('service_requests')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('service_provider_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('service_request_id')->constrained()->onDelete('cascade');
                $table->integer('rating')->comment('Rating from 1 to 5');
                $table->text('comment')->nullable();
                $table->json('images')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->timestamps();
                $table->softDeletes();

                // Ensure one review per service request
                $table->unique('service_request_id');
            });
        } else {
            // Create reviews table without foreign key constraint
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('service_provider_id')->constrained('users')->onDelete('cascade');
                $table->unsignedBigInteger('service_request_id');
                $table->integer('rating')->comment('Rating from 1 to 5');
                $table->text('comment')->nullable();
                $table->json('images')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->timestamps();
                $table->softDeletes();

                // Ensure one review per service request
                $table->unique('service_request_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};