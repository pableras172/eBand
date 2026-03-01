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
        Schema::table('tipoactuacions', function (Blueprint $table) {
            $table->text('notif_es')->nullable();
            $table->text('notif_ca')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipoactuacions', function (Blueprint $table) {
            $table->dropColumn(['notif_es', 'notif_ca']);
        });
    }
};
