<?php
namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\AsistenciaTiempo;
use App\Models\EmpleadoDetalle;
use App\Models\EmpleadoPermiso;
use App\Models\Recibo;
use App\Models\Usuario;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    public function usuarios()
    {
        $usuarios = Usuario::all();

        $pdf = PDF::loadView('reportes.usuarios', compact('usuarios'));

        return $pdf->stream('pdf_usuarios.pdf');
    }
    public function permisos()
    {
        $permisos = EmpleadoPermiso::all();

        $pdf = PDF::loadView('reportes.permisos', compact('permisos'));

        return $pdf->stream('pdf_permisos.pdf');
    }
    public function sueldos()
    {
        $sueldos = Recibo::all();

        $pdf = PDF::loadView('reportes.sueldos', compact('sueldos'));

        return $pdf->stream('pdf_sueldos.pdf');
    }
    public function asistencias($mes = null, $anio = null, $usu_detalle_id = null)
    {
        $asistenciasUser = 0;
        $faltas          = 0;
        $atrasos         = 0;
        $vacaciones      = 0;
        $permisos        = 0;

        if (Auth::user()->role[0]->name == 'admin') {
            if (! $usu_detalle_id) {
                $empleados = EmpleadoDetalle::all();
            } else {
                $empleados = EmpleadoDetalle::where('id', $usu_detalle_id)->get();

                if (count($empleados) > 0) {
                    $asistenciasUser = Asistencia::where('usu_id', $empleados->first()->usu_id)
                        ->whereMonth('fecha', $mes)
                        ->whereYear('fecha', $anio)
                        ->count();

                    $faltas = EmpleadoDetalle::where('id', $empleados->first()->id)
                        ->first()
                        ->contarFaltas($mes, $anio);

                    $asistenciasHora = AsistenciaTiempo::groupBy('asis_id')->orderBy('hora_ini', 'ASC')->get();
                    $atrasos         = 0;
                    foreach ($asistenciasHora as $asis) {
                        if (
                            date('m', strtotime($asis->asistencia->fecha)) == $mes
                            && date('Y', strtotime($asis->asistencia->fecha)) == $anio
                        ) {
                            if ($asis->hora_ini > $asis->usuario->detalle->departamento->hora_ini) {
                                $atrasos++;
                            }
                        }
                    }

                    $vacaciones = EmpleadoPermiso::where('tipo', 'vacacion')
                        ->where('usu_detalle_id', $empleados->first()->id)
                        ->where('estado', 'aprobado')
                        ->whereMonth('fecha_ini', $mes)
                        ->whereYear('fecha_ini', $anio)
                        ->count();

                    $permisos = EmpleadoPermiso::where('tipo', 'permiso')
                        ->where('usu_detalle_id', $empleados->first()->id)
                        ->where('estado', 'aprobado')
                        ->whereMonth('fecha_ini', $mes)
                        ->whereYear('fecha_ini', $anio)
                        ->count();
                }
            }
        } else {
            $empleados = EmpleadoDetalle::where('usu_id', Auth::user()->id)->get();
        }

        if (! $anio) {
            $anio = date('Y');
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

        // return view('backend.asistencias.index', compact('usu_detalle_id', 'mes', 'anio', 'oldYear', 'latestYear', 'diasDelMes', 'empleados'));

        $mes  = (int) $mes;
        $anio = (int) $anio;
        $data = [
            'asistencias' => $asistenciasUser,
            'faltas'      => $faltas,
            'atrasos'     => $atrasos,
            'vacaciones'  => $vacaciones,
            'permisos'    => $permisos,
        ];
        $pdf = PDF::loadView('reportes.asistencias', compact('mes', 'anio', 'oldYear', 'latestYear', 'diasDelMes', 'empleados', 'usu_detalle_id', 'data'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('pdf_asistencias.pdf');
    }
}
