<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-[#111827]">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="border-b border-[#e5e7eb] bg-white/60 backdrop-blur-sm">
                    <div class="app-shell py-6">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="pb-14 pt-8 sm:pt-10">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
