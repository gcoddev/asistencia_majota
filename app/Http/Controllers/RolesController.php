<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index($id = null)
    {
        $pageTitle = 'Roles and Permissions';

        $roles = Role::with(['permissions'])->get();

        $selected_role = null;
        if (!empty($id)) {
            $decrypted_id = Crypt::decrypt($id);
            $selected_role = Role::find($decrypted_id);
        }
        $permissions = [];

        $permissionArray = Permission::orderBy('module')->get();
        foreach ($permissionArray as $item) {
            $module = $item->module;
            $permission = $item->name;
            $permissions[$module][] = $permission;
        }
        return view('auth.roles.index', compact(
            'pageTitle',
            'roles',
            'selected_role',
            'permissions'
        ));
    }


    public function getPermissions($id)
    {
        $role = Role::findOrFail($id);

        $permissions = $role->permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0]; // Agrupa por módulo
        });

        return response()->json([
            'permissions' => $permissions,
        ]);
    }
    public function create(Request $request) {}
}
