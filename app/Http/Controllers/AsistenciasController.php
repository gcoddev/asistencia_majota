<?php
namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\AsistenciaTiempo;
use App\Models\EmpleadoDetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::check() && ! Auth::user()->can('asistencia.show')) {
            abort(403, 'Acción no autorizada !');
        }

        $usu_detalle_id = $request->input('usu_detalle_id');
        $mes            = $request->input('mes');
        $anio           = $request->input('anio');

        if (Auth::user()->role[0]->name == 'admin') {
            $empleados = EmpleadoDetalle::all();
        } else {
            $empleados = EmpleadoDetalle::where('usu_id', Auth::user()->id)->get();
        }

        if ($mes) {
            $fecha = Carbon::create($anio ?? Carbon::now()->year, $mes, 1);
        } else {
            $fecha = Carbon::now();
            $mes   = $fecha->month;
            if (! $anio) {
                $anio = $fecha->year;
            }
        }

        $finMes     = $fecha->copy()->endOfMonth();
        $diasDelMes = range(1, $finMes->day);

        $asistencias = Asistencia::orderBy('fecha', 'ASC')->first();
        if ($asistencias) {
            $oldYear = Carbon::parse($asistencias->fecha)->year;
        } else {
            $oldYear = Carbon::now()->year;
        }
        $latestYear = Carbon::now()->year;

        return view('backend.asistencias.index', compact('usu_detalle_id', 'mes', 'anio', 'oldYear', 'latestYear', 'diasDelMes', 'empleados'));
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
        if (Auth::check() && ! Auth::user()->can('asistencia.create')) {
            abort(403, 'Acción no autorizada !');
        }
        // return response()->json($request);

        $asistencia         = new Asistencia();
        $asistencia->usu_id = Auth::user()->id;
        $asistencia->fecha  = date('Y-m-d');
        $asistencia->save();

        $hora            = new AsistenciaTiempo();
        $hora->asis_id   = $asistencia->id;
        $hora->usu_id    = Auth::user()->id;
        $hora->hora_ini  = $request->hora;
        $hora->ubicacion = 'on';
        $hora->ip        = $request->ip();
        $hora->save();

        session()->flash('message', 'Asistencia marcada correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Asistencia marcada correctamente');
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
        if (Auth::check() && ! Auth::user()->can('asistencia.edit')) {
            abort(403, 'Acción no autorizada !');
        }
        // return response()->json($request);

        $asistencia = Asistencia::findOrFail($id);

        if ($request->hora_id != '') {
            $hora           = AsistenciaTiempo::findOrFail($request->hora_id);
            $hora->hora_fin = $request->hora;
            $hora->save();

            session()->flash('message', 'Asistencia de salida actualizada correctamente');

            if ($request->ajax()) {
                return response()->json(['redirect' => url()->previous()]);
            }

            return redirect()->back()->with('message', 'Asistencia de salida actualizada correctamente');
        } else {
            $hora            = new AsistenciaTiempo();
            $hora->asis_id   = $asistencia->id;
            $hora->usu_id    = Auth::user()->id;
            $hora->hora_ini  = $request->hora;
            $hora->ubicacion = 'on';
            $hora->ip        = $request->ip();
            $hora->save();

            session()->flash('message', 'Asistencia marcada correctamente');

            if ($request->ajax()) {
                return response()->json(['redirect' => url()->previous()]);
            }

            return redirect()->back()->with('message', 'Asistencia marcada correctamente');
        }
    }

    public function updateNote(Request $request, string $id)
    {
        if (Auth::check() && ! Auth::user()->can('asistencia.edit')) {
            abort(403, 'Acción no autorizada !');
        }

        $request->validate([
            'note'        => 'required',
            'note_estado' => 'nullable',
        ], [
            'note.required' => 'El motivo de no asistencia es obligatorio',
        ]);

        $hora         = AsistenciaTiempo::findOrFail($id);
        $hora->note   = $request->note;
        $hora->estado = $request->note_estado;
        $hora->save();

        session()->flash('message', 'Motivo enviado correctamente');

        if ($request->ajax()) {
            return response()->json(['redirect' => url()->previous()]);
        }

        return redirect()->back()->with('message', 'Motivo enviado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
