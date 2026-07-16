<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f5f7fb">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('img/site.webmanifest') }}">

    <title>{{ config('app.name', 'DocuPocket') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
</head>
<body class="font-sans antialiased">
    <main class="auth-page">
        <div class="auth-shell">
            @include('layouts.public.header')
            @include('layouts.public.app')
        </div>

        @include('layouts.public.footer')
    </main>
</body>
</html>
