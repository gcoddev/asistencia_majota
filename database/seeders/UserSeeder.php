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
        $user = Usuario::create([
            'nombres' => 'Admin',
            'apellidos' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
        ]);

        // Asignar rol de admin al usuario
        $user->assignRole('admin');

        // $detalle = new EmpleadoDetalle();
        // $detalle->usu_id = $user->id;
        // $detalle->save();

        $user = Usuario::create([
            'nombres' => 'Empleado',
            'apellidos' => 'Empleado',
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
