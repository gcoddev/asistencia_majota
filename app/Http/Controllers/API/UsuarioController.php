<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(string $ci)
    {
        $user = Usuario::where('ci', $ci)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "Usuario con CI: '$ci' no encontrado",
                'data' => [],
                'errors' => [
                    'ci' => "El CI proporcionado no es un usuario registrado",
                ],
            ], 404);
        }

        $detalle = $user->detalle
            ? [
                "num_pasaporte" => $user->detalle->num_pasaporte,
                "exp_pasaporte" => $user->detalle->exp_pasaporte,
                "tel_pasaporte" => $user->detalle->tel_pasaporte,
                "nacionalidad" => $user->detalle->nacionalidad,
                "genero" => $user->detalle->genero,
                "religion" => $user->detalle->religion,
                "etnia" => $user->detalle->etnia,
                "estado_civil" => $user->detalle->estado_civil,
                "ocupacion" => $user->detalle->ocupacion,
                "fecha_nacimiento" => $user->detalle->fecha_nacimiento,
                "fecha_ingreso" => $user->detalle->fecha_ingreso,
                "contacto_emergencia" => $user->detalle->contacto_emergencia
            ] : [];
        $departamento = $user->detalle && $user->detalle->departamento
            ? [
                "nombre" => $user->detalle->departamento->nombre,
                "descripcion" => $user->detalle->departamento->descripcion,
                "hora_ini" => $user->detalle->departamento->hora_ini,
                "hora_fin" => $user->detalle->departamento->fin,
                "latitud" => $user->detalle->departamento->latitud,
                "longitud" => $user->detalle->departamento->longitud
            ]
            : [];
        $designacion = $user->detalle && $user->detalle->designacion
            ? [
                "nombre" => $user->detalle->designacion->nombre,
                "descripcion" => $user->detalle->designacion->descripcion
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
            'data' => [
                'ci' => $user->ci,
                'nombres' => $user->nombres,
                'apellidos' => $user->apellidos,
                'imagen' => $user->imagen,
                'email' => $user->email,
                'direccion' => $user->direccion,
                'celular' => $user->celular,
                'activo' => $user->activo,
                'detalle' => [
                    ...$detalle,
                    'departamento' => $departamento,
                    'designacion' => $designacion,
                ],
            ],
            'errors' => $errors
        ], 200);
    }
}
