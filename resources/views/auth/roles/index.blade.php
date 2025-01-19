@extends('layout')

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div>
            <div name="title">Roles & Permisos</div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('inicio') }}">Panel</a>
                </li>
                <li class="breadcrumb-item active">Roles</li>
            </ul>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
                <a href="javascript:void(0)" data-url="{{ route('admin.roles.create') }}" data-title="{{ __('Add Role') }}"
                    data-ajax-modal="true" class="btn btn-primary btn-block">
                    <i class="fa fa-plus"></i> {{ __('Add Roles') }}
                </a>

                <div class="roles-menu">
                    <ul>
                        @foreach ($roles as $role)
                            <li class="items" id="item-{{ $role->id }}">
                                <a href="javascript:void(0)" style="cursor:auto">
                                    <span>
                                        {{ $role->name }}
                                    </span>
                                    <span class="role-action">
                                        {{-- <span class="action-circle large" data-bs-toggle="tooltip"
                                            title="{{ __('Assign Permissions') }}"
                                            onclick="window.location.href=`{{ route('admin.roles.index', ['id' => \Crypt::encrypt($role->id)]) }}`">
                                            <i class="fa fa-eye"></i>
                                        </span> --}}
                                        <span class="action-circle large" data-bs-toggle="tooltip"
                                            title="{{ __('Assign Permissions') }}"
                                            data-url="{{ route('admin.roles.permissions', ['id' => $role->id]) }}"
                                            data-id="{{ $role->id }}">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <span class="action-circle large" data-bs-toggle="tooltip" title="Guardar cambios"
                                            data-url="{{ route('admin.roles.edit', $role->id) }}"
                                            data-title="Guardar cambios" data-ajax-modal="true">
                                            <i class="material-icons">save</i>
                                        </span>
                                        <span class="action-circle large delete-btn deleteBtn" data-bs-toggle="tooltip"
                                            title="{{ __('Delete Role') }}"
                                            data-route="{{ route('admin.roles.destroy', $role->id) }}"
                                            data-title="{{ __('Delete Role') }}"
                                            data-question="{{ __('Are you sure you want to delete this role?') }}">
                                            <i class="material-icons">delete</i>
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-9">
                <div class="table-responsive">
                    <form
                        @if (!empty($selected_role)) action="{{ route('permissions.update', $selected_role->id) }}" @endif
                        method="post">
                        @csrf
                        <table class="table table-striped custom-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Module Permission') }}</th>
                                    <th class="text-center">{{ __('Create') }}</th>
                                    <th class="text-center">{{ __('Read') }}</th>
                                    <th class="text-center">{{ __('Edit') }}</th>
                                    <th class="text-center">{{ __('Delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $module => $permission)
                                    <tr>
                                        <td>{{ $module }}</td>
                                        @foreach (['create', 'show', 'edit', 'delete'] as $action)
                                            <td class="text-center">
                                                @foreach ($permission as $item)
                                                    @if (str_ends_with($item, ".$action"))
                                                        <label class="custom_check">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $item }}"
                                                                @if (!empty($selected_role) && $selected_role->hasPermissionTo($item)) checked @endif>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if (!empty($selected_role))
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit">{{ __('Update') }}</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const roleLinks = document.querySelectorAll('.roles-menu li span');

            roleLinks.forEach(link => {
                link.addEventListener('click', function() {

                    const url = this.getAttribute('data-url');
                    const id = 'item-' + this.getAttribute('data-id');
                    const items = document.querySelectorAll('.items');

                    items.forEach(item => item.classList.remove('active'));
                    const targetItem = document.getElementById(id);

                    if (targetItem) {
                        targetItem.classList.add('active');
                    }

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            updatePermissionsTable(data.permissions);
                        })
                        .catch(error => console.log('Error al cargar permisos:', error));
                });
            });

            function updatePermissionsTable(permissions) {
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = ''; // Limpiar la tabla actual

                Object.keys(permissions).forEach(module => {
                    const row = document.createElement('tr');

                    // Generar cada fila con las acciones correspondientes
                    row.innerHTML = `
                        <td>${module}</td>
                        ${['.create', '.show', '.edit', '.delete'].map(action => `
                            <td class="text-center">
                                <label class="custom_check">
                                    <input type="checkbox" name="permissions[]" 
                                            value="${module + action}" 
                                            ${permissions[module].some(permission => permission.name === module + action) ? 'checked' : ''}/>
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                        `).join('')}
        `;

                    tbody.appendChild(row);
                });
            }

        });
    </script>
@endpush
