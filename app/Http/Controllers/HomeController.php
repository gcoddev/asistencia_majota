<?php

namespace App\Http\Controllers;

use App\Models\AsistenciaTiempo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()->role[0]->name == 'admin') {
            return view('backend.dashboard');
        } else {
            // $usu_id = Auth::user()->id;
            // $asistencias = AsistenciaTiempo::where('usu_id', $usu_id)->orderBy('id', 'desc')->get();



            // // Horas semana
            // $inicioSemana = Carbon::now()->startOfWeek();
            // $finSemana = Carbon::now()->endOfWeek();
            // $asistenciasSemana = AsistenciaTiempo::whereHas('asistencia', function ($query) use ($inicioSemana, $finSemana, $usu_id) {
            //     $query->where('usu_id', $usu_id)
            //         ->whereBetween('fecha', [$inicioSemana, $finSemana]);
            // })->get();
            // $horasSemana = $this->calcularHorasTotales($asistenciasSemana);



            // // Horas mes
            // $inicioMes = Carbon::now()->startOfMonth();
            // $finMes = Carbon::now()->endOfMonth();

            // $asistenciasMes = AsistenciaTiempo::whereHas('asistencia', function ($query) use ($inicioMes, $finMes, $usu_id) {
            //     $query->where('usu_id', $usu_id)
            //         ->whereBetween('fecha', [$inicioMes, $finMes]);
            // })->get();
            // $horasMes = $this->calcularHorasTotales($asistenciasMes);



            // $mes = $mes ?? Carbon::now()->month;
            // $anio = $anio ?? Carbon::now()->year;

            // $inicioMes = Carbon::create($anio, $mes, 1);
            // $finMes = $inicioMes->copy()->endOfMonth();



            // // Totales
            // $horasTotalesSemana = 40;
            // $horasTotalesMes = 0;

            // $dias = $inicioMes->daysInMonth;
            // for ($dia = 1; $dia <= $dias; $dia++) {
            //     $fecha = Carbon::create($anio, $mes, $dia);

            //     if ($fecha->isWeekday()) {
            //         $horasTotalesMes += 8;
            //     }
            // }

            // return view(
            //     'backend.inicio',
            //     compact(
            //         'horasSemana',
            //         'horasMes',
            //         'horasTotalesSemana',
            //         'horasTotalesMes',
            //         'asistencias'
            //     )
            // );
            return view('backend.inicio');
        }
    }

    private function calcularHorasTotales($asistencias)
    {
        $totalSegundos = 0;

        foreach ($asistencias as $asistencia) {
            if ($asistencia->hora_ini && $asistencia->hora_fin) {
                $horaIni = Carbon::parse($asistencia->hora_ini);
                $horaFin = Carbon::parse($asistencia->hora_fin);

                $totalSegundos += $horaIni->diffInSeconds($horaFin);
            }
        }

        $horas = $totalSegundos / 3600;
        return $horas;
    }
}
