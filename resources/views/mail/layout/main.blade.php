<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Book shelf') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    @if(file_exists(public_path('css/app.css')) && filesize(public_path('css/app.css')) < 200000)
        <style>
            @php
                include_once(public_path('css/app.css'))
            @endphp
        </style>
    @else
        <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    @endif

</head>

<body class="font-sans antialiased">
@yield('content')
</body>
</html>
