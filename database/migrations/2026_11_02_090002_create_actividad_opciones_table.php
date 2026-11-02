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
        Schema::create('actividad_opciones', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('actividad_id')->constrained('actividades')->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 8, 2)->default(0.00);
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();

            $table->index('actividad_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_opciones');
    }
};
