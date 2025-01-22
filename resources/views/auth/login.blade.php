@extends('layout2')

@section('content2')
    <div class="account-content">
        {{-- <a href="job-list.html" class="btn btn-primary apply-btn">Apply Job</a> --}}
        <div class="container">

            <!-- Account Logo -->
            <div class="account-logo">
                <a href="{{ route('inicio') }}"><img src="{{ asset('assets/img/logo2.png') }}" alt="Majota net"></a>
            </div>
            <!-- /Account Logo -->

            <div class="account-box">
                <div class="account-wrapper">
                    <h3 class="account-title">Ingresar</h3>
                    <p class="account-subtitle">Accede al panel</p>

                    @include('components.alerts')

                    <!-- Account Form -->
                    <form action="{{ route('post_login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="username">Nombre de usuario o dirección email</label>
                            <input class="form-control" type="text" name="username" id="username"
                                value="{{ session('username') }}">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="password">Contraseña</label>
                                </div>
                                {{-- <div class="col-auto">
                                    <a class="text-muted" href="forgot-password.html">
                                        Forgot password?
                                    </a>
                                </div> --}}
                            </div>
                            <input class="form-control" type="password" name="password" id="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary account-btn">Iniciar sesión</button>
                        </div>
                        {{-- <div class="account-footer">
                            <p>Don't have an account yet? <a href="register.html">Register</a></p>
                        </div> --}}
                    </form>
                    <!-- /Account Form -->
                </div>
            </div>
        </div>
    </div>
@endsection
