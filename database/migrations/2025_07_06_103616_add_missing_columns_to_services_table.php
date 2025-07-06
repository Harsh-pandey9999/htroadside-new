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
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('image');
            $table->string('estimated_time')->nullable()->after('price');
            $table->string('category')->nullable()->after('estimated_time');
            $table->json('tags')->nullable()->after('category');
            $table->boolean('featured')->default(false)->after('tags');
            $table->string('service_area')->nullable()->after('featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'price',
                'estimated_time',
                'category',
                'tags',
                'featured',
                'service_area'
            ]);
        });
    }
};
