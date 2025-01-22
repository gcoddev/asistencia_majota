<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoDescuentoCompensacion;
use App\Models\EmpleadoDetalle;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeduccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $descuentos = EmpleadoDescuentoCompensacion::where('tipo', 'deduccion')->get();
        // $empleados = Usuario::whereHas('roles', function ($query) {
        //     $query->where('name', 'empleado');
        // })->get();
        $empleados = EmpleadoDetalle::all();

        return view('backend.deducciones.index', compact('descuentos', 'empleados'));
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
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'fecha' => 'required|date_format:d/m/Y',
            'horas' => 'required',
            'monto' => 'required',
        ], [
            'usu_detalle_id.required' => 'El usuario es obligatorio',
            'nombre.required' => 'El nombre es obligatorio',
            'fecha.required' => 'La fecha es obligatoria',
            'fecha.date_format' => 'Debe ser una fecha valida',
            'horas.required' => 'Las horas son obligatorias',
            'monto.required' => 'El monto es obligatorio',
        ]);

        $descuento = new EmpleadoDescuentoCompensacion();
        $descuento->tipo = 'deduccion';
        $descuento->usu_detalle_id = $request->usu_detalle_id;
        $descuento->nombre = $request->nombre;
        $descuento->descripcion = $request->descripcion;
        $descuento->fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');
        $descuento->horas = $request->horas;
        $descuento->monto = $request->monto;
        $descuento->save();

        session()->flash('message', 'Descuento agregado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Descuento agregado correctamente');
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
        $request->validate([
            'usu_detalle_id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'fecha' => 'required|date_format:d/m/Y',
            'horas' => 'required',
            'monto' => 'required',
        ], [
            'usu_detalle_id.required' => 'El usuario es obligatorio',
            'nombre.required' => 'El nombre es obligatorio',
            'fecha.required' => 'La fecha es obligatoria',
            'fecha.date_format' => 'Debe ser una fecha valida',
            'horas.required' => 'Las horas son obligatorias',
            'monto.required' => 'El monto es obligatorio',
        ]);

        $descuento = EmpleadoDescuentoCompensacion::findOrFail($id);
        $descuento->usu_detalle_id = $request->usu_detalle_id;
        $descuento->nombre = $request->nombre;
        $descuento->descripcion = $request->descripcion;
        $descuento->fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');
        $descuento->horas = $request->horas;
        $descuento->monto = $request->monto;
        $descuento->save();

        session()->flash('message', 'Descuento actualizado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Descuento actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $descuento = EmpleadoDescuentoCompensacion::findOrFail($id);
        $descuento->delete();

        session()->flash('message', 'Descuento eliminado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Descuento eliminado correctamente');
    }
}
