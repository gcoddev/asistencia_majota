@extends('layout')

@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Recibo</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Recibo</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <div class="btn-group btn-group-sm">
                        {{-- <button class="btn btn-white">CSV</button> --}}
                        <a href="{{ route('admin.sueldos.pdf', $sueldo->id) }}" class="btn btn-white" target="_blank">
                            PDF
                        </a>
                        <a href="{{ route('admin.sueldos.print', $sueldo->id) }}" class="btn btn-white" target="_blank">
                            <i class="fa fa-print fa-lg"></i> Imprimir
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row" id="recibo">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="payslip-title">Recibo del mes de {{ mes_literal($sueldo->fecha_recibo) }}</h4>
                        <div class="row">
                            <div class="col-sm-6 m-b-20">
                                <img src="{{ asset('assets/img/logo2.png') }}" class="inv-logo" alt="">
                                {{-- <ul class="list-unstyled mb-0">
                                    <li>Dreamguy's Technologies</li>
                                    <li>3864 Quiet Valley Lane,</li>
                                    <li>Sherman Oaks, CA, 91403</li>
                                </ul> --}}
                            </div>
                            <div class="col-sm-6 m-b-20">
                                <div class="invoice-details">
                                    <h3 class="text-uppercase">Recibo #{{ $sueldo->id }}</h3>
                                    <ul class="list-unstyled">
                                        <li>Sueldo de: <span>{{ fecha_literal($sueldo->fecha_recibo) }}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 m-b-20">
                                <ul class="list-unstyled">
                                    <li>
                                        <h5 class="mb-0">
                                            <strong style="font-size:1.3em">
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
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="m-b-10"><strong>Compensaciones (+)</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            @php
                                                $suma = 0;
                                            @endphp
                                            @foreach ($sueldo->compensaciones as $com)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $com->item->nombre }}</strong>
                                                        <span class="float-right">Bs. {{ $com->item->monto }}</span>
                                                    </td>
                                                </tr>
                                                @php
                                                    $suma += $com->item->monto;
                                                @endphp
                                            @endforeach

                                            <tr style="background-color:#00ff0033">
                                                <td>
                                                    <strong>{{ $suma > 0 ? 'Total' : 'Vacio' }}</strong>
                                                    <span class="float-right">Bs. {{ $suma }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="m-b-10"><strong>Deducciones (-)</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            @php
                                                $resta = 0;
                                            @endphp
                                            @foreach ($sueldo->deducciones as $ded)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $ded->item->nombre }}</strong>
                                                        <span class="float-right">Bs. {{ $ded->item->monto }}</span>
                                                    </td>
                                                </tr>
                                                @php
                                                    $resta += $ded->item->monto;
                                                @endphp
                                            @endforeach

                                            <tr style="background-color:#00ff0033">
                                                <td>
                                                    <strong>{{ $resta > 0 ? 'Total' : 'Vacio' }}</strong>
                                                    <span class="float-right">Bs. {{ $resta }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <p style="font-size:1.1em">
                                    <strong>Salario total: Bs {{ $sueldo->salario_total }}</strong>
                                    ({{ ucfirst(numero_literal($sueldo->salario_total)) }} bolivianos)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
@endsection
