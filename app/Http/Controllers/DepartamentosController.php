<?php
namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartamentosController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() && ! Auth::user()->can('departamento.show')) {
            abort(403, 'Acción no autorizada !');
        }

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
        if (Auth::check() && ! Auth::user()->can('departamento.create')) {
            abort(403, 'Acción no autorizada !');
        }

        $request->validate([
            'nombre'      => 'required',
            'descripcion' => 'nullable',
            'hora_ini'    => 'required',
            'hora_fin'    => 'required',
            'latitud'     => 'nullable',
            'longitud'    => 'nullable',
        ], [
            'nombre.required'   => 'El nombre es obligatorio',
            'hora_ini.required' => 'La hora de entrada es obligatoria',
            'hora_fin.required' => 'La hora de salida es obligatoria',
        ]);

        $departamento              = new Departamento();
        $departamento->nombre      = $request->nombre;
        $departamento->descripcion = $request->descripcion;
        $departamento->hora_ini    = $request->hora_ini;
        $departamento->hora_fin    = $request->hora_fin;
        $departamento->latitud     = $request->latitud;
        $departamento->longitud    = $request->longitud;
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
        if (Auth::check() && ! Auth::user()->can('departamento.edit')) {
            abort(403, 'Acción no autorizada !');
        }

        $request->validate([
            'nombre'      => 'required',
            'descripcion' => 'nullable',
            'hora_ini'    => 'required',
            'hora_fin'    => 'required',
            'latitud'     => 'nullable',
            'longitud'    => 'nullable',
        ], [
            'nombre.required'   => 'El nombre es obligatorio',
            'hora_ini.required' => 'La hora de entrada es obligatoria',
            'hora_fin.required' => 'La hora de salida es obligatoria',
        ]);

        $departamento              = Departamento::findOrFail($id);
        $departamento->nombre      = $request->nombre;
        $departamento->descripcion = $request->descripcion;
        $departamento->hora_ini    = $request->hora_ini;
        $departamento->hora_fin    = $request->hora_fin;
        $departamento->latitud     = $request->latitud;
        $departamento->longitud    = $request->longitud;
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
        if (Auth::check() && ! Auth::user()->can('departamento.delete')) {
            abort(403, 'Acción no autorizada !');
        }

        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        session()->flash('message', 'Departamento eliminado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Departamento eliminado correctamente');
    }
}
