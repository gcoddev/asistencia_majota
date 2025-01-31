<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoPermiso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermisosController extends Controller
{
    public function __construct()
    {
        if (Auth::check() && !Auth::user()->can('permiso.show')) {
            abort(403, 'Acción no autorizada !');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisos = null;
        $vacaciones = null;

        if (Auth::user()->role[0]->name == 'admin') {
            $permisos = EmpleadoPermiso::where('tipo', 'permiso')
                ->orderByRaw("FIELD(estado, 'pendiente', 'rechazado', 'aprobado')")
                ->get();
            $vacaciones = EmpleadoPermiso::where('tipo', 'vacacion')
                ->orderByRaw("FIELD(estado, 'pendiente', 'rechazado', 'aprobado')")
                ->get();
        } else {
            $permisos = EmpleadoPermiso::where('tipo', 'permiso')
                ->where('usu_detalle_id', Auth::user()->detalle->id)
                ->orderByRaw("FIELD(estado, 'pendiente', 'rechazado', 'aprobado')")
                ->get();
            $vacaciones = EmpleadoPermiso::where('tipo', 'vacacion')
                ->where('usu_detalle_id', Auth::user()->detalle->id)
                ->orderByRaw("FIELD(estado, 'pendiente', 'rechazado', 'aprobado')")
                ->get();
        }

        return view('backend.permisos.index', compact('permisos', 'vacaciones'));
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
        $request->validate([
            'usu_detalle_id' => 'required',
            'tipo' => 'required',
            'fecha_ini' => 'required|date_format:d/m/Y',
            'fecha_fin' => 'required|date_format:d/m/Y',
            'dias' => 'required|min:1',
            'razones' => 'required',
        ], [
            'usu_detalle_id.required' => 'El empleado es obligatorio',
            'tipo.required' => 'El tipo es obligatorio',
            'fecha_ini.required' => 'La fecha de inicio es obligatoria',
            'fecha_ini.date_format' => 'Debe ser una fecha valida',
            'fecha_fin.required' => 'La fecha de fin es obligatoria',
            'fecha_fin.date_format' => 'Debe ser una fecha valida',
            'fecha_fin.after' => 'La fecha limite debe ser al menos un dia después de la fecha de inicio',
            'dias.required' => 'Los días son obligatorios',
            'dias.min' => 'Debe ser al menos un dia',
            'razones.required' => 'Las razones son obligatorias',
        ]);

        $permiso = new EmpleadoPermiso();
        $permiso->usu_detalle_id = $request->usu_detalle_id;
        $permiso->tipo = $request->tipo;
        $permiso->fecha_ini = Carbon::createFromFormat('d/m/Y', $request->fecha_ini)->format('Y-m-d');
        $permiso->fecha_fin = Carbon::createFromFormat('d/m/Y', $request->fecha_fin)->format('Y-m-d');
        $permiso->dias = $request->dias;
        $permiso->razones = $request->razones;
        $permiso->save();

        session()->flash('message', 'Permiso creado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Permiso creado correctamente');
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
        if (isset($request->estado)) {
            $permiso = EmpleadoPermiso::findOrFail($id);
            $permiso->estado = $request->estado;
            $permiso->usu_id = Auth::user()->id;
            $permiso->save();

            session()->flash('message', 'Permiso ' . $permiso->estado . ' correctamente');

            if ($request->ajax()) {
                return response()->json(['redirect' => url()->previous()]);
            }

            return redirect()->back()->with('message', 'Permiso ' . $permiso->estado . ' correctamente');
        }

        $request->validate([
            'usu_detalle_id' => 'required',
            'tipo' => 'required',
            'fecha_ini' => 'required|date_format:d/m/Y',
            'fecha_fin' => 'required|date_format:d/m/Y',
            'dias' => 'required|min:1',
            'razones' => 'required',
        ], [
            'usu_detalle_id.required' => 'El usuario es obligatorio',
            'tipo.required' => 'El tipo es obligatorio',
            'fecha_ini.required' => 'La fecha de inicio es obligatoria',
            'fecha_ini.date_format' => 'Debe ser una fecha valida',
            'fecha_fin.required' => 'La fecha de fin es obligatoria',
            'fecha_fin.date_format' => 'Debe ser una fecha valida',
            'fecha_fin.after' => 'La fecha limite debe ser al menos un dia después de la fecha de inicio',
            'dias.required' => 'Los días son obligatorios',
            'dias.min' => 'Debe ser al menos un dia',
            'razones.required' => 'Las razones son obligatorias',
        ]);

        $permiso = EmpleadoPermiso::findOrFail($id);
        $permiso->usu_detalle_id = $request->usu_detalle_id;
        $permiso->tipo = $request->tipo;
        $permiso->fecha_ini = Carbon::createFromFormat('d/m/Y', $request->fecha_ini)->format('Y-m-d');
        $permiso->fecha_fin = Carbon::createFromFormat('d/m/Y', $request->fecha_fin)->format('Y-m-d');
        $permiso->dias = $request->dias;
        $permiso->razones = $request->razones;
        $permiso->save();

        session()->flash('message', 'Permiso actualizado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Permiso actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $permiso = EmpleadoPermiso::findOrFail($id);
        $permiso->delete();

        session()->flash('message', 'Permiso eliminado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Permiso eliminado correctamente');
    }
}
