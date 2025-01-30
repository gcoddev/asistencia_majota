<?php

if (!function_exists('fecha_literal')) {
    function fecha_literal($fecha)
    {
        if (!$fecha) {
            return '';
        }
        $meses = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre',
        ];

        $timestamp = strtotime($fecha);
        $dia = date('d', $timestamp);
        $mes = $meses[(int) date('m', $timestamp)];
        $anio = date('Y', $timestamp);

        return "{$dia} de {$mes} de {$anio}";
    }
}

if (!function_exists('mes_literal')) {
    function mes_literal($fecha)
    {
        if (!$fecha) {
            return '';
        }
        $meses = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre',
        ];

        $timestamp = strtotime($fecha);
        // $dia = date('d', $timestamp);
        $mes = $meses[(int) date('m', $timestamp)];
        $anio = date('Y', $timestamp);

        return "{$mes} de {$anio}";
    }
}

if (!function_exists('obtener_horas')) {
    function obtener_horas($hora1, $hora2)
    {
        if ($hora1 && $hora2) {
            $hora1 = DateTime::createFromFormat('H:i:s', $hora1);
            $hora2 = DateTime::createFromFormat('H:i:s', $hora2);
            // dd($hora1, $hora2);

            $diferencia = $hora1->diff($hora2);
            $totalSegundos = $diferencia->h * 3600 + $diferencia->i * 60 + $diferencia->s;
            $horasDecimal = $totalSegundos / 3600;

            return $horasDecimal;
        } else {
            return 0;
        }
    }
}

if (!function_exists('obtener_horas_segundos')) {
    function obtener_horas_segundos($horas)
    {
        if ($horas <= 0) {
            return 0;
        }

        $totalSegundos = ($horas / 8) * 8 * 3600;
        $horasResultado = floor($totalSegundos / 3600);
        $segundosRestantes = $totalSegundos % 3600;

        $minutosResultado = floor($segundosRestantes / 60);
        $segundosResultado = $segundosRestantes % 60;

        $horasResultado = ($horasResultado > 0) ? str_pad($horasResultado, 2, '0', STR_PAD_LEFT) . "h " : '';
        $minutosResultado = ($minutosResultado > 0) ? str_pad($minutosResultado, 2, '0', STR_PAD_LEFT) . "m " : '';
        $segundosResultado = ($segundosResultado > 0) ? str_pad($segundosResultado, 2, '0', STR_PAD_LEFT) . "s" : '';

        return $horasResultado . $minutosResultado . $segundosResultado;
    }
}
