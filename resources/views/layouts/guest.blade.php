<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} | PMS STMIK Bandung</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 bg-gradient-to-br from-blue-950 via-blue-900 to-blue-700 px-4">

            <div class="flex items-center gap-3 mb-6">
                <div class="bg-white rounded-xl p-1.5">
                    <img src="{{ asset('images/logo stmik.png') }}" alt="Logo STMIK Bandung" class="w-10 h-10 object-contain">
                </div>
                <div class="text-white">
                    <p class="font-extrabold text-xl leading-tight">PMS</p>
                    <p class="text-xs text-blue-200 leading-tight">Performance Management System</p>
                </div>
            </div>

            <div class="w-full sm:max-w-md px-6 py-7 bg-white shadow-xl overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>

            <p class="text-blue-200 text-xs mt-6 text-center">
                &copy; {{ date('Y') }} STMIK Bandung &mdash; Performance Management System
            </p>
        </div>
    </body>
</html>