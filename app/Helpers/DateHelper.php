<?php

if (!function_exists('fecha_literal')) {
    function fecha_literal($fecha)
    {
        if (!$fecha) {
            return '';
        }

        // $meses = [
        //     1 => 'ene',
        //     2 => 'feb',
        //     3 => 'mar',
        //     4 => 'abr',
        //     5 => 'may',
        //     6 => 'jun',
        //     7 => 'jul',
        //     8 => 'ago',
        //     9 => 'sep',
        //     10 => 'oct',
        //     11 => 'nov',
        //     12 => 'dic',
        // ];
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
