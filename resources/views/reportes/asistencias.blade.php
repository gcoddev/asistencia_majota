<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Permisos</title>
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .header {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header td {
            padding: 0;
        }

        .header .logo {
            height: 40px;
        }

        .header .date {
            text-align: right;
            vertical-align: middle;
            font-size: 12px;
            color: #495057;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
        }

        .table th,
        .table td {
            padding: 8px 8px;
            text-align: left;
        }

        .table th {
            background-color: #f8f9fa;
            color: #495057;
        }

        .table td {
            background-color: #ffffff;
        }

        .table tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

        .table tr:hover td {
            background-color: #e9ecef;
        }

        p {
            text-align: center;
            margin: 5px auto;
        }

        .text-success {
            color: #55CE63;
        }

        .text-danger {
            color: #F62D51;
        }
    </style>
</head>

<body>
    @php
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];
    @endphp

    <table class="header">
        <tr>
            <td class="logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="majota" style="width: 100px; height: auto;">
            </td>
            <td class="date">
                {{ fecha_literal(\Carbon\Carbon::now()->format('d/m/Y')) }}
            </td>
        </tr>
    </table>

    <h2>Reporte de asistencias</h2>
    <p>
        <b>Mes:</b>
        {{ $meses[$mes] }}
    </p>
    <p>
        <b>Año:</b>
        {{ $anio }}
    </p>
    <table class="table">
        <thead>
            <tr>
                <th>Empleado</th>
                @foreach ($diasDelMes as $dia)
                    <th>{{ $dia }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $emp)
                @if ($usu_detalle_id == '' || $usu_detalle_id == $emp->id)
                    <tr>
                        <td>
                            {{ $emp->usuario->nombres }} {{ $emp->usuario->apellidos }}
                        </td>
                        @foreach ($diasDelMes as $dia)
                            @if ($emp->buscarAsistencia($dia, $mes, $anio))
                                <td>
                                    <i class="fa fa-check text-success"></i>
                                </td>
                            @else
                                <td>
                                    <i class="fa fa-close text-danger"></i>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
<br>
    @if ($usu_detalle_id)
        <p>
            <b>Asistencias:</b>
            {{ $data['asistencias'] }}
        </p>
        <p>
            <b>Faltas:</b>
            {{ $data['faltas'] }}
        </p>
        <p>
            <b>Atrasos:</b>
            {{ $data['atrasos'] }}
        </p>
        <p>
            <b>Vacaciones:</b>
            {{ $data['vacaciones'] }}
        </p>
        <p>
            <b>Permisos:</b>
            {{ $data['permisos'] }}
        </p>
    @endif
</body>

</html>
