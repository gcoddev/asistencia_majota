<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Inicio</span>
                </li>
                <li class="{{ Route::is('inicio') ? 'active' : '' }}">
                    <a href="{{ route('inicio') }}">
                        <i class="la la-home"></i>
                        <span>Panel</span>
                    </a>
                </li>

                <li class="menu-title">
                    <span>Empleados</span>
                </li>
                <li class="submenu">
                    <a href="#" class="noti-do"><i class="la la-user"></i> <span> Empleados</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="employees.html">Empleados</a></li>
                        <li><a href="attendance.html">Asistencia</a></li>
                        <li><a href="departments.html">Departamentos</a></li>
                        <li><a href="designations.html">Designaciones</a></li>
                        <li><a href="timesheet.html">Vacaciones</a></li>
                    </ul>
                </li>
                <li>
                    <a href="tickets.html"><i class="la la-ticket"></i> <span>Tickets</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-money"></i> <span> Nomina de sueldos </span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="payroll-items.html"> Partida de nominas </a></li>
                        <li><a href="salary-view.html"> Recibos </a></li>
                    </ul>
                </li>

                <li class="menu-title">
                    <span>Administración</span>
                </li>
                <li>
                    <a href="clients.html"><i class="la la-users"></i> <span>Usuarios</span></a>
                </li>
                <li>
                    <a href="settings.html"><i class="la la-cog"></i> <span>Configuraciones</span></a>
                </li>
                <li>
                    <a href="{{ route('admin.roles.index') }}">
                        <i class="la la-key"></i>
                        <span>Roles & permisos</span>
                    </a>
                </li>
                {{-- <li class="menu-title">
                    <span>Pages</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-user"></i> <span> Profile </span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="profile.html"> Employee Profile </a></li>
                        <li><a href="client-profile.html"> Client Profile </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-key"></i> <span> Authentication </span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="login.html"> Login </a></li>
                        <li><a href="register.html"> Register </a></li>
                        <li><a href="forgot-password.html"> Forgot Password </a></li>
                        <li><a href="otp.html"> OTP </a></li>
                        <li><a href="lock-screen.html"> Lock Screen </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-exclamation-triangle"></i> <span> Error Pages </span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="error-404.html">404 Error </a></li>
                        <li><a href="error-500.html">500 Error </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-hand-o-up"></i> <span> Subscriptions </span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="subscriptions.html"> Subscriptions (Admin) </a></li>
                        <li><a href="subscriptions-company.html"> Subscriptions (Company) </a></li>
                        <li><a href="subscribed-companies.html"> Subscribed Companies</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-columns"></i> <span> Pages </span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="search.html"> Search </a></li>
                        <li><a href="faq.html"> FAQ </a></li>
                        <li><a href="terms.html"> Terms </a></li>
                        <li><a href="privacy-policy.html"> Privacy Policy </a></li>
                        <li><a href="blank-page.html"> Blank Page </a></li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span>UI Interface</span>
                </li>
                <li>
                    <a href="components.html"><i class="la la-puzzle-piece"></i> <span>Components</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-object-group"></i> <span> Forms </span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="form-basic-inputs.html">Basic Inputs </a></li>
                        <li><a href="form-input-groups.html">Input Groups </a></li>
                        <li><a href="form-horizontal.html">Horizontal Form </a></li>
                        <li><a href="form-vertical.html"> Vertical Form </a></li>
                        <li><a href="form-mask.html"> Form Mask </a></li>
                        <li><a href="form-validation.html"> Form Validation </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-table"></i> <span> Tables </span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="tables-basic.html">Basic Tables </a></li>
                        <li><a href="data-tables.html">Data Table </a></li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span>Extras</span>
                </li>
                <li>
                    <a href="#"><i class="la la-file-text"></i> <span>Documentation</span></a>
                </li>
                <li>
                    <a href="javascript:void(0);"><i class="la la-info"></i> <span>Change Log</span> <span
                            class="badge badge-primary ml-auto">v3.4</span></a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="la la-share-alt"></i> <span>Multi Level</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="submenu">
                            <a href="javascript:void(0);"> <span>Level 1</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                                <li class="submenu">
                                    <a href="javascript:void(0);"> <span> Level 2</span> <span
                                            class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="javascript:void(0);">Level 3</a></li>
                                        <li><a href="javascript:void(0);">Level 3</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0);"> <span>Level 2</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);"> <span>Level 1</span></a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
