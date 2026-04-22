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
        Schema::table('inventory_categories', function (Blueprint $table) {
            $table->string('nombre')->unique()->after('id');
            $table->text('descripcion')->nullable()->after('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_categories', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'descripcion']);
        });
    }
};
