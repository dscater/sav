@inject('configuracion', 'App\Models\Configuracion')
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $configuracion->first()->nombre_sistema }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plantilla.css') }}">
    <style>
        #app {
            background-color: none;
            background-image: url("/imgs/login.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
</head>

<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed">
    @inject('o_configuracion', 'App\Models\Configuracion')
    <div id="app">
        <div class="login-page">
            <div class="login-box">
                <!-- /.login-logo -->
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <img src="{{ asset('imgs/' . $o_configuracion->first()->logo) }}" alt="Logo" />
                        <a href="" class="h1 text-primary"><b>{{ $o_configuracion->first()->razon_social }}</b>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="text-primary font-weight-bold text-center">RECUPERACIÓN DE CONTRASEÑA</h5>
                        <p class="login-box-msg text-primary font-weight-bold">
                            Ingresa tu correo electronico
                        </p>

                        <form action="{{ route('recuperar_contrasena.enviar') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="input-group mb-3">
                                <input type="email" name="correo" class="form-control"
                                    placeholder="Correo electronico" autofocus required />
                                <div class="input-group-append">
                                    <div class="input-group-text bg-primary">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat font-weight-bold">
                                        Enviar
                                    </button>
                                    <a href="/" class="btn btn-default btn-block btn-flat font-weight-bold">Volver
                                        al inicio</a>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/plantilla.js') }}"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: "success",
                title: "Correcto",
                html: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: "error",
                title: "Error",
                html: "{{ session('error') }}",
                showConfirmButton: false,
            });
        @endif
    </script>
</body>

</html>
