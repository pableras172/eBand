<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tipoactuacions', function (Blueprint $table) {
            $table->boolean('tipoensayo')->default(false);
            $table->boolean('tipoconcierto')->default(false);
        });

        // Actualizar registros existentes con valores por defecto
        DB::table('tipoactuacions')->update([
            'tipoensayo' => false,
            'tipoconcierto' => false,
        ]);
    }

    public function down(): void
    {
        Schema::table('tipoactuacions', function (Blueprint $table) {
            $table->dropColumn(['tipoensayo', 'tipoconcierto']);
        });
    }
};
