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
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fechacreacion')->nullable();
            $table->string('titulo');
            $table->text('texto');
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('iduser')->nullable()->index();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('set null');
            $table->boolean('anonimo')->default(false);
            //añade created_at y updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
