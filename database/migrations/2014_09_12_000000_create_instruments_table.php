<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('icon', 2048)->nullable();
            $table->integer('orden');
            $table->timestamps();
        });

        // Insertar registros automáticamente
        DB::table('instruments')->insert([
            ['id' => 1, 'name' => 'Trompeta', 'icon' => '', 'orden' => 4, 'created_at' => now(), 'updated_at' => '2024-04-23 05:58:39'],
            ['id' => 2, 'name' => 'Clarinet', 'icon' => '', 'orden' => 9, 'created_at' => now(), 'updated_at' => '2024-04-23 05:57:56'],
            ['id' => 12, 'name' => 'Flauta', 'icon' => '', 'orden' => 10, 'created_at' => now(), 'updated_at' => '2024-04-01 18:12:14'],
            ['id' => 13, 'name' => 'Saxo Alt', 'icon' => '', 'orden' => 8, 'created_at' => now(), 'updated_at' => '2024-04-01 18:12:23'],
            ['id' => 14, 'name' => 'Saxo Tenor', 'icon' => '', 'orden' => 7, 'created_at' => now(), 'updated_at' => '2024-04-01 18:12:31'],
            ['id' => 15, 'name' => 'Trombó', 'icon' => '', 'orden' => 3, 'created_at' => now(), 'updated_at' => '2024-05-14 13:52:37'],
            ['id' => 16, 'name' => 'Tuba', 'icon' => '', 'orden' => 2, 'created_at' => now(), 'updated_at' => '2024-04-23 05:59:45'],
            ['id' => 17, 'name' => 'Percussió', 'icon' => '', 'orden' => 1, 'created_at' => now(), 'updated_at' => '2024-05-14 13:52:47'],
            ['id' => 19, 'name' => 'Bombardí', 'icon' => '', 'orden' => 6, 'created_at' => '2024-04-19 03:54:35', 'updated_at' => '2024-04-23 05:59:40'],
            ['id' => 20, 'name' => 'Trompa', 'icon' => '', 'orden' => 5, 'created_at' => '2024-04-19 03:56:09', 'updated_at' => '2024-04-23 05:59:14'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
};
