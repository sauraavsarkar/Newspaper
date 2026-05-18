<div x-data="{ showTicker: sessionStorage.getItem('dismissedTicker') !== 'true' }"
     x-show="showTicker"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 -translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 -translate-y-2"
     class="bg-red-500/5 dark:bg-red-500/10 border-b border-red-500/10 py-2.5 relative z-40">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between gap-4">
        <div class="flex items-center gap-4 flex-1 min-w-0">
            <span class="text-xs font-black text-red-500 dark:text-red-400 uppercase tracking-widest flex items-center gap-2 shrink-0">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.8)]"></span>
                </span>
                Breaking News
            </span>
            <div class="overflow-hidden flex-1 relative h-5">
                <div class="absolute inset-0 flex items-center animate-ticker whitespace-nowrap text-sm font-semibold text-zinc-800 dark:text-zinc-200 gap-12 hover:[animation-play-state:paused] cursor-pointer">
                    @forelse($breakingNews as $article)
                        <a href="{{ route('article.show', $article->slug) }}" class="hover:text-red-500 dark:hover:text-red-400 transition-colors flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                            {{ $article->title }}
                        </a>
                    @empty
                        <span class="text-zinc-500">Welcome to Today Morning News. Your source for daily updates. Stay tuned.</span>
                    @endforelse
                </div>
            </div>
        </div>
        <button @click="showTicker = false; sessionStorage.setItem('dismissedTicker', 'true')" 
                class="text-zinc-400 hover:text-red-500 dark:hover:text-red-400 p-1 rounded-lg hover:bg-red-500/10 transition-all shrink-0 focus:outline-none" 
                aria-label="Dismiss breaking news">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

