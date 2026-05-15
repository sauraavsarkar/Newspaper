<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<aside class="glass-sidebar w-64 h-full flex flex-col shrink-0">
    <!-- Brand -->
    <div class="h-16 flex items-center px-6 border-b border-white/5">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 group">
            <div class="h-8 w-8 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:shadow-indigo-500/40 transition-all">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            </div>
            <span class="font-bold text-lg tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-zinc-100 to-zinc-400">Chronicle OS</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 py-6 px-3 flex flex-col gap-1 overflow-y-auto">
        <div class="px-3 mb-2 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Main Menu</div>
        
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'text-zinc-400 hover:text-zinc-100 hover:bg-zinc-800/50' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-zinc-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>

        <a href="{{ route('admin.categories') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.categories') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'text-zinc-400 hover:text-zinc-100 hover:bg-zinc-800/50' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.categories') ? 'text-indigo-400' : 'text-zinc-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            Categories
        </a>

        <a href="{{ route('admin.articles') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.articles') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'text-zinc-400 hover:text-zinc-100 hover:bg-zinc-800/50' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('admin.articles') ? 'text-indigo-400' : 'text-zinc-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            Articles
        </a>
    </nav>

    <!-- User Profile & Logout -->
    <div class="p-4 border-t border-white/5">
        <div class="flex items-center gap-3 p-3 rounded-xl bg-zinc-900/50 border border-white/5">
            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-zinc-700 to-zinc-600 flex items-center justify-center shrink-0">
                <span class="text-sm font-bold text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-zinc-100 truncate" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></p>
                <p class="text-xs text-zinc-500 truncate">{{ auth()->user()->email ?? 'user@example.com' }}</p>
            </div>
            
            <x-dropdown align="top" width="48">
                <x-slot name="trigger">
                    <button class="p-1.5 rounded-lg text-zinc-400 hover:text-zinc-100 hover:bg-zinc-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="bg-zinc-900 border border-zinc-800 rounded-lg shadow-xl overflow-hidden">
                        <x-dropdown-link :href="route('profile')" wire:navigate class="text-zinc-300 hover:bg-zinc-800 hover:text-white">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <button wire:click="logout" class="w-full text-start text-zinc-300 hover:bg-zinc-800 hover:text-white">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </div>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</aside>
