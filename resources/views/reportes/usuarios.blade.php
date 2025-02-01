<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
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

    <h2 style="text-align: center;">Reporte de usuarios</h2>
    <table class="table">
        <thead>
            <tr>
                <th>CI</th>
                <th>Nombres</th>
                <th>Departamento</th>
                <th>Designación</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $user)
                <tr>
                    <td>{{ $user->ci }}</td>
                    <td>{{ $user->nombres }} {{ $user->apellidos }}</td>
                    <td>{{ $user->detalle->departamento->nombre ?? '-' }}
                    </td>
                    <td>{{ $user->detalle->designacion->nombre ?? '-' }}
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->celular ?? '-' }}</td>
                    <td>{{ $user->role[0]->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
