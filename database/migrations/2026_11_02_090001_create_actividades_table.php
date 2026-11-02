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
        Schema::create('actividades', function (Blueprint $table): void {
            $table->id();
            $table->string('titulo');
            $table->string('tipo')->default('comida'); // comida, cena, excursion, otro
            $table->text('descripcion')->nullable();
            $table->string('lugar')->nullable();
            $table->dateTime('fecha');
            $table->dateTime('fecha_limite_inscripcion');
            $table->string('estado')->default('borrador'); // borrador, abierta, cerrada
            $table->text('instrucciones_pago')->nullable();
            $table->timestamps();

            $table->index('fecha');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
