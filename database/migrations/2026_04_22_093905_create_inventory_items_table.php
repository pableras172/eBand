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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_category_id')->constrained()->onDelete('cascade');
            $table->integer('year');
            $table->string('nombre');
            $table->integer('cantidad')->default(1);
            $table->decimal('valor_unitario', 10, 2);
            $table->enum('estado', ['nuevo', 'usado', 'desperfectos', 'dañado'])->default('nuevo');
            $table->text('observaciones')->nullable();
            $table->decimal('depreciation_rate', 5, 2)->default(0); // Tasa de depreciación anual en %
            $table->date('purchase_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
