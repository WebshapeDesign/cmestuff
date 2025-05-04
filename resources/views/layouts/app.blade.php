<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Main Content -->
            <flux:main container class="max-w-7xl mx-auto">
                @if (isset($header))
                    <flux:heading size="xl">{{ $header }}</flux:heading>
                @endif

                <!-- Breadcrumbs -->
                @include('components.breadcrumbs')

                @if (isset($header))
                    <flux:separator variant="subtle" class="my-8" />
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </flux:main>
        </div>

        @fluxScripts
    </body>
</html> 