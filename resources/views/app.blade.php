<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="h-full bg-gray-100 font-sans antialiased">
        @inertia
        {{-- This snippet removes the annoying margin-bottom on the body tag if the debug bar is enabled --}}
        @if (config('app.debug'))
            <script>
                PhpDebugBar.DebugBar.prototype.recomputeBottomOffset = () => {};
            </script>
        @endif
    </body>
</html>
