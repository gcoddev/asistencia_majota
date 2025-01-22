<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoDescuentoCompensacion;
use App\Models\EmpleadoDetalle;
use App\Models\Recibo;
use App\Models\ReciboItem;
use Illuminate\Http\Request;

class SueldosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sueldos = Recibo::all();
        $empleados = EmpleadoDetalle::all();

        return view('backend.sueldos.index', compact('sueldos', 'empleados'));
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
            'salario_total' => 'required',
        ], [
            'usu_detalle_id.required' => 'El empleado es obligatorio',
            'salario_total.required' => 'El salario total es obligatorio',
        ]);

        // return response()->json($request);

        $sueldo = new Recibo();
        $sueldo->usu_detalle_id = $request->usu_detalle_id;
        $sueldo->salario_neto = $request->salario_neto;
        $sueldo->salario_total = $request->salario_total;
        $sueldo->fecha_recibo = date('Y-m-d');
        $sueldo->save();

        if (isset($request->use_compensaciones) && $request->use_compensaciones == 'on') {
            $sueldo->use_compensaciones = true;
            if (count($request->compensaciones) > 0) {
                foreach ($request->compensaciones as $item) {
                    $com = new ReciboItem();
                    $com->recibo_id = $sueldo->id;
                    $com->item_id = $item;
                    $com->tipo = 'compensacion';
                    $com->save();
                }
            }
        }
        if (isset($request->use_deducciones) && $request->use_deducciones == 'on') {
            $sueldo->use_deducciones = true;
            if (count($request->deducciones) > 0) {
                foreach ($request->deducciones as $item) {
                    $com = new ReciboItem();
                    $com->recibo_id = $sueldo->id;
                    $com->item_id = $item;
                    $com->tipo = 'deduccion';
                    $com->save();
                }
            }
        }
        $sueldo->save();

        session()->flash('message', 'Sueldo agregado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Sueldo agregado correctamente');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
