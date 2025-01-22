<?php

namespace Database\Seeders;

use App\Models\EmpleadoDetalle;
use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $user = Usuario::create([
            'nombres' => 'Admin',
            'apellidos' => 'Admin',
            'email' => 'admin@majota.net',
            'username' => 'admin',
            'password' => bcrypt('admin'),
        ]);
        // Asignar rol de admin al usuario
        $user->assignRole('admin');

        // Tecnico
        $user = Usuario::create([
            'nombres' => 'Tenico',
            'apellidos' => 'Tenico',
            'email' => 'tecnico@majota.net',
            'username' => 'tecnico',
            'password' => bcrypt('tecnico'),
        ]);
        // Asignar rol de tecnico al usuario
        $user->assignRole('tecnico');

        // Empleado
        $user = Usuario::create([
            'nombres' => 'Empleado',
            'apellidos' => 'Empleado',
            'email' => 'empleado@majota.net',
            'username' => 'empleado',
            'password' => bcrypt('empleado'),
        ]);
        // Asignar rol de empleado al usuario
        $user->assignRole('empleado');

        $detalle = new EmpleadoDetalle();
        $detalle->usu_id = $user->id;
        $detalle->save();
    }
}
