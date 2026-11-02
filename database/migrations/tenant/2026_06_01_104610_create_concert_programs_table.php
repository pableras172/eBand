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
        Schema::create('concert_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('event_date');
            $table->time('event_time');
            $table->string('location');
            $table->text('participants')->nullable();
            $table->string('image_path')->nullable();
            $table->string('logo_1_path')->nullable();
            $table->string('logo_2_path')->nullable();
            $table->string('logo_3_path')->nullable();
            $table->timestamps();

            $table->index('event_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concert_programs');
    }
};
