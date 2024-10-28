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
        Schema::create('listas_user', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('listas_id')->references('id')->on('listas')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->boolean('coche')->default(false);
            $table->boolean('pagada')->default(false);
            $table->boolean('cuentas')->default(false);
            $table->boolean('disponible')->default(true);
            $table->foreignId('payment_id')->nullable()->constrained('payment')->nullOnDelete();
            $table->decimal('totalCoche', 8, 2)->default(0);
            $table->decimal('totalActo', 8, 2)->default(0);
            $table->decimal('totalActuacion', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listas_users');
    }
};
