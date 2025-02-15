@extends('layout')

@section('content')
    @php
        $usr = Auth::user();
        $user = Auth::user()->detalle;
        $horas = $user->horas(date('Y-m-d'));
        $porcentaje = ($horas / 8) * 100;
        $porcentajeSemana = ($user->horasSemana() / $user->horasTotalesSemana()) * 100;
        $porcentajeMes = ($user->horasMes() / $user->horasTotalesMes()) * 100;
    @endphp
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Asistencia</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Asistencia</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        @include('components.alerts')

        <div class="row">
            <div class="col-md-4">
                <div class="card punch-status">
                    <div class="card-body">
                        <h5 class="card-title">
                            <div class="row">
                                <div class="col-8">
                                    Horas<br>
                                    <small class="text-muted">{{ fecha_literal(date('Y-m-d')) }}</small>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex">
                                        <span id="spanTimer"></span>
                                    </div>
                                </div>
                            </div>
                        </h5>
                        <div class="punch-info">
                            <div
                                class="punch-hours {{ $usr->asistencia ? ($usr->asistencia->asistencias->last()->hora_fin ? 'border-success' : 'border-warning') : '' }}">
                                <span id="timer">{{ $horas > 0 ? obtener_horas_segundos($horas) : '00s' }}</span>
                            </div>
                        </div>
                        @if ($usr->asistencia && $usr->asistencia->asistencias->last()->hora_fin)
                            <div class="alert alert-{{ $horas >= 8 ? 'success' : 'warning' }}">
                                {{ $horas >= 8 ? 'Horas cumplidas' : 'Horas faltantes' }}
                            </div>
                        @endif
                        <div class="punch-btn-section">
                            @if ($user->departamento)
                                <button type="button" class="btn btn-primary punch-btn" data-toggle="modal"
                                    data-target="#modal_marcar">
                                    Marcar
                                    {{ $usr->asistencia && $usr->asistencia->asistencias->last()->hora_ini != null ? 'salida' : 'entrada' }}
                                </button>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    No puede marcar asistencia por que no tiene un departamento asignado, solicita al
                                    personal la asignación de un departamento
                                    respectivo.
                                </div>
                            @endif
                        </div>

                        @if ($usr->asistencia && $usr->asistencia->asistencias->last()->hora_fin == null)
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <div class="stats-box">
                                            <p>Entrada</p>
                                            <h6 id="hora-ini">{{ $usr->asistencia->asistencias->last()->hora_ini }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card att-statistics">
                    <div class="card-body">
                        @if ($user->departamento)
                            <h5 class="card-title text-center">{{ $user->departamento->nombre }}</h5>
                            <div class="row">
                                <div class="col-6 text-center">
                                    <p>
                                        Entrada<br>
                                        <span class="text-muted">{{ $user->departamento->hora_ini }}</span>
                                    </p>
                                </div>
                                <div class="col-6 text-center">
                                    <p>
                                        Salida<br>
                                        <span class="text-muted">{{ $user->departamento->hora_fin }}</span>
                                    </p>
                                </div>
                            </div>
                        @else
                            <h5 class="card-title text-center">Sin departamento</h5>
                        @endif
                    </div>
                </div>
                <div class="card att-statistics">
                    <div class="card-body">
                        <h5 class="card-title">Resumen</h5>
                        <div class="stats-list">
                            <div class="stats-info">
                                <p>Hoy <strong>{{ obtener_horas_segundos($horas) }} <small>/ 8 hrs</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $porcentaje }}%" aria-valuenow="{{ $porcentaje }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Esta semana
                                    <strong>
                                        {{ obtener_horas_segundos($user->horasSemana()) }}
                                        <small>/{{ obtener_horas_segundos($user->horasTotalesSemana()) }}</small>
                                    </strong>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar"
                                        style="width: {{ $porcentajeSemana }}%" aria-valuenow="{{ $porcentajeSemana }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Este mes
                                    <strong>
                                        {{ obtener_horas_segundos($user->horasMes()) }}
                                        <small>/{{ obtener_horas_segundos($user->horasTotalesMes()) }}</small>
                                    </strong>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: {{ $porcentajeMes }}%" aria-valuenow="{{ $porcentajeMes }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            {{-- <div class="stats-info">
                                <p>Remaining <strong>90 <small>/ 160 hrs</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 62%"
                                        aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Overtime <strong>4</strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 22%"
                                        aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card recent-activity">
                    <div class="card-body activity-wrapper">
                        <h5 class="card-title">Actividad de hoy</h5>
                        <ul class="res-activity-list">
                            @if ($usr->asistencia)
                                @foreach ($usr->asistencia->asistencias->reverse() as $asis)
                                    @if ($asis->hora_fin != null)
                                        <li>
                                            <p class="mb-0">Salida</p>
                                            <p class="res-activity-time">
                                                <i class="fa fa-clock-o"></i>
                                                {{ $asis->hora_fin }}
                                            </p>
                                        </li>
                                    @endif
                                    <li>
                                        <p class="mb-0">Entrada</p>
                                        <p class="res-activity-time">
                                            <i class="fa fa-clock-o"></i>
                                            {{ $asis->hora_ini }}
                                        </p>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <p class="mb-0">Falta</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Filter -->
        {{-- <div class="row filter-row">
            <div class="col-sm-3">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input type="text" class="form-control floating datetimepicker">
                    </div>
                    <label class="focus-label">Date</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>-</option>
                        <option>Jan</option>
                        <option>Feb</option>
                        <option>Mar</option>
                        <option>Apr</option>
                        <option>May</option>
                        <option>Jun</option>
                        <option>Jul</option>
                        <option>Aug</option>
                        <option>Sep</option>
                        <option>Oct</option>
                        <option>Nov</option>
                        <option>Dec</option>
                    </select>
                    <label class="focus-label">Select Month</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>-</option>
                        <option>2019</option>
                        <option>2018</option>
                        <option>2017</option>
                        <option>2016</option>
                        <option>2015</option>
                    </select>
                    <label class="focus-label">Select Year</label>
                </div>
            </div>
            <div class="col-sm-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div> --}}
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha </th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Tiempo</th>
                                {{-- <th>Descanso</th> --}}
                                <th>Nota</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $fecha = '';
                                $entrada = '';
                            @endphp
                            @foreach ($user->asistencias() as $asis)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ fecha_literal($asis->asistencia->fecha) }}</td>
                                    <td>{{ $asis->hora_ini }}</td>
                                    <td>{{ $asis->hora_fin ?? '-' }}</td>
                                    <td>
                                        @if ($asis->hora_ini && $asis->hora_fin)
                                            {{ obtener_horas_segundos(obtener_horas($asis->hora_ini, $asis->hora_fin)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    {{-- @if ($fecha == $asis->asistencia->fecha)
                                        <td>{{ obtener_horas_segundos(obtener_horas($asis->hora_fin, $entrada)) }}</td>
                                        @php
                                            $entrada = $asis->hora_ini;
                                        @endphp
                                    @else
                                        <td>-</td>
                                        @php
                                            $fecha = $asis->asistencia->fecha;
                                            $entrada = $asis->hora_ini;
                                        @endphp
                                    @endif --}}
                                    <td>
                                        @if ($asis->note)
                                            {{ $asis->note }}
                                            <br>
                                            <span
                                                class="badge bg-{{ $asis->estado === null ? 'info' : ($asis->estado ? 'success' : 'danger') }} text-white">
                                                {{ $asis->estado === null ? 'Pendiente' : ($asis->estado ? 'Aprobado' : 'Rechazado') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $currentDate = now()->format('Y-m-d');
                                            $asistenciaDate = $asis->asistencia->fecha;
                                        @endphp

                                        @if ($asis->hora_fin == null && $currentDate > $asistenciaDate)
                                            @if ($asis->note == null)
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                    data-target="#modal_note"
                                                    onclick="$('#note_id').val({{ $asis->id }})">
                                                    Motivo de no salida
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <div class="modal custom-modal fade" id="modal_marcar" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="form-asistencia">
                        @csrf
                        <input type="hidden" name="asis_id" id="asis_id" value="{{ $usr->asistencia->id ?? '' }}">
                        <input type="hidden" name="hora_id" id="hora_id"
                            value="{{ $usr->asistencia && $usr->asistencia->asistencias->last()->hora_ini != null ? $usr->asistencia->asistencias->last()->id : '' }}">
                        <div class="form-header">
                            <h3>
                                Marcar
                                {{ $usr->asistencia && $usr->asistencia->asistencias->last()->hora_ini != null ? 'salida' : 'entrada' }}
                            </h3>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0)" class="btn btn-primary continue-btn"
                                        onclick="$('#form-asistencia').submit()">
                                        {{ $usr->asistencia && $usr->asistencia->asistencias->last()->hora_ini != null ? 'Salida' : 'Entrada' }}
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal"
                                        class="btn btn-primary cancel-btn">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_note" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Motivo de no asistencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-note">
                        @csrf
                        <input type="hidden" name="note_id" id="note_id">
                        <div class="form-group col-12">
                            <label>Motivo <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="note" id="note">
                            <span class="invalid-feedback" id="note_error"></span>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            setInterval(time, 1000);
            const horaIni = $('#hora-ini').text();
            if (horaIni) {
                let inicioSegundos = convertirAHorasASegundos(horaIni);
                setInterval(() => actualizarTimer(inicioSegundos), 1000);
            }

            // Enviar formulario
            $('#form-asistencia').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('hora', $('#spanTimer').text());

                const id = $('#asis_id').val();
                if (id != '') {
                    formData.append('_method', 'PUT');
                    $('#title-form').text('salida')
                } else {
                    $('#title-form').text('entrada')
                }

                const url = id ?
                    `{{ url('admin/asistencias') }}/${id}` :
                    '{{ route('admin.asistencias.store') }}';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        for (let campo in errors) {
                            let errorField = $(`#${campo}`);
                            errorField.addClass('is-invalid');
                            $(`#${campo}_error`).text(errors[campo][0]);
                        }
                    }
                });
            });
            $('#form-note').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                const id = $('#note_id').val();
                formData.append('_method', 'PUT');
                const url = `{{ url('admin/asistencias/nota') }}/${id}`

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        for (let campo in errors) {
                            let errorField = $(`#${campo}`);
                            errorField.addClass('is-invalid');
                            $(`#${campo}_error`).text(errors[campo][0]);
                        }
                    }
                });
            });
        });

        function actualizarTimer(inicioSegundos) {
            const ahoraSegundos = convertirAHorasASegundos(obtenerHoraActual()); // Hora actual en segundos
            const totalSegundos = ahoraSegundos - inicioSegundos; // Segundos transcurridos

            // Si los segundos son negativos, no mostrar nada (por ejemplo, si la hora inicial no es válida)
            if (totalSegundos < 0) {
                $('#timer').text('-');
                return;
            }

            const horas = Math.floor(totalSegundos / 3600); // Horas completas
            const minutos = Math.floor((totalSegundos % 3600) / 60); // Minutos restantes
            const segundos = totalSegundos % 60; // Segundos restantes

            // Crear el formato dinámico
            let formato = '';
            if (horas > 0) formato += `${horas.toString().padStart(2, '0')}h `;
            if (minutos > 0 || horas > 0) formato += `${minutos.toString().padStart(2, '0')}m `;
            formato += `${segundos.toString().padStart(2, '0')}s`;

            $('#timer').text(formato.trim());
        }

        function convertirAHorasASegundos(hora) {
            if (!hora) return 0;
            const [h, m, s] = hora.split(':').map(Number);
            return h * 3600 + m * 60 + s;
        }

        function obtenerHoraActual() {
            const d = new Date();
            const h = d.getHours().toString().padStart(2, '0');
            const m = d.getMinutes().toString().padStart(2, '0');
            const s = d.getSeconds().toString().padStart(2, '0');
            return `${h}:${m}:${s}`;
        }

        function time() {
            var span = $('#spanTimer');
            var d = new Date();

            var h = d.getHours().toString().padStart(2, '0');
            var m = d.getMinutes().toString().padStart(2, '0');
            var s = d.getSeconds().toString().padStart(2, '0');

            span.text(`${h}:${m}:${s}`);
        }
    </script>
@endpush
