<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])
    <title>@yield('title', 'SIGAC')</title>
</head>
<body>
    @include('layouts.navbar')

    <div class="container">
        <h1>SIGAC - Sistema de Gerenciamento de Atividades Complementares</h1>
        @yield('content')
    </div>

    @include('layouts.footer')
</body>
</html>
