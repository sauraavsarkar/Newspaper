<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 leading-tight">
            {{ __('Command Center') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-[2.5rem] p-10 mb-10 shadow-2xl shadow-indigo-200 relative overflow-hidden text-white">
                <div class="relative z-10">
                    <h3 class="text-4xl font-black mb-2">Welcome back, {{ auth()->user()->name }}!</h3>
                    <p class="text-indigo-100 text-lg opacity-80">Your news engine is primed and ready. What will we publish today?</p>
                </div>
                <!-- Abstract backgrounds -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-64 h-64 bg-purple-500/20 rounded-full blur-2xl"></div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl hover:scale-105 transition-transform duration-300">
                    <div class="h-14 w-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-1">128</div>
                    <div class="text-gray-400 font-bold uppercase tracking-widest text-xs">Total Articles</div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl hover:scale-105 transition-transform duration-300">
                    <div class="h-14 w-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-1">42.5K</div>
                    <div class="text-gray-400 font-bold uppercase tracking-widest text-xs">Total Views</div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl hover:scale-105 transition-transform duration-300">
                    <div class="h-14 w-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-1">12</div>
                    <div class="text-gray-400 font-bold uppercase tracking-widest text-xs">Active Reporters</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <a href="{{ route('admin.articles') }}" class="group bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-xl hover:shadow-indigo-100 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-2xl font-black text-gray-900 mb-2">Write a Story</h4>
                            <p class="text-gray-400 font-medium">Compose a new article and reach thousands.</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.categories') }}" class="group bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-xl hover:shadow-purple-100 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-2xl font-black text-gray-900 mb-2">Organize Topics</h4>
                            <p class="text-gray-400 font-medium">Manage your news categories and tags.</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-purple-600 group-hover:text-white transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
