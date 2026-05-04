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
        Schema::table('demo_access_leads', function (Blueprint $table) {
            $table->string('lead_type', 40)->nullable()->index();
            $table->string('source', 60)->nullable()->index();
            $table->string('entidad')->nullable();
            $table->string('municipio')->nullable();
            $table->string('telefono_contacto', 30)->nullable();
            $table->text('mensaje')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demo_access_leads', function (Blueprint $table) {
            $table->dropColumn([
                'lead_type',
                'source',
                'entidad',
                'municipio',
                'telefono_contacto',
                'mensaje',
            ]);
        });
    }
};
