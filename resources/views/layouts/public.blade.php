<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Chronicle OS' }} | Next-Gen Editorial</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="antialiased font-sans bg-[#09090b] text-zinc-100 selection:bg-indigo-500/30 overflow-x-hidden">
        
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 glass-card border-x-0 border-t-0 border-white/5 py-4">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group cursor-pointer">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:shadow-indigo-500/40 transition-all">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <span class="font-black text-xl tracking-tight text-white">Chronicle</span>
                </a>
                
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-zinc-300 hover:text-white transition-colors">Home</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-zinc-300 hover:text-white transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-zinc-300 hover:text-white transition-colors">Log in</a>
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Breaking News Ticker (if component exists) -->
        <div class="bg-indigo-600/20 border-b border-indigo-500/20 py-2">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center gap-4">
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    Breaking
                </span>
                <div class="overflow-hidden flex-1 relative h-5">
                    <div class="absolute inset-0 flex items-center animate-ticker whitespace-nowrap text-sm font-medium text-zinc-200">
                        {{-- We will fetch breaking news in Livewire or via a view composer --}}
                        Welcome to Chronicle OS. The next generation editorial engine is now live. Stay tuned for updates.
                    </div>
                </div>
            </div>
        </div>

        <main class="min-h-screen">
            {{ $slot }}
        </main>

        <footer class="border-t border-white/5 py-12 relative z-10 text-center mt-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between flex-col md:flex-row gap-6">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <span class="font-bold text-lg tracking-tight text-white">Chronicle OS</span>
                    </div>
                    <p class="text-zinc-500 text-sm">© {{ date('Y') }} NewsFlow. All rights reserved.</p>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
