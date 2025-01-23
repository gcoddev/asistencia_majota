<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo #{{ $sueldo->id }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}"> --}}

    <!-- Lineawesome CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}"> --}}

    <!-- Chart CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}"> --}}

    <!-- Datatable CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}"> --}}

    <!-- Select2 CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}"> --}}

    <!-- Datetimepicker CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}"> --}}

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            background-color: white !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>

<body>
    <h4 class="payslip-title" style="text-align:left;margin-left:40px">Recibo del mes de {{ mes_literal($sueldo->fecha_recibo) }}</h4>
    <div class="row">
        <div class="col-6 m-b-20">
            <img src="{{ asset('assets/img/logo2.png') }}" class="inv-logo" alt="">
        </div>
        <div class="col-6 m-b-20">
            <div class="invoice-details">
                <h3 class="text-uppercase">Recibo #{{ $sueldo->id }}</h3>
                <ul class="list-unstyled">
                    <li>Sueldo de: <span>{{ fecha_literal($sueldo->fecha_recibo) }}</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 m-b-20">
            <ul class="list-unstyled">
                <li>
                    <h5 class="mb-0">
                        <strong>
                            {{ $sueldo->empleado->usuario->nombres }}
                            {{ $sueldo->empleado->usuario->apellidos }}
                        </strong>
                    </h5>
                </li>
                <li>
                    <span>
                        {{ $sueldo->empleado->designacion ? $sueldo->empleado->designacion->nombre : '- Sin designación -' }}
                    </span>
                </li>
                <li>
                    <span>
                        {{ $sueldo->empleado->designacion ? $sueldo->empleado->designacion->nombre : '- Sin designación -' }}
                    </span>
                </li>
                {{-- <li>Employee ID: FT-0009</li> --}}
                <li>Unido el: {{ fecha_literal($sueldo->empleado->usuario->created_at) }}</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div>
                <h4 class="m-b-10"><strong>Compensaciones</strong></h4>
                <table class="table table-bordered">
                    <tbody>
                        @foreach ($sueldo->compensaciones as $com)
                            <tr>
                                <td>
                                    <strong>{{ $com->item->nombre }}</strong>
                                    <span class="float-right">Bs.
                                        {{ $com->item->monto }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-6">
            <div>
                <h4 class="m-b-10"><strong>Deducciones</strong></h4>
                <table class="table table-bordered">
                    <tbody>
                        @foreach ($sueldo->deducciones as $ded)
                            <tr>
                                <td>
                                    <strong>{{ $ded->item->nombre }}</strong>
                                    <span class="float-right">Bs.
                                        {{ $ded->item->monto }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12">
            <p>
                <strong>Salario total: Bs {{ $sueldo->salario_total }}</strong>
                ({{ ucfirst(numero_literal($sueldo->salario_total)) }})
            </p>
        </div>
    </div>
</body>

</html>
