<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpleadoDetalle extends Model
{
    protected $table = 'empleado_detalles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usu_id',
        'dep_id',
        'des_id',
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usu_id');
    }

    public function departamento()
    {
        return $this->hasOne(Departamento::class, 'id', 'dep_id');
    }

    public function designacion()
    {
        return $this->hasOne(Designacion::class, 'id', 'des_id');
    }

    public function salario()
    {
        return $this->hasOne(EmpleadoSalario::class, 'usu_detalle_id', 'id');
    }

    public function compensaciones()
    {
        return $this->hasMany(EmpleadoDescuentoCompensacion::class, 'usu_detalle_id', 'id')
            ->where('tipo', 'compensacion')->with('items');
    }

    public function deducciones()
    {
        return $this->hasMany(EmpleadoDescuentoCompensacion::class, 'usu_detalle_id', 'id')
            ->where('tipo', 'deduccion')->with('items');
    }

    public function asistenciaDia($dia, $mes, $anio)
    {
        $fechaEspecifica = Carbon::create($anio, $mes, $dia);

        return $this->hasOne(Asistencia::class, 'usu_id', 'usu_id')
            ->whereDate('fecha', $fechaEspecifica);
    }

    public function asistencias()
    {
        $usu_id = $this->usu_id;
        return AsistenciaTiempo::where('usu_id', $usu_id)->orderBy('id', 'desc')->get();
    }

    public function buscarAsistencia($dia, $mes, $anio)
    {
        $fecha = Carbon::create($anio, $mes, $dia);
        return Asistencia::where('usu_id', $this->usu_id)->where('fecha', $fecha)->first();
    }

    public function horasSemana()
    {
        $usu_id = $this->usu_id;

        // Obtener el inicio y fin de la semana actual
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();

        // Filtrar las asistencias de la semana utilizando la relación
        $asistenciasSemana = AsistenciaTiempo::where('usu_id', $usu_id)
            ->whereHas('asistencia', function ($query) use ($inicioSemana, $finSemana) {
                $query->whereBetween('fecha', [$inicioSemana, $finSemana]);
            })
            ->get();

        // Calcular y devolver las horas totales de la semana
        return $this->calcularHorasTotales($asistenciasSemana);
    }


    // Calcular horas totales del mes
    public function horasMes()
    {
        $usu_id = $this->usu_id;

        // Obtener el inicio y fin del mes actual
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        // Filtrar las asistencias del mes utilizando la relación 'asistencia'
        $asistenciasMes = AsistenciaTiempo::where('usu_id', $usu_id)
            ->whereHas('asistencia', function ($query) use ($inicioMes, $finMes) {
                $query->whereBetween('fecha', [$inicioMes, $finMes]);
            })
            ->get();

        // Calcular y devolver las horas totales del mes
        return $this->calcularHorasTotales($asistenciasMes);
    }


    // Calcular horas totales en segundos
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

        return $totalSegundos / 3600; // De segundos a horas
    }

    public function horasTotalesSemana()
    {
        return 40;
    }

    // Calcular el total de horas laborales de un mes
    public function horasTotalesMes($anio = null, $mes = null)
    {
        $anio = $anio ?? Carbon::now()->year;
        $mes = $mes ?? Carbon::now()->month;

        $inicioMes = Carbon::create($anio, $mes, 1);
        $finMes = $inicioMes->copy()->endOfMonth();

        $horasTotalesMes = 0;

        $dias = $inicioMes->daysInMonth;
        for ($dia = 1; $dia <= $dias; $dia++) {
            $fecha = Carbon::create($anio, $mes, $dia);

            if ($fecha->isWeekday()) {
                $horasTotalesMes += 8; // Asumiendo 8 horas por día laborable
            }
        }

        return $horasTotalesMes;
    }

    public function horas($fecha)
    {
        $hrs = 0;
        foreach ($this->asistencias() as $asistencia) {
            if ($asistencia->asistencia->fecha == $fecha) {
                if ($asistencia->hora_ini != '' && $asistencia->hora_fin != '') {
                    $hrs += obtener_horas($asistencia->hora_ini, $asistencia->hora_fin);
                }
            }
        }

        return $hrs;
    }

    public function contarFaltas()
    {
        $usuario_id = $this->usu_id;

        $primeraAsistencia = Asistencia::where('usu_id', $usuario_id)
            ->min('fecha');

        if (!$primeraAsistencia) {
            return 0;
        }

        $fechaInicio = Carbon::parse($primeraAsistencia);
        $fechaFinal = Carbon::now();

        $horaEntrada = $this->departamento->hora_ini;
        $horaSalida = $this->departamento->hora_fin;

        $faltas = 0;

        for ($fecha = $fechaInicio; $fecha->lte($fechaFinal); $fecha->addDay()) {
            if ($fecha->isWeekend()) {
                continue;
            }

            $asistencia = Asistencia::where('usu_id', $usuario_id)
                ->where('fecha', $fecha->format('Y-m-d'))
                ->first();

            if (!$asistencia && Carbon::now()->gt(Carbon::parse($fecha->format('Y-m-d') . ' ' . $horaSalida))) {
                $faltas++;
            }
        }

        return $faltas;
    }
}
