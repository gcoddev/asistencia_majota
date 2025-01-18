<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departamentos = Departamento::all();
        return view('backend.departamentos.index', compact('departamentos'));
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
            'nombre' => 'required',
            'descripcion' => 'nullable',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
        ]);

        $departamento = new Departamento();
        $departamento->nombre = $request->nombre;
        $departamento->descripcion = $request->descripcion;
        $departamento->save();

        session()->flash('message', 'Departamento agregado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Departamento agregado correctamente');
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
            'nombre' => 'required',
            'descripcion' => 'nullable',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
        ]);

        $departamento = Departamento::findOrFail($id);
        $departamento->nombre = $request->nombre;
        $departamento->descripcion = $request->descripcion;
        $departamento->save();

        session()->flash('message', 'Departamento actualizado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Departamento actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        session()->flash('message', 'Departamento eliminado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Departamento eliminado correctamente');
    }
}
