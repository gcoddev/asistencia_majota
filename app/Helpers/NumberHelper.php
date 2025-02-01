<?php

if (! function_exists('numero_literal')) {
    function numero_literal($numero)
    {
        if ($numero == 0) {
            return 'cero';
        }

        $unidades   = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        $decenas    = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        $centenas   = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
        $especiales = [
            10 => 'diez', 11   => 'once', 12      => 'doce', 13       => 'trece', 14     => 'catorce',
            15 => 'quince', 16 => 'dieciséis', 17 => 'diecisiete', 18 => 'dieciocho', 19 => 'diecinueve',
        ];

        $literal = '';

        if ($numero >= 1000000) {
            $millones = intval($numero / 1000000);
            $literal .= ($millones == 1) ? 'un millón ' : numero_literal($millones) . ' millones ';
            $numero %= 1000000;
        }

        if ($numero >= 1000) {
            $miles = intval($numero / 1000);
            $literal .= ($miles == 1) ? 'mil ' : numero_literal($miles) . ' mil ';
            $numero %= 1000;
        }

        if ($numero == 100) {
            $literal .= 'cien';
        } elseif ($numero >= 100) {
            $centena = intval($numero / 100);
            $literal .= $centenas[$centena] . ' ';
            $numero %= 100;
        }

        if ($numero >= 10 && $numero <= 19) {
            $literal .= $especiales[$numero];
            $numero = 0;
        } elseif ($numero >= 20) {
            $decena = intval($numero / 10);
            $literal .= $decenas[$decena];
            $numero %= 10;
            if ($numero > 0) {
                $literal .= ' y ';
            }
        }

        if ($numero > 0) {
            $literal .= $unidades[$numero];
        }

        return trim($literal);
    }
}
