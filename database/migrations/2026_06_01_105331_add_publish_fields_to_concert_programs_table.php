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
        Schema::table('concert_programs', function (Blueprint $table) {
            $table->boolean('is_published')->default(false)->after('participants');
            $table->boolean('is_featured')->default(false)->after('is_published');

            $table->index(['is_published', 'event_date']);
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concert_programs', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'event_date']);
            $table->dropIndex(['is_featured']);
            $table->dropColumn(['is_published', 'is_featured']);
        });
    }
};
