<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles de usuarios
        $roles = [
            'usuario' => [
                'usuario.create',
                'usuario.show',
                'usuario.edit',
                'usuario.delete',
            ]
        ];
        foreach ($roles as $module => $permissions) {
            foreach ($permissions as $role) {
                Permission::firstOrCreate([
                    'name' => $role,
                    'module' => $module,
                    'guard_name' => 'admin'
                ]);
            }
        }

        // Admin
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo($roles);

        // Empleado
        $employeeRole = Role::findByName('empleado');
        $employeeRole->givePermissionTo(['usuario.show']);
    }
}
