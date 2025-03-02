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
        // Insertar el nuevo parámetro en la tabla configuration
        DB::table('configuration')->insert([
            'param' => 'enableusermessages',
            'value' => 'false',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        // Eliminar el parámetro en caso de rollback
        DB::table('configuration')->where('param', 'enableusermessages')->delete();
    }
};
