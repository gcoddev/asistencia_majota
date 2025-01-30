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
                            <label for="ci">CI o dirección email</label>
                            <input class="form-control" type="text" name="ci" id="ci"
                                value="{{ session('ci') }}">
                            @error('ci')
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
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="captcha">Captcha</label>
                                </div>
                            </div>
                            <div>
                                <div class="mb-3 text-center">
                                    <img src="{{ route('captcha') }}"
                                        onclick="this.src='{{ route('captcha') }}?'+Math.random()" alt="Captcha"
                                        class="img-fluid w-50 rounded" style="cursor:pointer">
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="captcha" class="form-control"
                                        placeholder="Ingresa el código"
                                        onkeyup="this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '');">
                                </div>
                            </div>
                            @error('captcha')
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
