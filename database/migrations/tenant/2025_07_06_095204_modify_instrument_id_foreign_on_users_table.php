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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['instrument_id']);

            $table->foreign('instrument_id')
                ->references('id')->on('instruments')
                ->nullOnDelete(); // o ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['instrument_id']);

            $table->foreign('instrument_id')
                ->references('id')->on('instruments')
                ->onDelete('cascade'); // o lo que tenías antes
        });
    }
};
