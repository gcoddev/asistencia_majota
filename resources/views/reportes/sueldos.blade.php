<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sueldos</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
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
            padding: 8px 12px;
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

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
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

    <h2 style="text-align: center;">Reporte de sueldos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Rol</th>
                <th>Compensaciones</th>
                <th>Deducciones</th>
                <th>Total</th>
                <th>Tipo</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sueldos as $sue)
                <tr>
                    <td>
                        {{ $sue->empleado->usuario->nombres }} {{ $sue->empleado->usuario->apellidos }}
                    </td>
                    <td>{{ $sue->empleado->usuario->role[0]->name }}</td>
                    <td>
                        @if (count($sue->compensaciones) > 0)
                            <ul>
                                @foreach ($sue->compensaciones as $com)
                                    <li>
                                        <b>+ Bs. {{ $com->item->monto }}</b>
                                        {{ $com->item->nombre }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if (count($sue->deducciones) > 0)
                            <ul>
                                @foreach ($sue->deducciones as $ded)
                                    <li>
                                        <b>- Bs. {{ $ded->item->monto }}</b>
                                        {{ $ded->item->nombre }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                    <td>Bs. {{ $sue->salario_total }}</td>
                    <td>{{ $sue->tipo }}</td>
                    <td>{{ fecha_literal($sue->fecha_recibo) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
