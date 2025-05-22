{{-- @extends('adminlte::auth.login') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | TrackingBO</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="vendor/adminlte/dist/img/AGBClogo.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
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

                        <div>
                            {!! htmlFormSnippet() !!}
                            @if (!isset($_POST['g-recaptcha-response']) && $errors->any())
                                <small class="text-danger">Por favor, complete el reCAPTCHA</small>
                            @endif
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            {{ __('Ingresar') }}
                        </button>
                    </div>
                </form>


                <div class="login100-more" style="background-image: url('images/sobres.jpg');">
                </div>
            </div>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>
