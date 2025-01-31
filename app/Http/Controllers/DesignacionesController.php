<?php
namespace App\Http\Controllers;

use App\Models\Designacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignacionesController extends Controller
{
    public function __construct()
    {
        if (Auth::check() && !Auth::user()->can('designacion.show')) {
            abort(403, 'Acción no autorizada !');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designaciones = Designacion::all();
        return view('backend.designaciones.index', compact('designaciones'));
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
            'nombre'      => 'required',
            'descripcion' => 'nullable',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
        ]);

        $designacion              = new Designacion();
        $designacion->nombre      = $request->nombre;
        $designacion->descripcion = $request->descripcion;
        $designacion->save();

        session()->flash('message', 'Designación agregado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Designación agregado correctamente');
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
            'nombre'      => 'required',
            'descripcion' => 'nullable',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
        ]);

        $designacion              = Designacion::findOrFail($id);
        $designacion->nombre      = $request->nombre;
        $designacion->descripcion = $request->descripcion;
        $designacion->save();

        session()->flash('message', 'Designación actualizado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Designación actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $designacion = Designacion::findOrFail($id);
        $designacion->delete();

        session()->flash('message', 'Designación eliminado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Designación eliminado correctamente');
    }
}
