<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\AsistenciaTiempo;
use App\Models\EmpleadoDetalle;
use App\Models\EmpleadoPermiso;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index(string $ci)
    {
        $user = Usuario::where('ci', $ci)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => "Usuario con CI: '$ci' no encontrado",
                'data'    => [],
                'errors'  => [
                    'ci' => "El CI proporcionado no es un usuario registrado",
                ],
            ], 404);
        }

        $detalle = $user->detalle
        ? [
            "num_pasaporte"       => $user->detalle->num_pasaporte,
            "exp_pasaporte"       => $user->detalle->exp_pasaporte,
            "tel_pasaporte"       => $user->detalle->tel_pasaporte,
            "nacionalidad"        => $user->detalle->nacionalidad,
            "genero"              => $user->detalle->genero,
            "religion"            => $user->detalle->religion,
            "etnia"               => $user->detalle->etnia,
            "estado_civil"        => $user->detalle->estado_civil,
            "ocupacion"           => $user->detalle->ocupacion,
            "fecha_nacimiento"    => $user->detalle->fecha_nacimiento,
            "fecha_ingreso"       => $user->detalle->fecha_ingreso,
            "contacto_emergencia" => $user->detalle->contacto_emergencia,
        ] : [];
        $departamento = $user->detalle && $user->detalle->departamento
        ? [
            "nombre"      => $user->detalle->departamento->nombre,
            "descripcion" => $user->detalle->departamento->descripcion,
            "hora_ini"    => $user->detalle->departamento->hora_ini,
            "hora_fin"    => $user->detalle->departamento->fin,
            "latitud"     => $user->detalle->departamento->latitud,
            "longitud"    => $user->detalle->departamento->longitud,
        ]
        : [];
        $designacion = $user->detalle && $user->detalle->designacion
        ? [
            "nombre"      => $user->detalle->designacion->nombre,
            "descripcion" => $user->detalle->designacion->descripcion,
        ]
        : [];

        $errors = [];
        if ($user->id != 1) {
            if ($detalle == []) {
                $errors['detalle'] = "El usuario no tiene detalle";
            }
            if ($departamento == []) {
                $errors['departamento'] = "El usuario no tiene 'departamento' asignado";
            }
            if ($designacion == []) {
                $errors['designacion'] = "El usuario no tiene 'designación' asignado";
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario encontrado!',
            'data'    => [
                'ci'        => $user->ci,
                'nombres'   => $user->nombres,
                'apellidos' => $user->apellidos,
                'imagen'    => $user->imagen,
                'email'     => $user->email,
                'direccion' => $user->direccion,
                'celular'   => $user->celular,
                'activo'    => $user->activo,
                'detalle'   => [
                     ...$detalle,
                    'departamento' => $departamento,
                    'designacion'  => $designacion,
                ],
            ],
            'errors'  => $errors,
        ], 200);
    }

    public function asistencia($ci, $mes = null, $anio = null)
    {
        $user    = Usuario::where('ci', $ci)->first();
        $detalle = EmpleadoDetalle::where('usu_id', $user->id)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => "Usuario con CI: '$ci' no encontrado",
                'data'    => [],
                'errors'  => [
                    'ci' => "El CI proporcionado no es un usuario registrado",
                ],
            ], 404);
        }
        if (! $detalle) {
            return response()->json([
                'success' => false,
                'message' => "Usuario no registrado como empleado",
                'data'    => [],
                'errors'  => [
                    'detalle' => "Usuario no es empleado",
                ],
            ], 404);
        }

        if (! $mes) {
            $mes = date('m');
        }
        if (! $anio) {
            $anio = date('Y');
        }

        $asistencias = Asistencia::where('usu_id', $user->id)
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->count();

        $faltas = EmpleadoDetalle::where('id', $detalle->id)
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
            ->where('usu_detalle_id', $detalle->id)
            ->where('estado', 'aprobado')
            ->whereMonth('fecha_ini', $mes)
            ->whereYear('fecha_ini', $anio)
            ->count();

        $permisos = EmpleadoPermiso::where('tipo', 'permiso')
            ->where('usu_detalle_id', $detalle->id)
            ->where('estado', 'aprobado')
            ->whereMonth('fecha_ini', $mes)
            ->whereYear('fecha_ini', $anio)
            ->count();

        $meses = [
            1  => 'Enero',
            2  => 'Febrero',
            3  => 'Marzo',
            4  => 'Abril',
            5  => 'Mayo',
            6  => 'Junio',
            7  => 'Julio',
            8  => 'Agosto',
            9  => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $mes  = (int) $mes;
        $anio = (int) $anio;
        return response()->json([
            'success' => true,
            'message' => "Información de asistencias mes de $meses[$mes] año $anio",
            'data'    => [
                'mes'   => $meses[$mes],
                'anio'  => $anio,
                'datos' => [
                    'asistencias' => $asistencias,
                    'faltas'      => $faltas,
                    'atrasos'     => $atrasos,
                    'vacaciones'  => $vacaciones,
                    'permisos'    => $permisos,
                ],
            ],
            'errors'  => [],
        ], 200);
    }
}
