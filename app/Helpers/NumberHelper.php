<?php


if (!function_exists('numero_literal')) {
    function numero_literal($numero)
    {
        $unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        $decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        $centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

        if ($numero == 0) {
            return 'cero';
        }

        if ($numero == 100) {
            return 'cien';
        }

        $literal = '';

        // Manejar centenas
        if ($numero >= 100) {
            $centena = intval($numero / 100);
            $literal .= $centenas[$centena] . ' ';
            $numero %= 100;
        }

        // Manejar decenas
        if ($numero >= 10 && $numero <= 29) {
            // Excepciones para 11-19 y "veinti..."
            $especiales = [
                10 => 'diez',
                11 => 'once',
                12 => 'doce',
                13 => 'trece',
                14 => 'catorce',
                15 => 'quince',
                16 => 'dieciséis',
                17 => 'diecisiete',
                18 => 'dieciocho',
                19 => 'diecinueve'
            ];

            if (array_key_exists($numero, $especiales)) {
                $literal .= $especiales[$numero];
                $numero = 0;
            } else {
                $literal .= 'veinti';
                $numero -= 20;
            }
        } elseif ($numero >= 30) {
            $decena = intval($numero / 10);
            $literal .= $decenas[$decena];
            $numero %= 10;

            if ($numero > 0) {
                $literal .= ' y ';
            }
        }

        // Manejar unidades
        if ($numero > 0) {
            $literal .= $unidades[$numero];
        }

        return trim($literal);
    }
}
