<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Chronicle OS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
        @stack('styles')
        
        <!-- Prevent Flash of Unstyled Content -->
        <script>
            if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-zinc-50 dark:bg-[#09090b] text-zinc-900 dark:text-zinc-100 flex h-screen overflow-hidden transition-colors duration-300"
          x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" 
          x-init="$watch('darkMode', val => { localStorage.setItem('darkMode', val); document.documentElement.classList.toggle('dark', val); })">
        
        <!-- Sidebar Navigation -->
        <livewire:layout.navigation />

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col h-screen relative overflow-hidden">
            <!-- Top Header -->
            <header class="glass-sidebar h-16 flex items-center justify-between px-8 z-10 border-b border-zinc-200 dark:border-white/5 shadow-sm">
                <div class="flex items-center gap-4">
                    @if (isset($header))
                        {{ $header }}
                    @else
                        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Overview</h2>
                    @endif
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="p-2 rounded-full text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>

                    <!-- Global Search Placeholder -->
                    <div class="relative hidden md:block">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Search anything..." class="bg-white dark:bg-zinc-900/50 border border-zinc-300 dark:border-white/5 rounded-full pl-10 pr-4 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-64 transition-all text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 shadow-sm dark:shadow-none">
                    </div>

                    <!-- User Menu Toggle (Triggered in Navigation) -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                        <button @click="open = ! open" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-zinc-300 dark:focus:border-zinc-700 transition">
                            <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 p-0.5 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 transition-shadow">
                                <div class="h-full w-full rounded-full bg-white dark:bg-zinc-950 flex items-center justify-center">
                                    <span class="text-xs font-bold text-indigo-600 dark:text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                                </div>
                            </div>
                        </button>

                        <!-- User Profile & Logout -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 rounded-xl shadow-lg shadow-black/10 dark:shadow-indigo-500/10 bg-white dark:bg-zinc-900 ring-1 ring-black ring-opacity-5 dark:ring-white/10 z-50 overflow-hidden"
                             style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-zinc-100 dark:border-white/5 bg-zinc-50 dark:bg-zinc-900/50">
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ auth()->user()->name ?? 'User' }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Profile
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button type="submit" @click.prevent="$root.submit();" class="block w-full text-left px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-red-600 dark:hover:text-red-400 transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4 text-zinc-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <main class="flex-1 overflow-y-auto relative z-0 p-8 pb-20">
                <!-- Abstract Glow (Only visible in dark mode, or different in light mode) -->
                <div x-show="darkMode" class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-[500px] bg-indigo-500/10 blur-[120px] rounded-full pointer-events-none transition-opacity duration-500"></div>
                <div x-show="!darkMode" class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-[500px] bg-indigo-200/40 blur-[120px] rounded-full pointer-events-none transition-opacity duration-500"></div>
                
                <div class="relative z-10 max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
        
        @stack('scripts')
    </body>
</html>
