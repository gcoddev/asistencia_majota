@extends('layout')

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-md-8 col-12">
                    <h3 class="page-title">Asistencias</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('inicio') }}">Panel</a>
                        </li>
                        <li class="breadcrumb-item active">Asistencias</li>
                    </ul>
                </div>
                <div class="col-md-4 col-12">
                    <div class="row">
                        <div class="col-6">
                            <i class="fa fa-check text-success"></i>
                            Asiste
                        </div>
                        <div class="col-6">
                            <i class="fa fa-close text-danger"></i>
                            Falta
                        </div>
                        <div class="col-6">
                            <i class="fa fa-check text-info"></i>
                            Atraso
                        </div>
                        <div class="col-6">
                            <i class="fa fa-check text-warning"></i>
                            Observación
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <form class="row filter-row" action="{{ route('admin.asistencias.index') }}" method="GET">
            <div class="col-sm-12 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" name="usu_detalle_id">
                        <option value="">-</option>
                        @foreach ($empleados as $em)
                            <option value="{{ $em->id }}" {{ $em->id == $usu_detalle_id ? 'selected' : '' }}>
                                {{ $em->usuario->nombres }}
                                {{ $em->usuario->apellidos }}
                            </option>
                        @endforeach
                    </select>
                    <label class="focus-label">Nombre de empleado</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" name="mes">
                        <option value="">-</option>
                        <option value="1" {{ $mes == 1 ? 'selected' : '' }}>Enero</option>
                        <option value="2" {{ $mes == 2 ? 'selected' : '' }}>Febrero</option>
                        <option value="3" {{ $mes == 3 ? 'selected' : '' }}>Marzo</option>
                        <option value="4" {{ $mes == 4 ? 'selected' : '' }}>Abril</option>
                        <option value="5" {{ $mes == 5 ? 'selected' : '' }}>Mayo</option>
                        <option value="6" {{ $mes == 6 ? 'selected' : '' }}>Junio</option>
                        <option value="7" {{ $mes == 7 ? 'selected' : '' }}>Julio</option>
                        <option value="8" {{ $mes == 8 ? 'selected' : '' }}>Agosto</option>
                        <option value="9" {{ $mes == 9 ? 'selected' : '' }}>Septiembre</option>
                        <option value="10" {{ $mes == 10 ? 'selected' : '' }}>Octubre</option>
                        <option value="11" {{ $mes == 11 ? 'selected' : '' }}>Noviembre</option>
                        <option value="12" {{ $mes == 12 ? 'selected' : '' }}>Diciembre</option>
                    </select>
                    <label class="focus-label">Seleccionar mes</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" name="anio">
                        <option>-</option>
                        @for ($i = $oldYear; $i <= $latestYear; $i++)
                            <option value="{{ $i }}" {{ $i == $anio ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    <label class="focus-label">Seleccionar año</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <button type="submit" class="btn btn-success btn-block"> Buscar </button>
            </div>
            <div class="col-sm-6 col-md-2">
                <a href="{{ route('admin.asistencias.index') }}" class="btn btn-secondary btn-block"> Reset </a>
            </div>
        </form>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
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
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a class="avatar avatar-xs"
                                                    href="{{ route('admin.perfil.show', $emp->usu_id) }}">
                                                    <img alt=""
                                                        src="{{ asset($emp->usuario->imagen ?? 'assets/img/user.jpg') }}">
                                                </a>
                                                <a href="{{ route('admin.perfil.show', $emp->usu_id) }}">
                                                    {{ $emp->usuario->nombres }}
                                                    {{ $emp->usuario->apellidos }}
                                                </a>
                                            </h2>
                                        </td>
                                        @foreach ($diasDelMes as $dia)
                                            @if ($emp->asistenciaDia($dia, $mes, $anio)->first())
                                                @if ($emp->asistenciaDia($dia, $mes, $anio)->first()->asistencias[0]->hora_ini <= '08:00:00')
                                                    <td>
                                                        <a href="javascript:void(0);" data-toggle="modal"
                                                            data-target="#attendance_info_{{ $emp->id }}"
                                                            title="Asiste">
                                                            <i class="fa fa-check text-success"></i>
                                                        </a>
                                                    </td>
                                                @else
                                                    <td>
                                                        <a href="javascript:void(0);" data-toggle="modal"
                                                            data-target="#attendance_info_{{ $emp->id }}"
                                                            title="Atraso">
                                                            <i class="fa fa-check text-info"></i>
                                                        </a>
                                                    </td>
                                                @endif

                                                <!-- Attendance Modal -->
                                                <div class="modal custom-modal fade"
                                                    id="attendance_info_{{ $emp->id }}" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Información de asistencia</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="card punch-status">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title">Horas <small
                                                                                        class="text-muted">
                                                                                        {{ fecha_literal($emp->buscarAsistencia($dia, $mes, $anio)->fecha) }}
                                                                                    </small></h5>
                                                                                <div class="punch-det">
                                                                                    <h6>Entrada</h6>
                                                                                    <p>
                                                                                        {{ $emp->buscarAsistencia($dia, $mes, $anio)->asistencias->first()->hora_ini }}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="punch-info">
                                                                                    <div class="punch-hours">
                                                                                        <span>{{ obtener_horas_segundos($emp->horas($emp->buscarAsistencia($dia, $mes, $anio)->fecha)) }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="punch-det">
                                                                                    <h6>Salida</h6>
                                                                                    <p>
                                                                                        @php
                                                                                            $fin = '-';
                                                                                            foreach (
                                                                                                $emp
                                                                                                    ->buscarAsistencia(
                                                                                                        $dia,
                                                                                                        $mes,
                                                                                                        $anio,
                                                                                                    )
                                                                                                    ->asistencias->reverse()
                                                                                                as $asis
                                                                                            ) {
                                                                                                if ($asis->hora_fin) {
                                                                                                    $fin =
                                                                                                        $asis->hora_fin;
                                                                                                    break;
                                                                                                }
                                                                                            }
                                                                                        @endphp
                                                                                        {{ $fin }}
                                                                                    </p>
                                                                                </div>
                                                                                {{-- <div class="statistics">
                                                                                    <div class="row">
                                                                                        <div
                                                                                            class="col-md-6 col-6 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>Break</p>
                                                                                                <h6>1.21 hrs</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="col-md-6 col-6 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>Overtime</p>
                                                                                                <h6>3 hrs</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card recent-activity">
                                                                            <div class="card-body activity-wrapper">
                                                                                <h5 class="card-title">Actividad de hoy
                                                                                </h5>
                                                                                <ul class="res-activity-list">
                                                                                    @if ($emp->buscarAsistencia($dia, $mes, $anio))
                                                                                        @foreach ($emp->buscarAsistencia($dia, $mes, $anio)->asistencias->reverse() as $asis)
                                                                                            @if ($asis->hora_fin != null)
                                                                                                <li>
                                                                                                    <p class="mb-0">
                                                                                                        Salida</p>
                                                                                                    <p
                                                                                                        class="res-activity-time">
                                                                                                        <i
                                                                                                            class="fa fa-clock-o"></i>
                                                                                                        {{ $asis->hora_fin }}
                                                                                                    </p>
                                                                                                </li>
                                                                                            @endif
                                                                                            <li>
                                                                                                <p class="mb-0">Entrada
                                                                                                </p>
                                                                                                <p
                                                                                                    class="res-activity-time">
                                                                                                    <i
                                                                                                        class="fa fa-clock-o"></i>
                                                                                                    {{ $asis->hora_ini }}
                                                                                                </p>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /Attendance Modal -->
                                            @else
                                                <td>
                                                    <i class="fa fa-close text-danger" title="Falta"></i>
                                                </td>
                                            @endif
                                        @endforeach
                                        {{-- <td>
                                        <div class="half-day">
                                            <span class="first-off"><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#attendance_info"><i
                                                        class="fa fa-check text-success"></i></a></span>
                                            <span class="first-off"><i class="fa fa-close text-danger"></i></span>
                                        </div>
                                    </td>

                                    <td><i class="fa fa-close text-danger"></i> </td>
                                </tr> --}}
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
@endsection
