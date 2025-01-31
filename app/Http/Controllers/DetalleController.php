<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoDetalle;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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
        $usuario = Usuario::findOrFail($id);
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->ci = $request->ci;
        $usuario->celular = $request->celular;
        $usuario->email = $request->email;
        $usuario->save();

        if ($usuario->detalle) {
            $detalle = EmpleadoDetalle::where('usu_id', $usuario->id)->first();
            $detalle->fecha_nacimiento = $request->fecha_nacimiento ? Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->format('Y-m-d') : '';
            $detalle->genero = $request->genero;
            $detalle->estado_civil = $request->estado_civil;

            $detalle->nacionalidad = $request->nacionalidad;
            $detalle->ocupacion = $request->ocupacion;
            $detalle->etnia = $request->etnia;
            $detalle->religion = $request->religion;

            $detalle->num_pasaporte = $request->num_pasaporte;
            $detalle->exp_pasaporte = $request->exp_pasaporte ? Carbon::createFromFormat('d/m/Y', $request->exp_pasaporte)->format('Y-m-d') : '';
            $detalle->tel_pasaporte = $request->tel_pasaporte;

            $detalle->contacto_emergencia = $request->contacto_emergencia;
            $detalle->detalle_emergencia = $request->detalle_emergencia;
            $detalle->save();
        }

        session()->flash('message', 'Información del usuario actualizado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Información del usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
