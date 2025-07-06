<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Profile fields
            $table->string('profile_photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Service provider specific fields
            $table->boolean('is_service_provider')->default(false);
            $table->string('service_provider_type')->nullable(); // individual, company
            $table->string('company_name')->nullable();
            $table->string('service_area')->nullable();
            $table->json('service_types')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_ratings')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            
            // Account settings
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(true);
            $table->boolean('push_notifications')->default(true);
            $table->string('preferred_language')->default('en');
            $table->string('timezone')->default('UTC');
            
            // Payment related
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_account_id')->nullable();
            $table->boolean('payment_verified')->default(false);
            
            // Last activity tracking
            $table->timestamp('last_active_at')->nullable();
            $table->string('last_active_ip')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo',
                'bio',
                'address',
                'city',
                'state',
                'country',
                'postal_code',
                'latitude',
                'longitude',
                'is_service_provider',
                'service_provider_type',
                'company_name',
                'service_area',
                'service_types',
                'rating',
                'total_ratings',
                'is_verified',
                'verified_at',
                'email_notifications',
                'sms_notifications',
                'push_notifications',
                'preferred_language',
                'timezone',
                'stripe_customer_id',
                'stripe_account_id',
                'payment_verified',
                'last_active_at',
                'last_active_ip'
            ]);
        });
    }
}; 