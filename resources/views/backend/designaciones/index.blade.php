@extends('layout')

@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Designaciones</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Designaciones</li>
                    </ul>
                </div>
                @can('designacion.create')
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#modal_designacion"
                            onclick="resetForm('Agregar')">
                            <i class="fa fa-plus"></i> Agregar designación
                        </a>
                    </div>
                @endcan
            </div>
        </div>
        <!-- /Page Header -->

        @include('components.alerts')

        <div class="row">
            <div class="col-md-12">
                <div>
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th style="width: 30px;">#</th>
                                <th>Nombre designación</th>
                                <th>Descripción</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($designaciones as $des)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $des->nombre }}</td>
                                    <td>{!! nl2br(e($des->descripcion)) !!}</td>
                                    <td class="text-right">
                                        @if (Auth::user()->can('designacion.delete') || Auth::user()->can('designacion.edit'))
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('designacion.edit')
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#modal_designacion"
                                                            onclick="editDes({{ $des }})">
                                                            <i class="fa fa-pencil m-r-5"></i>
                                                            Editar
                                                        </a>
                                                    @endcan
                                                    @can('designacion.delete')
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#delete_designation"
                                                            onclick="$('#des_id').val({{ $des->id }})">
                                                            <i class="fa fa-trash-o m-r-5"></i>
                                                            Eliminar
                                                        </a>
                                                    @endcan
                                                </div>
                                            </div>
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

    @if (Auth::user()->can('designacion.create') || Auth::user()->can('designacion.edit'))
        <!-- Add Designation Modal -->
        <div id="modal_designacion" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="title-form"></span> designación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-designacion">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="nombre" id="nombre">
                                <span class="invalid-feedback" id="nombre_error"></span>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <input class="form-control" type="text" name="descripcion" id="descripcion">
                                <span class="invalid-feedback" id="descripcion_error"></span>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn" id="btn-form"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Designation Modal -->
    @endif

    @can('designation.delete')
        <!-- Delete Designation Modal -->
        <div class="modal custom-modal fade" id="delete_designation" role="dialog">
            <div class="modal-dialog modal-dialog-centered">z
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Eliminar designación</h3>
                            <p>¿Esta seguro de eliminar el designación?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn" onclick="deleteDes()">
                                        Eliminar
                                    </a>
                                    <input type="hidden" name="des_id" id="des_id">
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal"
                                        class="btn btn-primary cancel-btn">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Designation Modal -->
    @endcan
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#form-designacion').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                const id = $('#id').val();
                if (id != '') {
                    formData.append('_method', 'PUT');
                }

                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                const url = id ?
                    `{{ url('admin/designaciones') }}/${id}` :
                    '{{ route('admin.designaciones.store') }}';

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

        function resetForm(title) {
            $('#title-form').html(title)
            $('#btn-form').removeClass(function(index, className) {
                return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
            });
            $('#btn-form').addClass(`btn btn-${title == 'Agregar' ? 'success' : 'warning'}`);
            $('#btn-form').html(title == 'Agregar' ? 'Agregar' : 'Actualizar')

            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');

            $('#form-designacion').trigger('reset')
        }

        function editDes(data) {
            resetForm('Editar')

            $('#id').val(data.id)
            $('#nombre').val(data.nombre)
            $('#descripcion').val(data.descripcion)
        }

        function deleteDes() {
            const id = $('#des_id').val()

            $.ajax({
                url: `{{ url('admin/designaciones') }}/${id}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(err) {
                    console.log(err);

                    alert('Error al eliminar.');
                }
            });
        }
    </script>
@endpush
