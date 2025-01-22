<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoSalario;
use Illuminate\Http\Request;

class SalarioController extends Controller
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
        $request->validate([
            'usu_detalle_id' => 'required',
            'base' => 'required',
            'salario_base' => 'required',
            'metodo_pago' => 'required',
        ], [
            'usu_detalle_id.required' => 'El usuario es obligatorio',
            'base.required' => 'La base salarial es obligatoria',
            'salario_base.required' => 'El salario base es obligatorio',
            'metodo_pago.required' => 'El metodo de pago es obligatorio',
        ]);

        if ($request->metodo_pago == 'Transferencia bancaria') {
            $request->validate([
                'cuenta_bancaria' => 'required',
            ], [
                'cuenta_bancaria.required' => 'La cuenta bancaria es obligatoria',
            ]);
        }

        $salario = new EmpleadoSalario();
        $salario->usu_detalle_id = $request->usu_detalle_id;
        $salario->base = $request->base;
        $salario->salario_base = $request->salario_base;
        $salario->metodo_pago = $request->metodo_pago;
        $salario->cuenta_bancaria = $request->cuenta_bancaria;
        $salario->save();

        session()->flash('message', 'Información de salario guardado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Información de salario guardado correctamente');
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
            'base' => 'required',
            'salario_base' => 'required',
            'metodo_pago' => 'required',
        ], [
            'usu_detalle_id.required' => 'El usuario es obligatorio',
            'base.required' => 'La base salarial es obligatoria',
            'salario_base.required' => 'El salario base es obligatorio',
            'metodo_pago.required' => 'El metodo de pago es obligatorio',
        ]);

        if ($request->metodo_pago == 'Transferencia bancaria') {
            $request->validate([
                'cuenta_bancaria' => 'required',
            ], [
                'cuenta_bancaria.required' => 'La cuenta bancaria es obligatoria',
            ]);
        }

        $salario = EmpleadoSalario::findOrFail($id);
        $salario->usu_detalle_id = $request->usu_detalle_id;
        $salario->base = $request->base;
        $salario->salario_base = $request->salario_base;
        $salario->metodo_pago = $request->metodo_pago;
        $salario->cuenta_bancaria = $request->cuenta_bancaria;
        $salario->save();

        session()->flash('message', 'Información de salario actualizado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Información de salario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
