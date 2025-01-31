@extends('layout')

@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Perfil</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Perfil</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href="#"><img alt=""
                                            src="{{ asset($user->imagen ?? 'assets/img/user.jpg') }}"></a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0">
                                                {{ $user->nombres }} {{ $user->apellidos }}
                                            </h3>
                                            @if ($user->detalle)
                                                <h6 class="text-muted">
                                                    {{ $user->detalle->designacion ? $user->detalle->designacion->nombre : '- Sin designación -' }}
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $user->detalle->departamento ? $user->detalle->departamento->nombre : '- Sin departamento -' }}
                                                </small>
                                            @endif
                                            {{-- <div class="staff-id">Employee ID : FT-0001</div> --}}
                                            <div class="small doj text-muted">
                                                Se unió el {{ fecha_literal($user->created_at) }}
                                            </div>
                                            {{-- <div class="staff-msg">
                                                <a class="btn btn-custom" href="chat.html">
                                                    Send Message
                                                </a>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Celular:</div>
                                                <div class="text">
                                                    <a href="">
                                                        {{ $user->celular ? '+5910 ' . $user->celular : '-' }}
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Email:</div>
                                                <div class="text">
                                                    <a href="{{ $user->email ? 'mailto:' . $user->email : '#' }}">
                                                        {{ $user->email ?? '-' }}
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Dirección:</div>
                                                <div class="text">
                                                    {{ $user->direccion ?? '-' }}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Ciudad:</div>
                                                <div class="text">
                                                    {{ $user->ciudad ?? '-' }}
                                                </div>
                                            </li>
                                            {{-- <li>
                                                <div class="title">Reports to:</div>
                                                <div class="text">
                                                    <div class="avatar-box">
                                                        <div class="avatar avatar-xs">
                                                            <img src="assets/img/profiles/avatar-16.jpg" alt="">
                                                        </div>
                                                    </div>
                                                    <a href="profile.html">
                                                        Jeffery Lalor
                                                    </a>
                                                </div>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon"
                                    href="#"><i class="fa fa-pencil"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card tab-box">
            <div class="row user-tabs">
                <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom">
                        {{-- <li class="nav-item">
                            <a href="#emp_profile" data-toggle="tab" class="nav-link">Perfil</a>
                        </li> --}}
                        {{-- <li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">Projects</a></li> --}}
                        <li class="nav-item">
                            <a href="#profile" data-toggle="tab" class="nav-link active">
                                Información del perfil
                            </a>
                        </li>
                        @if (Auth::user()->role[0]->name == 'admin' && $user->detalle)
                            <li class="nav-item">
                                <a href="#bank_statutory" data-toggle="tab" class="nav-link">Bancos y estatutos
                                    <small class="text-danger">(Admin)</small>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        @include('components.alerts')

        <div class="tab-content">

            <div class="tab-pane fade show active" id="profile">
                <form id="form-perfil" data-form="detalle">
                    @csrf
                    <input type="hidden" name="usu_id" id="usu_id" value="{{ $user->id }}">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"> Información del usuario</h3>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombres</label>
                                        <input type="text" class="form-control" placeholder="nombres" name="nombres"
                                            id="nombres" value="{{ $user->nombres }}">
                                        <span class="invalid-feedback" id="nombres_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellidos</label>
                                        <input type="text" class="form-control" placeholder="apellidos" name="apellidos"
                                            id="apellidos" value="{{ $user->apellidos }}">
                                        <span class="invalid-feedback" id="apellidos_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Cédula de identidad (CI)</label>
                                        <input type="text" class="form-control" placeholder="Numero de identidad"
                                            name="ci" id="ci" value="{{ $user->ci }}">
                                        <span class="invalid-feedback" id="ci_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Email</label>
                                        <input type="text" class="form-control" placeholder="Dirección email"
                                            name="email" id="email" value="{{ $user->email }}">
                                        <span class="invalid-feedback" id="email_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Celular</label>
                                        <input type="text" class="form-control" placeholder="Número de celular"
                                            name="celular" id="celular" value="{{ $user->celular }}">
                                        <span class="invalid-feedback" id="celular_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($user->detalle)
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"> Datos personales</h3>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Fecha de nacimiento</label>
                                            <input type="hidden" id="fec_nac"
                                                value="{{ $user->detalle->fecha_nacimiento }}">
                                            <div class="cal-icon">
                                                <input type="text" class="form-control datetimepicker"
                                                    placeholder="Fecha" name="fecha_nacimiento" id="fecha_nacimiento"
                                                    value="">
                                                <span class="invalid-feedback" id="fecha_nacimiento_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Genero</label>
                                            <select class="select form-control" name="genero" id="genero">
                                                <option value="">-</option>
                                                <option value="M"
                                                    {{ $user->detalle->genero == 'M' ? 'selected' : '' }}>
                                                    Masculino
                                                </option>
                                                <option value="F"
                                                    {{ $user->detalle->genero == 'F' ? 'selected' : '' }}>
                                                    Femenino
                                                </option>
                                            </select>
                                            <span class="invalid-feedback" id="base_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Estado civil</label>
                                            <select class="select form-control" name="estado_civil" id="estado_civil">
                                                <option value="">-</option>
                                                <option value="Soltero/a"
                                                    {{ $user->detalle->estado_civil == 'Soltero/a' ? 'selected' : '' }}>
                                                    Soltero/a
                                                </option>
                                                <option value="Casado/a"
                                                    {{ $user->detalle->estado_civil == 'Casado/a' ? 'selected' : '' }}>
                                                    Casado/a
                                                </option>
                                                <option value="Viudo/a"
                                                    {{ $user->detalle->estado_civil == 'Viudo/a' ? 'selected' : '' }}>
                                                    Viudo/a
                                                </option>
                                                <option value="Divorciado/a"
                                                    {{ $user->detalle->estado_civil == 'Divorciado/a' ? 'selected' : '' }}>
                                                    Divorciado/a
                                                </option>
                                                <option value="Prefiero no decirlo"
                                                    {{ $user->detalle->estado_civil == 'Prefiero no decirlo' ? 'selected' : '' }}>
                                                    Prefiero no decirlo
                                                </option>
                                            </select>
                                            <span class="invalid-feedback" id="base_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Nacionalidad</label>
                                            <input type="text" class="form-control" placeholder="Nacionalidad"
                                                name="nacionalidad" id="nacionalidad"
                                                value="{{ $user->detalle->nacionalidad }}">
                                            <span class="invalid-feedback" id="nacionalidad_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Ocupación</label>
                                            <input type="text" class="form-control" placeholder="Ocupación"
                                                name="ocupacion" id="ocupacion" value="{{ $user->detalle->ocupacion }}">
                                            <span class="invalid-feedback" id="ocupacion_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Etnia</label>
                                            <input type="text" class="form-control" placeholder="Etnia"
                                                name="etnia" id="etnia" value="{{ $user->detalle->etnia }}">
                                            <span class="invalid-feedback" id="etnia_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="col-form-label">Religion</label>
                                            <input type="text" class="form-control" placeholder="Religion"
                                                name="religion" id="religion" value="{{ $user->detalle->religion }}">
                                            <span class="invalid-feedback" id="religion_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Numero de pasaporte</label>
                                            <input type="text" class="form-control" placeholder="Numero"
                                                name="numero_pasaporte" id="numero_pasaporte"
                                                value="{{ $user->detalle->numero_pasaporte }}">
                                            <span class="invalid-feedback" id="numero_pasaporte_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Expiración de pasaporte</label>
                                            <input type="hidden" id="exp_pas"
                                                value="{{ $user->detalle->exp_pasaporte }}">
                                            <div class="cal-icon">
                                                <input type="text" class="form-control datetimepicker"
                                                    placeholder="Fecha" name="exp_pasaporte" id="exp_pasaporte"
                                                    value="">
                                                <span class="invalid-feedback" id="exp_pasaporte_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Teléfono de pasaporte</label>
                                            <input type="text" class="form-control" placeholder="Teléfono"
                                                name="tel_pasaporte" id="tel_pasaporte"
                                                value="{{ $user->detalle->tel_pasaporte }}">
                                            <span class="invalid-feedback" id="tel_pasaporte_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Contacto de emergencia</label>
                                            <input type="text" class="form-control" placeholder="Numero"
                                                name="contacto_emergencia" id="contacto_emergencia"
                                                value="{{ $user->detalle->contacto_emergencia }}">
                                            <span class="invalid-feedback" id="contacto_emergencia_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Detalle emergencia</label>
                                            <input type="text" class="form-control"
                                                placeholder="Contacto de emergencia" name="detalle_emergencia"
                                                id="detalle_emergencia" value="{{ $user->detalle->detalle_emergencia }}">
                                            <span class="invalid-feedback" id="detalle_emergencia_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" type="submit">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
            @if (Auth::user()->role[0]->name == 'admin' && $user->detalle)
                <!-- Bank Statutory Tab -->
                <div class="tab-pane fade" id="bank_statutory">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"> Información básica sobre el salario</h3>
                            <form id="form-perfil" data-form="salario">
                                @csrf
                                <input type="hidden" name="usu_detalle_id" id="usu_detalle_id"
                                    value="{{ $user->detalle->id }}">
                                <input type="hidden" name="sal_id" id="sal_id"
                                    value="{{ $user->detalle->salario ? $user->detalle->salario->id : '' }}">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Base salarial <span
                                                    class="text-danger">*</span></label>
                                            <select class="select form-control" name="base" id="base">
                                                <option value="">-</option>
                                                <option value="Horas"
                                                    {{ $user->detalle->salario ? ($user->detalle->salario->base == 'Horas' ? 'selected' : '') : '' }}>
                                                    Horas
                                                </option>
                                                <option value="Diario"
                                                    {{ $user->detalle->salario ? ($user->detalle->salario->base == 'Diario' ? 'selected' : '') : '' }}>
                                                    Diario
                                                </option>
                                                <option value="Semanal"
                                                    {{ $user->detalle->salario ? ($user->detalle->salario->base == 'Semanal' ? 'selected' : '') : '' }}>
                                                    Semanal
                                                </option>
                                                <option value="Mensual"
                                                    {{ $user->detalle->salario ? ($user->detalle->salario->base == 'Mensual' ? 'selected' : '') : '' }}>
                                                    Mensual
                                                </option>
                                            </select>
                                            <span class="invalid-feedback" id="base_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Monto del salario</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Bs</span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    placeholder="Ingrese el monto del salario" name="salario_base"
                                                    id="salario_base"
                                                    value="{{ $user->detalle->salario ? $user->detalle->salario->salario_base : '' }}">
                                                <span class="invalid-feedback" id="salario_base_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-form-label">Tipo de pago</label>
                                            <select class="select form-control" name="metodo_pago" id="metodo_pago">
                                                <option value="">-</option>
                                                <option value="Transferencia bancaria"
                                                    {{ $user->detalle->salario
                                                        ? ($user->detalle->salario->metodo_pago == 'Transferencia bancaria'
                                                            ? 'selected'
                                                            : '')
                                                        : '' }}>
                                                    Transferencia bancaria
                                                </option>
                                                <option value="Cheque"
                                                    {{ $user->detalle->salario ? ($user->detalle->salario->metodo_pago == 'Cheque' ? 'selected' : '') : '' }}>
                                                    Cheque
                                                </option>
                                                <option value="Efectivo"
                                                    {{ $user->detalle->salario ? ($user->detalle->salario->metodo_pago == 'Efectivo' ? 'selected' : '') : '' }}>
                                                    Efectivo
                                                </option>
                                            </select>
                                            <span class="invalid-feedback" id="metodo_pago_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4" id="transferencia"
                                        style="display:{{ $user->detalle->salario ? ($user->detalle->salario->metodo_pago == 'Transferencia bancaria' ? 'block' : 'none') : 'none' }}">
                                        <div class="form-group">
                                            <label class="col-form-label">Numero de cuenta bancaria</label>
                                            <input type="text" class="form-control" placeholder="Cuenta bancaria"
                                                name="cuenta_bancaria" id="cuenta_bancaria"
                                                value="{{ $user->detalle->salario ? $user->detalle->salario->cuenta_bancaria : '' }}">
                                            <span class="invalid-feedback" id="cuenta_bancaria_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" type="submit">
                                        {{ $user->detalle->salario ? 'Actualizar' : 'Guardar' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Bank Statutory Tab -->
            @endif

        </div>
    </div>
    <!-- /Page Content -->

    <!-- Profile Modal -->
    {{-- <div id="profile_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Información del perfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-img-wrap edit-img">
                                    <img class="inline-block" src="assets/img/profiles/avatar-02.jpg" alt="user">
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <input class="upload" type="file">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" value="John">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" value="Doe">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birth Date</label>
                                            <div class="cal-icon">
                                                <input class="form-control datetimepicker" type="text"
                                                    value="05/06/1985">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="select form-control">
                                                <option value="male selected">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" value="4487 Snowbird Lane">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" value="New York">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" value="United States">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pin Code</label>
                                    <input type="text" class="form-control" value="10523">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" value="631-889-3206">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select Department</option>
                                        <option>Web Development</option>
                                        <option>IT Management</option>
                                        <option>Marketing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Designation <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select Designation</option>
                                        <option>Web Designer</option>
                                        <option>Web Developer</option>
                                        <option>Android Developer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reports To <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>-</option>
                                        <option>Wilmer Deluna</option>
                                        <option>Lesley Grauer</option>
                                        <option>Jeffery Lalor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- /Profile Modal -->

    <!-- Personal Info Modal -->
    {{-- <div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Información personal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Passport No</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Passport Expiry Date</label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tel</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nationality <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Religion</label>
                                    <div class="cal-icon">
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Marital status <span class="text-danger">*</span></label>
                                    <select class="select form-control">
                                        <option>-</option>
                                        <option>Single</option>
                                        <option>Married</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employment of spouse</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. of children </label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- /Personal Info Modal -->

    <!-- Family Info Modal -->
    {{-- <div id="family_info_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Family Informations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-scroll">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Family Member <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of birth <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Education Informations <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of birth <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-more">
                                        <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- /Family Info Modal -->

    <!-- Emergency Contact Modal -->
    {{-- <div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Personal Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Primary Contact</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Relationship <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone 2</label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Primary Contact</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Relationship <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone 2</label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- /Emergency Contact Modal -->

    <!-- Education Modal -->
    {{-- <div id="education_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Education Informations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-scroll">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Education Informations <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Oxford University"
                                                    class="form-control floating">
                                                <label class="focus-label">Institution</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Computer Science"
                                                    class="form-control floating">
                                                <label class="focus-label">Subject</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="cal-icon">
                                                    <input type="text" value="01/06/2002"
                                                        class="form-control floating datetimepicker">
                                                </div>
                                                <label class="focus-label">Starting Date</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="cal-icon">
                                                    <input type="text" value="31/05/2006"
                                                        class="form-control floating datetimepicker">
                                                </div>
                                                <label class="focus-label">Complete Date</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="BE Computer Science"
                                                    class="form-control floating">
                                                <label class="focus-label">Degree</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Grade A" class="form-control floating">
                                                <label class="focus-label">Grade</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Education Informations <a href="javascript:void(0)"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Oxford University"
                                                    class="form-control floating">
                                                <label class="focus-label">Institution</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Computer Science"
                                                    class="form-control floating">
                                                <label class="focus-label">Subject</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="cal-icon">
                                                    <input type="text" value="01/06/2002"
                                                        class="form-control floating datetimepicker">
                                                </div>
                                                <label class="focus-label">Starting Date</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="cal-icon">
                                                    <input type="text" value="31/05/2006"
                                                        class="form-control floating datetimepicker">
                                                </div>
                                                <label class="focus-label">Complete Date</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="BE Computer Science"
                                                    class="form-control floating">
                                                <label class="focus-label">Degree</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Grade A" class="form-control floating">
                                                <label class="focus-label">Grade</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-more">
                                        <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- /Education Modal -->

    <!-- Experience Modal -->
    {{-- <div id="experience_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Experience Informations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-scroll">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Experience Informations <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="Digital Devlopment Inc">
                                                <label class="focus-label">Company Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="United States">
                                                <label class="focus-label">Location</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="Web Developer">
                                                <label class="focus-label">Job Position</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control floating datetimepicker"
                                                        value="01/07/2007">
                                                </div>
                                                <label class="focus-label">Period From</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control floating datetimepicker"
                                                        value="08/06/2018">
                                                </div>
                                                <label class="focus-label">Period To</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Experience Informations <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="Digital Devlopment Inc">
                                                <label class="focus-label">Company Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="United States">
                                                <label class="focus-label">Location</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="Web Developer">
                                                <label class="focus-label">Job Position</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control floating datetimepicker"
                                                        value="01/07/2007">
                                                </div>
                                                <label class="focus-label">Period From</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control floating datetimepicker"
                                                        value="08/06/2018">
                                                </div>
                                                <label class="focus-label">Period To</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-more">
                                        <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- /Experience Modal -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#fecha_nacimiento').val(formatDateToDDMMYYYY($('#fec_nac').val()))
            $('#exp_pasaporte').val(formatDateToDDMMYYYY($('#exp_pas').val()))
            $('#metodo_pago').on('change', function() {
                if ($(this).val() == 'Transferencia bancaria') {
                    $('#transferencia').css('display', 'block');
                } else {
                    $('#transferencia').css('display', 'none');
                }
            });

            $('#form-perfil').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let form = $(this).data('form');

                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                let id;
                let url;
                switch (form) {
                    case 'salario':
                        id = $('#sal_id').val();
                        url = id ?
                            `{{ url('admin/salarios') }}/${id}` :
                            '{{ route('admin.salarios.store') }}';

                        if (id != '') {
                            formData.append('_method', 'PUT');
                        }
                        break;
                    case 'detalle':
                        id = $('#usu_id').val();
                        url = `{{ url('admin/detalle') }}/${id}`
                        formData.append('_method', 'PUT');
                        break
                }

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
    </script>
@endpush
