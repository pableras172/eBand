<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        // Obtener el rol Admin
        $adminRole = DB::table('roles')->where('title', 'Admin')->first();

        if (!$adminRole) {
            throw new \Exception("El rol 'Admin' no existe. Ejecuta primero la migración de roles.");
        }

        // Crear el usuario admin
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@eband.app',
            'password' => Hash::make('AdminPassword123!'), // cámbialo por uno seguro
            'observaciones' => 'Usuario administrador del sistema',
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asignar el rol Admin al usuario
        $adminUser = DB::table('users')->where('email', 'admin@eband.app')->first();

        if ($adminUser) {
            DB::table('role_user')->insert([
                'user_id' => $adminUser->id,
                'role_id' => $adminRole->id,
            ]);
        }
    }

    public function down(): void
    {
        $adminUser = DB::table('users')->where('email', 'admin@eband.app')->first();

        if ($adminUser) {
            DB::table('role_user')->where('user_id', $adminUser->id)->delete();
            DB::table('users')->where('id', $adminUser->id)->delete();
        }
    }
};
