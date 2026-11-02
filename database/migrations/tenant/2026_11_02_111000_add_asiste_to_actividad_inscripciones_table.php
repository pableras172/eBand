<?php

declare(strict_types=1);

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
        Schema::table('actividad_inscripciones', function (Blueprint $table): void {
            $table->boolean('asiste')->default(true)->after('nombre_manual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actividad_inscripciones', function (Blueprint $table): void {
            $table->dropColumn('asiste');
        });
    }
};
