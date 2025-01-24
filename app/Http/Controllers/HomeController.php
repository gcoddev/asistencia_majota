<?php

namespace App\Http\Controllers;

use App\Models\AsistenciaTiempo;
use App\Models\EmpleadoDetalle;
use App\Models\EmpleadoPermiso;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()->role[0]->name == 'admin') {
            $usuarios = Usuario::where('activo', true)->count();
            $asistentes = AsistenciaTiempo::groupBy('usu_id')->count();
            $permisos = EmpleadoPermiso::where('tipo', 'permiso')->count();
            $vacaciones = EmpleadoPermiso::where('tipo', 'vacacion')->count();
            $asistenciasHora = AsistenciaTiempo::groupBy('asis_id')->orderBy('hora_ini', 'ASC')->get();
            $atrasos = 0;
            foreach ($asistenciasHora as $asis) {
                if ($asis->hora_ini > '08:00:00') {
                    $atrasos++;
                }
            }
            $faltas = 0;
            $empleados = EmpleadoDetalle::get();
            foreach ($empleados as $empleado) {
                $faltas += $empleado->contarFaltas();
            }

            return view('backend.dashboard', compact('usuarios', 'asistentes', 'permisos', 'vacaciones', 'atrasos', 'faltas'));
        } else {
            return view('backend.inicio');
        }
    }
}
