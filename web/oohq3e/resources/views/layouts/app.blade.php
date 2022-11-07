<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    @vite('resources/js/app.js')
</head>

<body class="bg-maintain bg-cyan-700 min-h-screen antialiased leading-none">
@yield('content')
</body>
@yield('optioinal_style')
</html>
