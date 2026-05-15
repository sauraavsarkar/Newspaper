<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
    <!-- Search Bar -->
    <div class="mb-12">
        <div class="relative max-w-2xl mx-auto">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search the news..." class="block w-full pl-11 pr-4 py-3 bg-zinc-900 border border-white/10 rounded-2xl text-zinc-300 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-sm">
        </div>
    </div>

    @if($featuredArticle)
    <!-- Hero Section -->
    <div class="mb-16">
        <a href="{{ route('article.show', $featuredArticle->slug) }}" class="group block relative rounded-3xl overflow-hidden glass-card border border-white/5 bg-zinc-900/50 transition-all hover:ring-1 hover:ring-indigo-500/50">
            <div class="flex flex-col lg:flex-row">
                <div class="w-full lg:w-3/5 h-[400px] lg:h-[500px] relative overflow-hidden">
                    <img src="{{ $featuredArticle->featured_image ? Storage::url($featuredArticle->featured_image) : 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $featuredArticle->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-zinc-950 via-zinc-950/40 to-transparent"></div>
                </div>
                <div class="w-full lg:w-2/5 p-8 lg:p-12 flex flex-col justify-center relative z-10">
                    @if($featuredArticle->category)
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-400 text-xs font-bold uppercase tracking-wider border border-indigo-500/20">
                            {{ $featuredArticle->category->name }}
                        </span>
                    </div>
                    @endif
                    <h2 class="text-3xl lg:text-5xl font-black text-white mb-6 leading-tight group-hover:text-indigo-400 transition-colors">
                        {{ $featuredArticle->title }}
                    </h2>
                    <p class="text-zinc-400 text-lg mb-8 line-clamp-3">
                        {{ $featuredArticle->excerpt ?? Str::limit(strip_tags($featuredArticle->content), 150) }}
                    </p>
                    <div class="flex items-center gap-4 mt-auto">
                        @if($featuredArticle->author)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-500/20">
                                {{ substr($featuredArticle->author->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-zinc-200">{{ $featuredArticle->author->name }}</p>
                                <p class="text-xs text-zinc-500">{{ $featuredArticle->published_at?->diffForHumans() ?? 'Just now' }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endif

    <!-- Trending/Latest Section -->
    <div>
        <div class="flex items-center justify-between mb-8 border-b border-white/5 pb-4">
            <h3 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Latest Stories
            </h3>
        </div>

        @if($latestArticles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestArticles as $article)
            <a href="{{ route('article.show', $article->slug) }}" class="group glass-card rounded-2xl overflow-hidden border border-white/5 bg-zinc-900/50 hover:bg-zinc-800/50 transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/10 flex flex-col h-full">
                <div class="h-48 relative overflow-hidden">
                    <img src="{{ $article->featured_image ? Storage::url($article->featured_image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" alt="{{ $article->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/20 to-transparent"></div>
                    @if($article->category)
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-md bg-zinc-900/80 backdrop-blur-md text-zinc-300 text-xs font-semibold border border-white/10 shadow-lg">
                            {{ $article->category->name }}
                        </span>
                    </div>
                    @endif
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <h4 class="text-xl font-bold text-white mb-3 leading-snug group-hover:text-indigo-400 transition-colors line-clamp-2">
                        {{ $article->title }}
                    </h4>
                    <p class="text-zinc-400 text-sm mb-6 line-clamp-3 flex-1">
                        {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 100) }}
                    </p>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-white/5">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-zinc-800 flex items-center justify-center text-xs text-white font-bold border border-white/10">
                                {{ substr($article->author?->name ?? 'A', 0, 1) }}
                            </div>
                            <span class="text-xs font-medium text-zinc-400">{{ $article->author?->name ?? 'Unknown' }}</span>
                        </div>
                        <span class="text-xs text-zinc-500">{{ $article->published_at?->diffForHumans() ?? 'Recent' }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-20 glass-card rounded-3xl border border-white/5">
            <svg class="w-16 h-16 text-zinc-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            <h3 class="text-xl font-bold text-zinc-300 mb-2">No Stories Yet</h3>
            <p class="text-zinc-500">Check back later for the latest news and updates.</p>
        </div>
        @endif
    </div>
</div>
