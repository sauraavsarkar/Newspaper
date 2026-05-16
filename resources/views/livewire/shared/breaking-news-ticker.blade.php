<div class="bg-indigo-600/10 dark:bg-indigo-600/20 border-b border-indigo-500/20 py-2">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center gap-4">
        <span class="text-xs font-bold text-indigo-400 uppercase tracking-wider flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
            Breaking
        </span>
        <div class="overflow-hidden flex-1 relative h-5">
            <div class="absolute inset-0 flex items-center animate-ticker whitespace-nowrap text-sm font-medium text-zinc-800 dark:text-zinc-200 gap-12">
                @forelse($breakingNews as $article)
                    <a href="{{ route('article.show', $article->slug) }}" class="hover:text-indigo-500 transition-colors">
                        {{ $article->title }}
                    </a>
                @empty
                    <span>Welcome to Today Morning News. Your source for daily updates. Stay tuned.</span>
                @endforelse
            </div>
        </div>
    </div>
</div>
