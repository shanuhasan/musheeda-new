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
        Schema::table('products', function (Blueprint $table) {
            $table->text('short_description')->nullable()->after('slug');
            $table->json('images')->nullable()->after('description');
            $table->json('features')->nullable()->after('images');
            $table->json('benefits')->nullable()->after('features');
            $table->string('pricing_type')->nullable()->after('price'); // fixed, subscription, custom
            $table->string('demo_url')->nullable()->after('pricing_type');
            $table->string('documentation_url')->nullable()->after('demo_url');
            $table->json('cta')->nullable()->after('documentation_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'short_description',
                'images',
                'features',
                'benefits',
                'pricing_type',
                'demo_url',
                'documentation_url',
                'cta'
            ]);
        });
    }
};
