<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('configuration')->insert([
            'param' => 'enable_weekly_actuaciones_email',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('configuration')->where('param', 'enable_weekly_actuaciones_email')->delete();
    }
};
