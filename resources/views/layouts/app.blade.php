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
    <body class="font-sans antialiased bg-slate-50">
        <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col min-w-0">

                @include('layouts.topbar')

                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    <div class="max-w-7xl mx-auto">
                        @isset($header)
                            <div class="mb-6">
                                {{ $header }}
                            </div>
                        @endisset
                        <x-alert />
                        {{ $slot }}
                    </div>
                </main>

                <footer class="text-center text-xs text-slate-400 py-5">
                    &copy; {{ date('Y') }} Performance Management System &mdash; STMIK Bandung. All rights reserved.
                </footer>
            </div>
        </div>
    </body>
</html>