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

        /* BOTON CHAT */
        #chat-button {
            position: fixed;
            bottom: 5%;
            right: 5%;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            padding: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 9999;
        }

        #chat-container {
            position: relative;
            background: white;
            position: fixed;
            bottom: 15%;
            right: 5%;
            width: 80%;
            max-width: 500px;
            height: 70%;
            max-height: 600px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: none;
            z-index: 9999;
        }

        @media only screen and (max-width: 600px) {
            #chat-button {
                bottom: 3%;
                right: 3%;
                padding: 12px;
            }

            #chat-container {
                bottom: 10%;
                right: 3%;
                width: 90%;
                max-height: 80%;
            }
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
                    {{-- @if (Auth::guard('visitantes')->check()) --}}
                    @if (Auth::check())
                        <li class="nav-item ml-1 mr-1">
                            <i class="fa fa-user"></i>&nbsp; {{ Auth::user()->correo }}
                        </li>
                        @if (Auth::user()->tipo != 'VISITANTE')
                            <li class="nav-item ml-1 mr-1">
                                <a href="/administracion/inicio" class="text-white"><i class="fa fa-desktop"></i>
                                    Administración</a>
                            </li>
                        @endif
                        <li class="nav-item ml-1 mr-1">
                            <a class="nav-link" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout_visitante').submit()"><i
                                    class="fa fa-power-off"></i></a>
                            <form action="{{ route('logout_visitante') }}" method="post" class="oculto"
                                id="logout_visitante">@csrf</form>
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

        <button id="chat-button"><i class="fa fa-comment-alt"></i></button>
        <div id="chat-container">
            @if (Auth::check())
                @php
                    $visitante = 'no';
                    if (Auth::user()->tipo == 'VISITANTE') {
                        $visitante = 'si';
                    }
                @endphp
                @if ($visitante == 'si')
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-lg text-center font-weight-bold text-sm">
                                    ¿No encontraste la solución a tu problema?<br> Puedes escribirnos
                                    para aclarar tus dudas...
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($visitante == 'no')
                    @php
                        $user = Auth::user()->toJSON();
                    @endphp
                    <Chat user="{{ $user }}" visitante="{{ $visitante }}"></Chat>
                @else
                    @php
                        $user = Auth::user()
                            ->load('visitante')
                            ->toJSON();
                    @endphp
                    <Chat user="{{ $user }}" visitante="{{ $visitante }}">
                    </Chat>
                @endif
            @else
                <div class="row">
                    <div class="col-md-12 text-center text-lg">
                        <p class="font-weight-bold">Debes registrarte o iniciar sesión para poder usar el chat.</p>
                        <p class="mt-3"><a href="{{ route('login') }}">Iniciar sesión</a></p>
                        <p><a href="{{ route('registro') }}">Registrarme</a></p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/plantilla.js') }}"></script>
    <script>
        const chatButton = document.getElementById('chat-button');
        const chatContainer = document.getElementById('chat-container');

        chatButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (chatContainer.style.display === 'block') {
                chatContainer.style.display = 'none';
                $("#contenedorMensajes").attr("data-activo", "no");
            } else {
                chatContainer.style.display = 'block';
                agregaScrollChat();
                $("#contenedorMensajes").attr("data-activo", "si");
                actualizaEstadoChats();
            }
        });

        document.addEventListener('click', (event) => {
            const target = event.target;
            // Verifica si el elemento que se hizo clic es el contenedor del chat o uno de sus hijos directos
            if (!chatContainer.contains(event.target) && event.target !== chatContainer) {
                // Si no es el contenedor del chat ni uno de sus hijos directos, cierra el chat
                chatContainer.style.display = 'none';
            }
        });

        function agregaScrollChat() {
            let chatContainer = document.getElementById("contenedorMensajes");
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function actualizaEstadoChats() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: "POST",
                url: "{{ route('actualizaEstadoChats') }}",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                }
            });
        }
    </script>
</body>

</html>
