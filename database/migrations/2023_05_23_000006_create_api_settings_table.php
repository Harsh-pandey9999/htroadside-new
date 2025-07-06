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
        Schema::create('api_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider');
            $table->string('key');
            $table->text('value')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->boolean('is_encrypted')->default(false);
            $table->timestamps();

            $table->unique(['provider', 'key']);
        });

        // Insert default API settings
        DB::table('api_settings')->insert([
            // Razorpay Settings
            [
                'provider' => 'razorpay',
                'key' => 'key_id',
                'value' => null,
                'is_active' => true,
                'description' => 'Razorpay Key ID',
                'is_encrypted' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provider' => 'razorpay',
                'key' => 'key_secret',
                'value' => null,
                'is_active' => true,
                'description' => 'Razorpay Key Secret',
                'is_encrypted' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provider' => 'razorpay',
                'key' => 'webhook_secret',
                'value' => null,
                'is_active' => true,
                'description' => 'Razorpay Webhook Secret',
                'is_encrypted' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provider' => 'razorpay',
                'key' => 'environment',
                'value' => 'test',
                'is_active' => true,
                'description' => 'Razorpay Environment (test or live)',
                'is_encrypted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Fast2SMS Settings
            [
                'provider' => 'fast2sms',
                'key' => 'api_key',
                'value' => null,
                'is_active' => true,
                'description' => 'Fast2SMS API Key',
                'is_encrypted' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provider' => 'fast2sms',
                'key' => 'sender_id',
                'value' => 'HTRDSDE',
                'is_active' => true,
                'description' => 'Fast2SMS Sender ID',
                'is_encrypted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provider' => 'fast2sms',
                'key' => 'route',
                'value' => 'dlt',
                'is_active' => true,
                'description' => 'Fast2SMS Route (dlt or quick)',
                'is_encrypted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provider' => 'fast2sms',
                'key' => 'template_id',
                'value' => null,
                'is_active' => true,
                'description' => 'Fast2SMS DLT Template ID for OTP',
                'is_encrypted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_settings');
    }
};
