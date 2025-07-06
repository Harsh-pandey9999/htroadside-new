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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('job_id')->constrained();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('experience')->nullable();
            $table->text('cover_letter')->nullable();
            $table->string('resume')->nullable(); // file path
            $table->string('status')->default('pending'); // pending, reviewed, shortlisted, rejected, hired
            $table->text('admin_notes')->nullable();
            $table->timestamp('interview_date')->nullable();
            $table->string('interview_location')->nullable();
            $table->text('interview_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
