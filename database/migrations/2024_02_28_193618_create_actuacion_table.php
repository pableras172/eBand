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
        Schema::create('actuacions', function (Blueprint $table) {
            $table->id();
            $table->date('fechaActuacion');
            $table->text('descripcion');
            $table->foreignId('tipoactuacions_id')->constrained();
            $table->integer('coches')->nullable();
            $table->decimal('preciocoche', 8, 2)->nullable();
            $table->integer('musicos')->nullable();
            $table->decimal('preciomusico', 8, 2)->nullable();
            $table->integer('totalcoches')->nullable();
            $table->integer('totalmusicos')->nullable();
            $table->decimal('totalactuacion', 10, 2)->nullable();            
            $table->foreignId('contratos_id')->references('id')->on('contratos')->cascadeOnDelete();
            $table->boolean('pagado');
            $table->boolean('aplicaporcentaje');
            $table->boolean('noaplicapago');
            $table->text('observaciones')->nullable();
            $table->text('calendar')->nullable();
            $table->decimal('porcentajepersonal', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actuacions');
    }
};
