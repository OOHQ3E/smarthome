<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    @vite('resources/js/app.js')
</head>

<body class="bg-gradient-to-b from-cyan-600 to-emerald-400  min-h-screen antialiased leading-none">
@yield('content')
</body>
</html>
