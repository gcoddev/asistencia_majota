<?php

namespace Database\Seeders;

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
            'paterno' => 'Admin',
            'materno' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
        ]);

        // Asignar rol de admin al usuario
        $user->assignRole('admin');

        $user = Usuario::create([
            'nombres' => 'Empleado',
            'paterno' => 'Empleado',
            'materno' => 'Empleado',
            'username' => 'empleado',
            'password' => bcrypt('empleado'),
        ]);

        // Asignar rol de empleado al usuario
        $user->assignRole('empleado');
    }
}
