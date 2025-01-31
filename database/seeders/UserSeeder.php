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
            'ci' => '1',
            // 'username' => 'admin',
            'password' => bcrypt('admin'),
        ]);
        // Asignar rol de admin al usuario
        $user->assignRole('admin');

        // Tecnico
        $user = Usuario::create([
            'nombres' => 'Técnico',
            'apellidos' => 'Técnico',
            'email' => 'tecnico@majota.net',
            'ci' => '1000',
            // 'username' => 'tecnico',
            'password' => bcrypt('tecnico'),
        ]);
        // Asignar rol de tecnico al usuario
        $user->assignRole('tecnico');

        $detalle = new EmpleadoDetalle();
        $detalle->usu_id = $user->id;
        $detalle->fecha_ingreso = date('Y-m-d');
        $detalle->save();

        // Empleado
        $user = Usuario::create([
            'nombres' => 'Empleado',
            'apellidos' => 'Empleado',
            'email' => 'empleado@majota.net',
            'ci' => '2000',
            // 'username' => 'empleado',
            'password' => bcrypt('empleado'),
        ]);
        // Asignar rol de empleado al usuario
        $user->assignRole('empleado');

        $detalle = new EmpleadoDetalle();
        $detalle->usu_id = $user->id;
        $detalle->fecha_ingreso = date('Y-m-d');
        $detalle->save();
    }
}
