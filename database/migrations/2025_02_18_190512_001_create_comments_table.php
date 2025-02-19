<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->longText('comment');
            $table->boolean('inadecuado')->default(false);
            $table->boolean('eliminado')->default(false);
            // Relación con usuarios
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Relación con actuaciones
            $table->foreignId('actuacion_id')
                ->constrained('actuacions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Campo para datos adicionales (JSON)
            $table->json('data');

            // Agregar timestamps automáticamente
            $table->timestamps();

            // Índice compuesto para mejorar rendimiento
            $table->index(['actuacion_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
