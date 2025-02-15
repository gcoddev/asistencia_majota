<?php
namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Designacion;
use App\Models\EmpleadoDetalle;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UsuariosController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() && ! Auth::user()->can('usuario.show')) {
            abort(403, 'Acción no autorizada !');
        }

        $usuarios      = Usuario::get();
        $designaciones = Designacion::all();
        $departamentos = Departamento::all();
        $roles         = Role::orderBy('id', 'DESC')->get();
        return view('backend.usuarios.index', compact('usuarios', 'designaciones', 'departamentos', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check() && ! Auth::user()->can('usuario.create')) {
            abort(403, 'Acción no autorizada !');
        }

        $request->validate([
            'nombres'       => 'required',
            'apellidos'     => 'nullable',
            'ci'            => 'required|unique:usuarios',
            'email'         => 'nullable|email|unique:usuarios',
            'password'      => 'required|min:8|confirmed',
            'dep_id'        => 'nullable',
            'des_id'        => 'nullable',
            'imagen'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'fecha_ingreso' => 'required|date_format:d/m/Y',
        ], [
            'nombres.required'          => 'El nombre es obligatorio',
            'ci.required'               => 'El nombre de usuario es obligatorio',
            'ci.unique'                 => 'El nombre de usuario ya está en uso',
            'email.required'            => 'El email es obligatorio',
            'email.email'               => 'El email no es válido',
            'email.unique'              => 'El email ya está en uso',
            'password.required'         => 'La contraseña es obligatoria',
            'password.min'              => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed'        => 'Las contraseñas no coinciden',
            'imagen.image'              => 'Debe ser una imagen',
            'imagen.mimes'              => 'El formato de la imagen debe ser JPEG, PNG o JPG',
            'imagen.max'                => 'El tamaño de la imagen no puede superar los 2MB',
            'fecha_ingreso.required'    => 'La fecha de ingreso es obligatoria',
            'fecha_ingreso.date_format' => 'Debe ser una fecha valida',
        ]);

        // return response()->json($request);

        $usuario            = new Usuario();
        $usuario->nombres   = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->ci        = $request->ci;
        $usuario->email     = $request->email;
        $usuario->password  = bcrypt($request->password);

        if ($request->hasFile('imagen')) {
            $archivo       = $request->file('imagen');
            $nombreArchivo = time() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(storage_path('app/public/profile'), $nombreArchivo);
            $rutaImagen = 'storage/profile/' . $nombreArchivo;

            $usuario->imagen = $rutaImagen;
        }
        $usuario->save();

        $usuario->assignRole($request->role ?? 'empleado');

        $detalle                = new EmpleadoDetalle();
        $detalle->usu_id        = $usuario->id;
        $detalle->dep_id        = $request->dep_id;
        $detalle->des_id        = $request->des_id;
        $detalle->fecha_ingreso = Carbon::createFromFormat('d/m/Y', $request->fecha_ingreso)->format('Y-m-d');
        $detalle->save();

        session()->flash('message', 'Usuario agregado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Usuario agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::check() && ! Auth::user()->can('usuario.edit')) {
            abort(403, 'Acción no autorizada !');
        }

        if (isset($request->activo)) {
            $usuario         = Usuario::findOrFail($id);
            $usuario->activo = $request->activo;
            $usuario->save();

            $text = 'Usuario ' . ($usuario->activo == '1' ? 'habilitado' : 'inhabilitado') . ' correctamente';
            session()->flash('message', $text);

            if ($request->ajax()) {
                return response()->json(['redirect' => url()->previous()]);
            }

            return redirect()->back()->with('message', $text);
        }

        $request->validate([
            'nombres'   => 'required',
            'apellidos' => 'nullable',
            'ci'        => [
                'required',
                Rule::unique('usuarios')->ignore($request->id),
            ],
            'email'     => [
                'nullable',
                'email',
                Rule::unique('usuarios')->ignore($request->id),
            ],
            'password'  => 'nullable|min:8|confirmed',
            'dep_id'    => 'nullable',
            'des_id'    => 'nullable',
            'imagen'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nombres.required'   => 'El nombre es obligatorio',
            'ci.required'        => 'El nombre de usuario es obligatorio',
            'ci.unique'          => 'El nombre de usuario ya está en uso',
            'email.required'     => 'El email es obligatorio',
            'email.email'        => 'El email no es válido',
            'email.unique'       => 'El email ya está en uso',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'imagen.image'       => 'Debe ser una imagen',
            'imagen.mimes'       => 'El formato de la imagen debe ser JPEG, PNG o JPG',
            'imagen.max'         => 'El tamaño de la imagen no puede superar los 2MB',
        ]);

        if ($id != 1) {
            $request->validate([
                'fecha_ingreso' => 'required|date_format:d/m/Y',
            ], [
                'fecha_ingreso.required'    => 'La fecha de ingreso es obligatoria',
                'fecha_ingreso.date_format' => 'Debe ser una fecha valida',
            ]);
        }

        $usuario            = Usuario::findOrFail($id);
        $usuario->nombres   = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->ci        = $request->ci;
        $usuario->email     = $request->email;

        if ($request->password) {
            $usuario->password = bcrypt($request->password);
        }
        $oldImagePath = '';
        if ($request->hasFile('imagen')) {
            if ($usuario->imagen) {
                $oldImagePath = storage_path('app/' . str_replace('storage', 'public', $usuario->imagen));
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $archivo       = $request->file('imagen');
            $nombreArchivo = time() . '.' . $archivo->getClientOriginalExtension();
            $archivo->move(storage_path('app/public/profile'), $nombreArchivo);
            $rutaImagen = 'storage/profile/' . $nombreArchivo;

            $usuario->imagen = $rutaImagen;
        }
        $usuario->save();

        if ($id != 1) {
            if ($request->role != $usuario->role[0]->name) {
                $usuario->removeRole($usuario->role[0]->name);
                $usuario->assignRole($request->role);
            }

            if ($usuario->detalle) {
                $detalle                = EmpleadoDetalle::where('usu_id', $usuario->id)->first();
                $detalle->dep_id        = $request->dep_id;
                $detalle->des_id        = $request->des_id;
                $detalle->fecha_ingreso = Carbon::createFromFormat('d/m/Y', $request->fecha_ingreso)->format('Y-m-d');
                $detalle->save();
            }
        }

        session()->flash('message', 'Usuario actualizado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if (Auth::check() && ! Auth::user()->can('usuario.delete')) {
            abort(403, 'Acción no autorizada !');
        }

        $usuario = Usuario::findOrFail($id);
        if ($usuario->imagen) {
            $oldImagePath = storage_path('app/' . str_replace('storage', 'public', $usuario->imagen));
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $usuario->delete();

        session()->flash('message', 'Usuario eliminado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Usuario eliminado correctamente');
    }
}
