@inject('configuracion', 'App\Models\Configuracion')
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $configuracion->first()->alias }}</title>
    <style>
        #app {
            background-color: none;
            background-image: url("/imgs/login.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plantilla.css') }}">
    <style>
        .login-page {
            background: #00000081;
            min-height: 100%;
            height: auto;
        }

        .login-page .card {
            border-radius: 0px;
            box-shadow: 0px 0px 1px 1px var(--primary);
            background: var(--transparente);
        }

        .login-page .card-header {
            border-bottom: solid 1px var(--primary);
        }
    </style>
</head>

<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed text-sm">
    @inject('o_configuracion', 'App\Models\Configuracion')
    <div id="app">
        <div class="login-page">
            <div class="login-box">
                <!-- /.login-logo -->
                <div class="card border border-primary">
                    <div class="card-header text-center">
                        <img src="{{ asset('imgs/' . $o_configuracion->first()->logo) }}" alt="Logo" />
                        <a href="{{ route('inicio') }}"
                            class="h1 text-white"><b>{{ $o_configuracion->first()->razon_social }}</b>
                        </a>
                    </div>
                    <div class="card-body">
                        <formulario-registro accion_despues_registro="2"></formulario-registro>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/plantilla.js') }}"></script>
</body>

</html>
