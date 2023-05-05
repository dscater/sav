<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Correo</title>
</head>
<style>
    p {
        font-weight: 500;
        width: 100%;
        text-align: center;
        font-family: 'Courier New', Courier, monospace;
    }
</style>

<body>
    <p>Hola {{ $nombre }}. Haz click en el siguiente enlace, para proceder con la recuperación de tu
        contraseña:<br> <a href="{{ $url }}">Recuperar contraseña</a></p>
</body>

</html>
