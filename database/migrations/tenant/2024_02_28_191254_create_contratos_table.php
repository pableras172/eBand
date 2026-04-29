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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->string('poblacion');
            $table->date('fechainicio');
            $table->date('fechafin');
            $table->text('descripcion');
            $table->string('contacto')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->integer('anyo')->nullable();
            $table->string('dnicontacto')->nullable();
            $table->text('observacions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
