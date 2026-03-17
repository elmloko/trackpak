{{-- @extends('adminlte::auth.login') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | TrackingBO</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('vendor/adminlte/dist/img/AGBClogo.png') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <!--===============================================================================================-->
</head>

<body style="background-color: #666666;">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="text-center mb-4">
                        <h2>SISTEMA DE SEGUIMIENTO DE PAQUETERÍA POSTAL PARA MEJORA DEL SERVICIO Y CONTROL DE ENVÍOS A NIVEL NACIONAL</h2>
                        <h3>"TRACKINGBO"</h3>
                    </div>
                    <span class="label-input100">{{ __('Email') }}</span>
                    <div class="wrap-input100 validate-input"
                        data-validate="Valid email is required: name@correos.gob.bo">
                        <input class="input100" type="email" name="email" value="{{ old('email') }}" autofocus>
                        <span class="focus-input100"></span>
                    </div>
                    <br>
                    <span class="label-input100">{{ __('Contraseña') }}</span>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
                            <label class="label-checkbox100" for="ckb1">
                                {{ __('Recuérdame') }}
                            </label>
                        </div>

                        {{-- <div>
                            {!! htmlFormSnippet() !!}
                            @if (!isset($_POST['g-recaptcha-response']) && $errors->any())
                                <small class="text-danger">Por favor, complete el reCAPTCHA</small>
                            @endif
                        </div> --}}
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            {{ __('Ingresar') }}
                        </button>
                    </div>
                </form>


                <div class="login100-more" style="background-image: url('{{ asset('images/sobres.jpg') }}');">
                </div>
            </div>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
