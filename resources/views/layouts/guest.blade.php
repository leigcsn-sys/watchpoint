<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Watchpoint') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-[#E7ECF5] antialiased">
    <div class="min-h-screen flex flex-col items-center pt-8 pb-4 bg-[#0B1120] sm:justify-center sm:pt-0">
        <div class="mb-6">
            <a href="/" class="flex items-center gap-2">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#F5A524] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#F5A524]"></span>
                </span>
                <span class="font-['Space_Grotesk'] font-semibold text-xl text-[#E7ECF5]">Watchpoint</span>
            </a>
        </div>

        <div class="w-full sm:max-w-md px-6 py-6 bg-[#121B2E] border border-[#253449] shadow-sm overflow-hidden sm:rounded-xl">
            {{ $slot }}
        </div>
    </div>
</body>
</html>