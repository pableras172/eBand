<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insertar el nuevo permiso "superadmin"
        DB::table('permissions')->insert([
            'title' => 'superadmin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insertar el nuevo rol "SuperAdmin"
        DB::table('roles')->insert([
            'title' => 'SuperAdmin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $superAdminRole = DB::table('roles')->where('title', 'SuperAdmin')->first();
        $superAdminPermission = DB::table('permissions')->where('title', 'superadmin')->first();

        if ($superAdminRole) {
            // Obtener todos los permisos existentes + el nuevo permiso "superadmin"
            $permissions = DB::table('permissions')->pluck('id');

            // Asignar todos los permisos al rol SuperAdmin
            foreach ($permissions as $permission) {
                DB::table('permission_role')->insert([
                    'role_id' => $superAdminRole->id,
                    'permission_id' => $permission,
                ]);
            }
        }

        // Crear el usuario SuperAdmin
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@eband.app',
            'password' => Hash::make('SuperAdminPassword123!'), // Cambia esto por un password seguro
            'observaciones' => 'Usuario para tareas de configuración de la aplicación',
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'email_verified_at'=>now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asignar el rol SuperAdmin al nuevo usuario
        $superAdminUser = DB::table('users')->where('email', 'superadmin@eband.app')->first();

        if ($superAdminUser && $superAdminRole) {
            DB::table('role_user')->insert([
                'user_id' => $superAdminUser->id,
                'role_id' => $superAdminRole->id,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Obtener el ID del usuario y rol SuperAdmin
        $superAdminUser = DB::table('users')->where('email', 'superadmin@eband.app')->first();
        $superAdminRole = DB::table('roles')->where('title', 'SuperAdmin')->first();
        $superAdminPermission = DB::table('permissions')->where('title', 'superadmin')->first();

        if ($superAdminUser) {
            DB::table('role_user')->where('user_id', $superAdminUser->id)->delete();
            DB::table('users')->where('id', $superAdminUser->id)->delete();
        }

        if ($superAdminRole) {
            DB::table('permission_role')->where('role_id', $superAdminRole->id)->delete();
            DB::table('roles')->where('id', $superAdminRole->id)->delete();
        }

        if ($superAdminPermission) {
            DB::table('permissions')->where('id', $superAdminPermission->id)->delete();
        }
    }
};
