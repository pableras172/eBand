<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('configuration')->insert([
            [
                'param' => 'enableusermessages',
                'value' => 'true',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'param' => 'enableads',
                'value' => 'true',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'param' => 'enablestripe',
                'value' => 'true',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'param' => 'emaildisponibles',
                'value' => 'pableras172@gmail.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('configuration')->whereIn('param', [
            'enableusermessages',
            'enableads',
            'enablestripe',
            'emaildisponibles',
        ])->delete();
    }
};
