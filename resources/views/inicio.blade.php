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
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        a.navbar-brand img {
            height: 100%;
            max-height: 50px;
            width: 100%;
            max-width: 50px;
        }

        .nav-item {
            display: flex;
            align-items: center;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plantilla.css') }}">
</head>

<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed text-sm">
    <div id="app" class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary p-3">
            <a class="navbar-brand" href="/"><img src="{{ asset('imgs/' . $configuracion->first()->logo) }}"
                    alt=""> {{ $configuracion->first()->alias }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @if (Auth::guard('visitantes')->check())
                        <li class="nav-item">
                            <i class="fa fa-user"></i>&nbsp; {{ Auth::guard('visitantes')->user()->correo }}
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout_visitante').submit()"><i
                                    class="fa fa-power-off"></i></a>
                            <form action="{{ route('logout_visitante') }}" method="post" class="oculto" id="logout_visitante">@csrf</form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('registro') }}">Registrarse</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
        <Buscador></Buscador>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/plantilla.js') }}"></script>
    <script></script>
</body>

</html>
