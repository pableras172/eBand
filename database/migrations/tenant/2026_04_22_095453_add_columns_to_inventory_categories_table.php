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
        if (! Schema::hasTable('inventory_categories')) {
            return;
        }

        Schema::table('inventory_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('inventory_categories', 'nombre')) {
                $table->string('nombre')->unique()->after('id');
            }

            if (! Schema::hasColumn('inventory_categories', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('nombre');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('inventory_categories')) {
            return;
        }

        Schema::table('inventory_categories', function (Blueprint $table) {
            $columnsToDrop = [];

            if (Schema::hasColumn('inventory_categories', 'nombre')) {
                $columnsToDrop[] = 'nombre';
            }

            if (Schema::hasColumn('inventory_categories', 'descripcion')) {
                $columnsToDrop[] = 'descripcion';
            }

            if ($columnsToDrop !== []) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
