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
        Schema::table('seo_metadata', function (Blueprint $table) {
            $table->string('twitter_title')->nullable()->after('og_image');
            $table->text('twitter_description')->nullable()->after('twitter_title');
            $table->string('twitter_image')->nullable()->after('twitter_description');
            $table->string('schema_type')->nullable()->after('twitter_image');
            $table->json('custom_schema')->nullable()->after('schema_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_metadata', function (Blueprint $table) {
            $table->dropColumn([
                'twitter_title',
                'twitter_description',
                'twitter_image',
                'schema_type',
                'custom_schema'
            ]);
        });
    }
};
