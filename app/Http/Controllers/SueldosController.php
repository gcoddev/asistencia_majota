<?php
namespace App\Http\Controllers;

use App\Models\EmpleadoDescuentoCompensacion;
use App\Models\EmpleadoDetalle;
use App\Models\Recibo;
use App\Models\ReciboItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SueldosController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() && ! Auth::user()->can('sueldo.show')) {
            abort(403, 'Acción no autorizada !');
        }

        $sueldos   = Recibo::all();
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
        if (Auth::check() && ! Auth::user()->can('sueldo.create')) {
            abort(403, 'Acción no autorizada !');
        }

        $request->validate([
            'usu_detalle_id' => 'required',
            'salario_total'  => 'required',
            'salario_neto'   => 'required',
            'fecha_recibo'   => 'required|date_format:d/m/Y',
            'tipo'           => 'required',
            'cantidad'       => 'required',
        ], [
            'usu_detalle_id.required'  => 'El empleado es obligatorio',
            'salario_total.required'   => 'El salario total es obligatorio',
            'salario_neto.required'    => 'El salario base es obligatorio',
            'fecha_recibo'             => 'La fecha del recibo es obligatoria',
            'fecha_recibo.date_format' => 'Debe ser una fecha valida',
            'tipo.required'            => 'La base salarial es obligatoria',
            'cantidad.required'        => 'La cantidad es obligatoria',
        ]);

        // return response()->json($request);

        $sueldo                 = new Recibo();
        $sueldo->usu_detalle_id = $request->usu_detalle_id;
        $sueldo->salario_neto   = $request->salario_neto;
        $sueldo->salario_total  = $request->salario_total;
        $sueldo->fecha_recibo   = Carbon::createFromFormat('d/m/Y', $request->fecha_recibo)->format('Y-m-d');
        $sueldo->tipo           = $request->tipo;
        $sueldo->cantidad       = $request->cantidad;
        $sueldo->save();

        if (isset($request->use_compensaciones) && $request->use_compensaciones == 'on') {
            if ($request->compensaciones && count($request->compensaciones) > 0) {
                $sueldo->use_compensaciones = true;
                foreach ($request->compensaciones as $item) {
                    $com            = new ReciboItem();
                    $com->recibo_id = $sueldo->id;
                    $com->item_id   = $item;
                    $com->tipo      = 'compensacion';
                    $com->save();

                    $it      = EmpleadoDescuentoCompensacion::findOrFail($item);
                    $it->use = true;
                    $it->save();
                }
            }
        }
        if (isset($request->use_deducciones) && $request->use_deducciones == 'on') {
            if ($request->deducciones && count($request->deducciones) > 0) {
                $sueldo->use_deducciones = true;
                foreach ($request->deducciones as $item) {
                    $com            = new ReciboItem();
                    $com->recibo_id = $sueldo->id;
                    $com->item_id   = $item;
                    $com->tipo      = 'deduccion';
                    $com->save();

                    $it      = EmpleadoDescuentoCompensacion::findOrFail($item);
                    $it->use = true;
                    $it->save();
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
        if (Auth::check() && ! Auth::user()->can('sueldo.show')) {
            abort(403, 'Acción no autorizada !');
        }

        $sueldo = Recibo::findOrFail($id);
        return view('backend.sueldos.show', compact('sueldo'));
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
        if (Auth::check() && ! Auth::user()->can('sueldo.edit')) {
            abort(403, 'Acción no autorizada !');
        }

        $request->validate([
            // 'usu_detalle_id' => 'required',
            'salario_total' => 'required',
            'salario_neto'  => 'required',
            'fecha_recibo'  => 'required|date_format:d/m/Y',
            'tipo'          => 'required',
            'cantidad'      => 'required',
        ], [
            // 'usu_detalle_id.required' => 'El empleado es obligatorio',
            'salario_total.required'   => 'El salario total es obligatorio',
            'salario_neto.required'    => 'El salario base es obligatorio',
            'fecha_recibo'             => 'La fecha del recibo es obligatoria',
            'fecha_recibo.date_format' => 'Debe ser una fecha valida',
            'tipo.required'            => 'La base salarial es obligatoria',
            'cantidad.required'        => 'La cantidad es obligatoria',
        ]);

        // return response()->json($request);

        $sueldo = Recibo::findOrFail($id);
        // $sueldo->usu_detalle_id = $request->usu_detalle_id;
        $sueldo->salario_neto  = $request->salario_neto;
        $sueldo->salario_total = $request->salario_total;
        $sueldo->fecha_recibo  = Carbon::createFromFormat('d/m/Y', $request->fecha_recibo)->format('Y-m-d');
        $sueldo->tipo          = $request->tipo;
        $sueldo->cantidad      = $request->cantidad;
        $sueldo->save();

        if (count($sueldo->compensaciones) > 0) {
            foreach ($sueldo->compensaciones as $com) {
                $it      = EmpleadoDescuentoCompensacion::findOrFail($com->item_id);
                $it->use = false;
                $it->save();

                $com->delete();
            }
        }
        if (isset($request->use_compensaciones) && $request->use_compensaciones == 'on') {
            if ($request->compensaciones && count($request->compensaciones) > 0) {
                $sueldo->use_compensaciones = true;
                foreach ($request->compensaciones as $item) {
                    $com            = new ReciboItem();
                    $com->recibo_id = $sueldo->id;
                    $com->item_id   = $item;
                    $com->tipo      = 'compensacion';
                    $com->save();

                    $it      = EmpleadoDescuentoCompensacion::findOrFail($item);
                    $it->use = true;
                    $it->save();
                }
            }
        } else {
            $sueldo->use_compensaciones = false;
        }

        if (count($sueldo->deducciones) > 0) {
            foreach ($sueldo->deducciones as $ded) {
                $it      = EmpleadoDescuentoCompensacion::findOrFail($ded->item_id);
                $it->use = false;
                $it->save();

                $ded->delete();
            }
        }
        if (isset($request->use_deducciones) && $request->use_deducciones == 'on') {
            if ($request->deducciones && count($request->deducciones) > 0) {
                $sueldo->use_deducciones = true;
                foreach ($request->deducciones as $item) {
                    $ded            = new ReciboItem();
                    $ded->recibo_id = $sueldo->id;
                    $ded->item_id   = $item;
                    $ded->tipo      = 'deduccion';
                    $ded->save();

                    $it      = EmpleadoDescuentoCompensacion::findOrFail($item);
                    $it->use = true;
                    $it->save();
                }
            }
        } else {
            $sueldo->use_deducciones = false;
        }
        $sueldo->save();

        session()->flash('message', 'Sueldo actualizado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Sueldo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if (Auth::check() && ! Auth::user()->can('sueldo.delete')) {
            abort(403, 'Acción no autorizada !');
        }

        $recibo = Recibo::findOrFail($id);
        if (count($recibo->compensaciones) > 0) {
            foreach ($recibo->compensaciones as $com) {
                $it      = EmpleadoDescuentoCompensacion::findOrFail($com->item_id);
                $it->use = false;
                $it->save();

                $com->delete();
            }
        }
        if (count($recibo->deducciones) > 0) {
            foreach ($recibo->deducciones as $ded) {
                $it      = EmpleadoDescuentoCompensacion::findOrFail($ded->item_id);
                $it->use = false;
                $it->save();

                $ded->delete();
            }
        }
        $recibo->delete();

        session()->flash('message', 'Sueldo eliminado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Sueldo eliminado correctamente');
    }

    public function reciboPDF(string $id)
    {
        $sueldo = Recibo::findOrFail($id);
        // return view('backend.sueldos.recibo.pdf', compact('sueldo'));
        $pdf = Pdf::loadView('backend.sueldos.recibo.pdf', compact('sueldo'));

        // return $pdf->download('archivo.pdf');
        return $pdf->stream('archivo.pdf');
    }

    public function reciboPrint(string $id)
    {
        $sueldo = Recibo::findOrFail($id);
        return view('backend.sueldos.recibo.print', compact('sueldo'));
    }
}
