<?php
namespace Database\Seeders;

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
            'usuario'      => [
                'usuario.create',
                'usuario.show',
                'usuario.edit',
                'usuario.delete',
            ],
            'departamento' => [
                'departamento.create',
                'departamento.show',
                'departamento.edit',
                'departamento.delete',
            ],
            'designacion'  => [
                'designacion.create',
                'designacion.show',
                'designacion.edit',
                'designacion.delete',
            ],
            'permiso'      => [
                'permiso.create',
                'permiso.show',
                'permiso.edit',
                'permiso.delete',
            ],
            'sueldo'       => [
                'sueldo.create',
                'sueldo.show',
                'sueldo.edit',
                'sueldo.delete',
            ],
            'compensacion' => [
                'compensacion.create',
                'compensacion.show',
                'compensacion.edit',
                'compensacion.delete',
            ],
            'deduccion'    => [
                'deduccion.create',
                'deduccion.show',
                'deduccion.edit',
                'deduccion.delete',
            ],
            'roles'        => [
                'roles.create',
                'roles.show',
                'roles.edit',
                'roles.delete',
            ],
            'asistencia'   => [
                'asistencia.create',
                'asistencia.show',
                'asistencia.edit',
                'asistencia.delete',
            ],
        ];
        foreach ($roles as $module => $permissions) {
            foreach ($permissions as $role) {
                Permission::firstOrCreate([
                    'name'       => $role,
                    'module'     => $module,
                    'guard_name' => 'admin',
                ]);
            }
        }

        // Admin
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo($roles);
        $adminRole->revokePermissionTo(['permiso.create']);

        // Tecnico
        $tecnicoRole = Role::findByName('tecnico');
        $tecnicoRole->givePermissionTo($roles);
        $tecnicoRole->revokePermissionTo([
            'permiso.create',

            'usuario.create',
            'usuario.show',
            'usuario.edit',
            'usuario.delete',

            'roles.create',
            'roles.show',
            'roles.edit',
            'roles.delete',
        ]);

        // Empleado
        $employeeRole = Role::findByName('empleado');
        $employeeRole->givePermissionTo([
            'permiso.show',
            'permiso.create',
            'permiso.edit',
            'permiso.delete',

            'asistencia.show',
            'asistencia.create',
            'asistencia.edit',
        ]);
    }
}
