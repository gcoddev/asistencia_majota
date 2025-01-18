<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoDescuentoCompensacion;
use App\Models\EmpleadoDetalle;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompensacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compensaciones = EmpleadoDescuentoCompensacion::where('tipo', 'compensacion')->get();
        // $empleados = Usuario::whereHas('roles', function ($query) {
        //     $query->where('name', 'empleado');
        // })->get();
        $empleados = EmpleadoDetalle::all();

        return view('backend.compensaciones.index', compact('compensaciones', 'empleados'));
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

        $compensacion = new EmpleadoDescuentoCompensacion();
        $compensacion->tipo = 'compensacion';
        $compensacion->usu_detalle_id = $request->usu_detalle_id;
        $compensacion->nombre = $request->nombre;
        $compensacion->descripcion = $request->descripcion;
        $compensacion->fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');
        $compensacion->horas = $request->horas;
        $compensacion->monto = $request->monto;
        $compensacion->save();

        session()->flash('message', 'Compensación agregada correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Compensación agregada correctamente');
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

        $compensacion = EmpleadoDescuentoCompensacion::findOrFail($id);
        $compensacion->usu_detalle_id = $request->usu_detalle_id;
        $compensacion->nombre = $request->nombre;
        $compensacion->descripcion = $request->descripcion;
        $compensacion->fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');
        $compensacion->horas = $request->horas;
        $compensacion->monto = $request->monto;
        $compensacion->save();

        session()->flash('message', 'Compensación actualizada correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Compensación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $compensacion = EmpleadoDescuentoCompensacion::findOrFail($id);
        $compensacion->delete();

        session()->flash('message', 'Compensación eliminada correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Compensación eliminada correctamente');
    }
}
