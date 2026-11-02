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
        Schema::create('actividad_inscripcion_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('actividad_inscripcion_id')->constrained('actividad_inscripciones')->cascadeOnDelete();
            $table->foreignId('actividad_opcion_id')->constrained('actividad_opciones')->cascadeOnDelete();
            $table->unsignedInteger('cantidad')->default(1);
            $table->decimal('precio_unitario', 8, 2)->default(0.00);
            $table->decimal('subtotal', 8, 2)->default(0.00);
            $table->timestamps();

            $table->index('actividad_inscripcion_id');
            $table->index('actividad_opcion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_inscripcion_items');
    }
};
