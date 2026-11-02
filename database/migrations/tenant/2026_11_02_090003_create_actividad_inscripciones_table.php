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
        Schema::create('actividad_inscripciones', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('actividad_id')->constrained('actividades')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('fecha_inscripcion');
            $table->decimal('total', 8, 2)->default(0.00);
            $table->text('observaciones_alergias')->nullable();
            $table->boolean('pagado')->default(false);
            $table->string('metodo_pago')->nullable(); // bizum, efectivo, transferencia, otro
            $table->dateTime('fecha_pago')->nullable();
            $table->timestamps();

            $table->unique(['actividad_id', 'user_id']);
            $table->index('actividad_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_inscripciones');
    }
};
