<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Dark Mode Support -->
        <script>
            (function() {
                const darkMode = localStorage.getItem('darkMode');
                const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (darkMode === 'true' || (darkMode === null && systemDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
    </head>
    <body class="font-sans text-zinc-900 dark:text-zinc-100 antialiased transition-colors duration-500"
        x-data="{ 
            darkMode: localStorage.getItem('darkMode') === 'true' || 
                     (localStorage.getItem('darkMode') === null && window.matchMedia('(prefers-color-scheme: dark)').matches),
            updateTheme() {
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        }"
        x-init="updateTheme()">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-50 dark:bg-[#09090b]">
            <div class="relative">
                <div class="absolute -inset-4 bg-indigo-500/20 blur-2xl rounded-full"></div>
                <a href="/" wire:navigate class="relative">
                    <x-application-logo class="w-20 h-20 fill-current text-indigo-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-10 px-10 py-10 bg-white dark:bg-zinc-900 shadow-2xl border border-zinc-200 dark:border-white/5 overflow-hidden sm:rounded-[2.5rem]">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
