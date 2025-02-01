@extends('layout2')

@section('content2')
    <div class="content container-fluid">
        <div class="row">
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
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="m-b-10"><strong>Compensaciones</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            @foreach ($sueldo->compensaciones as $com)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $com->item->nombre }}</strong>
                                                        <span class="float-right">Bs. {{ $com->item->monto }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="m-b-10"><strong>Deducciones</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            @foreach ($sueldo->deducciones as $ded)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $ded->item->nombre }}</strong>
                                                        <span class="float-right">Bs. {{ $ded->item->monto }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <p>
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
@endsection

@push('styles')
    <style>
        @media print {
            .no-print {
                display: none;
            }

            @page {
                size: landscape;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        window.onload = function() {
            window.print();
            // window.close();
        };
    </script>
@endpush
