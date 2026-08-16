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
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('status');
            $table->integer('reading_time_minutes')->default(1)->after('is_featured');
            $table->string('meta_title')->nullable()->after('reading_time_minutes');
            $table->text('meta_description')->nullable()->after('meta_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'reading_time_minutes', 'meta_title', 'meta_description']);
        });
    }
};
