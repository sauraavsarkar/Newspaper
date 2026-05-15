<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Chronicle OS | Next-Gen Editorial</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-[#09090b] text-zinc-100 selection:bg-indigo-500/30 overflow-x-hidden">
        
        <!-- Background Effects -->
        <div class="fixed inset-0 z-0">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[500px] opacity-20 pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 blur-[100px] rounded-full mix-blend-screen"></div>
            </div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] opacity-10 pointer-events-none">
                <div class="absolute inset-0 bg-blue-500 blur-[120px] rounded-full mix-blend-screen"></div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="relative z-50 glass-card border-x-0 border-t-0 border-white/5 py-4">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between">
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:shadow-indigo-500/40 transition-all">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <span class="font-black text-xl tracking-tight text-white">Chronicle OS</span>
                </div>
                
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-zinc-300 hover:text-white transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-zinc-300 hover:text-white transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-semibold px-4 py-2 rounded-lg bg-white text-zinc-900 hover:bg-zinc-200 transition-colors shadow-lg shadow-white/10">Get Started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative z-10">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-32 pb-24 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-sm font-semibold tracking-wide mb-8">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    Now in Private Beta
                </div>
                
                <h1 class="text-6xl md:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-br from-white via-white to-zinc-500 tracking-tight leading-tight mb-8">
                    The Ultimate <br/> Editorial Engine.
                </h1>
                
                <p class="mt-4 text-xl md:text-2xl text-zinc-400 max-w-3xl mx-auto leading-relaxed mb-12">
                    Chronicle OS is the premium command center for modern newsrooms. Manage stories, collaborate in real-time, and publish at the speed of news.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold text-lg hover:shadow-lg hover:shadow-indigo-500/30 transition-all hover:-translate-y-1 w-full sm:w-auto">
                        Launch Command Center
                    </a>
                    <a href="#" class="px-8 py-4 rounded-xl glass-card text-white font-bold text-lg hover:bg-white/10 transition-all w-full sm:w-auto">
                        View Demo
                    </a>
                </div>
            </div>

            <!-- Dashboard Preview -->
            <div class="max-w-6xl mx-auto px-6 lg:px-8 pb-32">
                <div class="glass-card rounded-[2rem] p-2 sm:p-4 rotate-x-12 transform-gpu shadow-2xl shadow-indigo-500/20 ring-1 ring-white/10">
                    <div class="rounded-[1.5rem] overflow-hidden bg-zinc-950 border border-white/5 relative">
                        <!-- Mac Window Controls -->
                        <div class="absolute top-4 left-4 flex gap-2 z-20">
                            <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                        </div>
                        <img src="https://images.unsplash.com/photo-1618761714954-0b8cd0026356?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Dashboard Preview" class="w-full h-auto opacity-30 mix-blend-luminosity">
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/80 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h2 class="text-4xl font-black text-white/50 tracking-widest uppercase">Chronicle Interface</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Features Grid -->
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-24 border-t border-white/5">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-white mb-4">Built for the Newsroom</h2>
                    <p class="text-zinc-400 max-w-2xl mx-auto">Everything you need to run a high-traffic news publication, engineered into one beautiful platform.</p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="glass-card rounded-2xl p-8 hover:-translate-y-2 transition-transform duration-300">
                        <div class="h-12 w-12 rounded-xl bg-indigo-500/10 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Lightning Fast</h3>
                        <p class="text-zinc-400">Optimized for speed. Publish articles instantly and see changes reflect in real-time across your global network.</p>
                    </div>
                    
                    <div class="glass-card rounded-2xl p-8 hover:-translate-y-2 transition-transform duration-300">
                        <div class="h-12 w-12 rounded-xl bg-purple-500/10 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Team Collaboration</h3>
                        <p class="text-zinc-400">Work seamlessly with editors, writers, and photographers. Approve workflows and track revisions effortlessly.</p>
                    </div>
                    
                    <div class="glass-card rounded-2xl p-8 hover:-translate-y-2 transition-transform duration-300">
                        <div class="h-12 w-12 rounded-xl bg-pink-500/10 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Immersive Editor</h3>
                        <p class="text-zinc-400">A distraction-free writing environment that lets your journalists focus on what matters most: the story.</p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="border-t border-white/5 py-12 relative z-10 text-center">
            <p class="text-zinc-500 text-sm">© {{ date('Y') }} Chronicle OS by NewsFlow. All rights reserved.</p>
        </footer>
    </body>
</html>
