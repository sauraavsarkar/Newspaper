<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Today Morning') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    @stack('styles')

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

<body
    class="font-sans antialiased bg-zinc-50 dark:bg-[#09090b] text-zinc-900 dark:text-zinc-100 flex h-screen overflow-hidden transition-colors duration-500"
    x-data="{ 
        darkMode: localStorage.getItem('darkMode') === 'true' || 
                 (localStorage.getItem('darkMode') === null && window.matchMedia('(prefers-color-scheme: dark)').matches),
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
            this.updateTheme();
        },
        updateTheme() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }"
    x-init="
        updateTheme();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (localStorage.getItem('darkMode') === null) {
                darkMode = e.matches;
                updateTheme();
            }
        });
    ">

    <!-- Sidebar Navigation -->
    <livewire:layout.navigation />

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-screen relative overflow-hidden">
        <!-- Premium Command Header -->
        <header
            class="h-20 flex items-center justify-between px-10 z-30 bg-white/80 dark:bg-[#09090b]/80 backdrop-blur-xl border-b border-zinc-200 dark:border-white/5 sticky top-0">
            <div class="flex items-center gap-6">
                @if (isset($header))
                    {{ $header }}
                @else
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span
                                class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] leading-none">System</span>
                            <span class="text-zinc-300 dark:text-zinc-700 text-[10px]">/</span>
                            <span
                                class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-[0.3em] leading-none">
                                {{ request()->routeIs('admin.articles') ? 'Articles' : (request()->routeIs('admin.categories') ? 'Categories' : 'Dashboard') }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl font-black text-zinc-900 dark:text-white tracking-tighter leading-none">
                                {{ request()->routeIs('admin.articles') ? 'Content Registry' : (request()->routeIs('admin.categories') ? 'Taxonomy Manager' : 'Overview') }}
                            </h2>
                            <div class="flex items-center gap-2 px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-white/5"
                                x-data="{ time: '' }"
                                x-init="time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false }); setInterval(() => time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false }), 1000)">
                                <div class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></div>
                                <span
                                    class="text-[9px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-widest"
                                    x-text="time"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-6">
                <!-- Advanced Global Search -->
                <div class="relative hidden lg:block group">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur opacity-0 group-focus-within:opacity-20 transition duration-500">
                    </div>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-indigo-500 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" placeholder="Search anything across registry..."
                            class="bg-zinc-100 dark:bg-white/5 border-none rounded-2xl pl-12 pr-6 py-2.5 text-sm font-medium focus:ring-4 focus:ring-indigo-500/10 w-80 transition-all text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-600">
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center gap-1">
                            <kbd
                                class="px-1.5 py-0.5 rounded-md bg-zinc-200 dark:bg-white/10 text-[9px] font-black text-zinc-500">⌘</kbd>
                            <kbd
                                class="px-1.5 py-0.5 rounded-md bg-zinc-200 dark:bg-white/10 text-[9px] font-black text-zinc-500">K</kbd>
                        </div>
                    </div>
                </div>

                <div class="h-8 w-px bg-zinc-200 dark:bg-white/10"></div>

                <div class="flex items-center gap-2">
                    <!-- Notification Bell -->
                    <livewire:shared.notification-bell />

                    <!-- Dark Mode Toggle -->
                    <button @click="toggleDarkMode()"
                        class="p-3 rounded-2xl text-zinc-500 hover:text-indigo-500 hover:bg-indigo-500/5 transition-all focus:outline-none group">
                        <svg x-show="!darkMode" class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <button @click="open = ! open"
                        class="flex items-center gap-3 p-1 rounded-2xl hover:bg-zinc-100 dark:hover:bg-white/5 transition-all group">
                        <div
                            class="h-10 w-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-500 p-0.5 shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                            <div
                                class="h-full w-full rounded-[0.6rem] overflow-hidden bg-white dark:bg-zinc-950 flex items-center justify-center">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <span
                                        class="text-xs font-black text-indigo-600 dark:text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="hidden md:flex flex-col items-start text-left">
                            <span
                                class="text-xs font-black text-zinc-900 dark:text-white truncate">{{ auth()->user()->name ?? 'User' }}</span>
                            <span
                                class="text-[9px] font-bold text-zinc-400 uppercase tracking-widest">{{ auth()->user()->roles->first()->name ?? 'Member' }}</span>
                        </div>
                        <svg class="w-4 h-4 text-zinc-400 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors ml-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        class="absolute right-0 mt-4 w-56 rounded-[2rem] shadow-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 z-50 overflow-hidden"
                        style="display: none;">

                        <div
                            class="px-6 py-5 border-b border-zinc-100 dark:border-white/5 bg-zinc-50/50 dark:bg-white/[0.02]">
                            <p class="text-xs font-black text-zinc-900 dark:text-white truncate">
                                {{ auth()->user()->name }}</p>
                            <p class="text-[10px] font-medium text-zinc-500 dark:text-zinc-400 truncate mt-0.5">
                                {{ auth()->user()->email }}</p>
                        </div>

                        <div class="p-2">
                            <a href="{{ route('profile') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold text-zinc-600 dark:text-zinc-400 hover:bg-indigo-500/10 hover:text-indigo-500 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                My Identity
                            </a>
                            <a href="{{ route('reader.activity') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold text-zinc-600 dark:text-zinc-400 hover:bg-indigo-500/10 hover:text-indigo-500 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Archive Feed
                            </a>
                        </div>

                        <div
                            class="p-2 border-t border-zinc-100 dark:border-white/5 bg-zinc-50/30 dark:bg-white/[0.01]">
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button type="submit" @click.prevent="$root.submit();"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold text-red-500 hover:bg-red-500/10 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Scrollable Content Area -->
        <main class="flex-1 overflow-y-auto relative p-8 pb-20">
            <!-- Abstract Glow (Only visible in dark mode, or different in light mode) -->
            <div x-show="darkMode"
                class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-[500px] bg-indigo-500/10 blur-[120px] rounded-full pointer-events-none transition-opacity duration-500">
            </div>
            <div x-show="!darkMode"
                class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-[500px] bg-indigo-200/40 blur-[120px] rounded-full pointer-events-none transition-opacity duration-500">
            </div>

            <div class="relative max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>

    @stack('scripts')

    <!-- Toast Notifications -->
    <div x-data="{
            notifications: [],
            add(e) {
                this.notifications.push({
                    id: Date.now(),
                    message: e.detail.message || e.detail[0].message,
                    type: e.detail.type || (e.detail[0] && e.detail[0].type) || 'success'
                });
                setTimeout(() => { this.remove(this.notifications[0].id) }, 3000);
            },
            remove(id) {
                this.notifications = this.notifications.filter(n => n.id !== id);
            }
        }" @notify.window="add($event)" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2 pointer-events-none">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="max-w-sm w-full bg-white dark:bg-zinc-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <template x-if="notification.type === 'success'">
                                <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </template>
                            <template x-if="notification.type !== 'success'">
                                <svg class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </template>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100"
                                x-text="notification.message"></p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button @click="remove(notification.id)"
                                class="bg-transparent rounded-md inline-flex text-zinc-400 hover:text-zinc-500 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</body>

</html>