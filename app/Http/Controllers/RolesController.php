<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct()
    {

    }
    public function index($id = null)
    {
        if (Auth::check() && ! Auth::user()->can('roles.show')) {
            abort(403, 'Acción no autorizada !');
        }

        $roles = Role::with(['permissions'])->get();

        // $selected_role = null;
        // if (!empty($id)) {
        //     $decrypted_id = Crypt::decrypt($id);
        //     $selected_role = Role::find($decrypted_id);
        // }
        $permissions = [];

        $permissionArray = Permission::all();
        foreach ($permissionArray as $item) {
            $module                 = $item->module;
            $permission             = $item->name;
            $permissions[$module][] = $permission;
        }
        return view('auth.roles.index', compact(
            'permissions',
            'roles',
        ));
    }
    public function create(Request $request)
    {}

    public function store(Request $request)
    {
        if (Auth::check() && ! Auth::user()->can('roles.create')) {
            abort(403, 'Acción no autorizada !');
        }

        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'El nombre es obligatorio',
        ]);

        $departamento       = new Role();
        $departamento->name = $request->name;
        $departamento->save();

        session()->flash('message', 'Rol agregado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Rol agregado correctamente');
    }

    public function update(Request $request, string $id)
    {
        if (Auth::check() && ! Auth::user()->can('roles.edit')) {
            abort(403, 'Acción no autorizada !');
        }

        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'El nombre es obligatorio',
        ]);

        $departamento       = Role::findOrFail($id);
        $departamento->name = $request->name;
        $departamento->save();

        session()->flash('message', 'Rol actualizado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Rol actualizado correctamente');
    }

    public function destroy(Request $request, string $id)
    {
        if (Auth::check() && ! Auth::user()->can('roles.delete')) {
            abort(403, 'Acción no autorizada !');
        }

        $role = Role::findOrFail($id);
        $role->permissions()->detach();
        $role->delete();

        session()->flash('message', 'Rol eliminado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Rol eliminado correctamente');
    }

    public function putPermission(Request $request)
    {
        if (Auth::check() && ! Auth::user()->can('roles.edit')) {
            abort(403, 'Acción no autorizada !');
        }

        $request->validate([
            'role_id'       => 'required',
            'permissions'   => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'role_id.required'     => 'El id del rol es obligatorio',
            'permissions.required' => 'Los permisos son requeridos',
            'permissions.array'    => 'Los permisos deben ser un arreglo',
            'permissions.*.exists' => 'Los permisos deben ser validos',
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->syncPermissions($request->permissions);

        return back()->with('message', 'Permisos actualizados correctamente');
    }
}
