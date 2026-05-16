<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
    <!-- Header Section -->
    <div class="mb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <p class="text-indigo-500 font-bold uppercase tracking-widest text-xs mb-2">{{ $today }}</p>
                <h1 class="text-4xl md:text-5xl font-black text-zinc-900 dark:text-white tracking-tight">
                    {{ $greeting }}, {{ auth()->user()->name }}
                </h1>
            </div>
            <div class="flex items-center gap-3 bg-zinc-100 dark:bg-zinc-800/50 p-2 rounded-2xl border border-zinc-200 dark:border-white/5">
                <div class="h-10 w-10 rounded-xl bg-indigo-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-bold text-zinc-500 tracking-wider">Local Time</p>
                    <p class="text-sm font-bold text-zinc-900 dark:text-white">{{ now()->format('h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($breakingNews->isNotEmpty())
    <!-- Breaking News Ticker -->
    <div class="glass-card rounded-2xl p-4 mb-10 flex items-center gap-4 overflow-hidden border-indigo-500/20 bg-indigo-500/5">
        <span class="shrink-0 flex items-center gap-2 px-3 py-1 bg-red-500 text-white text-[10px] font-black uppercase tracking-tighter rounded-lg animate-pulse">
            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
            Breaking
        </span>
        <div class="flex-1 overflow-hidden relative h-6">
            <div class="absolute inset-0 flex items-center animate-ticker whitespace-nowrap gap-12">
                @foreach($breakingNews as $article)
                    <a href="{{ route('article.show', $article->slug) }}" class="text-sm font-bold text-zinc-800 dark:text-zinc-200 hover:text-indigo-500 transition-colors">
                        {{ $article->title }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Main Content Area (8 cols) -->
        <div class="lg:col-span-8 space-y-12">
            
            <!-- Today's Morning Digest -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-orange-500/20 flex items-center justify-center text-orange-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </span>
                        Today's Morning Digest
                    </h2>
                    <span class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Last 12 Hours</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($morningDigest as $article)
                        <div class="group relative bg-white dark:bg-zinc-900 rounded-[2rem] overflow-hidden border border-zinc-200 dark:border-white/5 hover:border-indigo-500/30 transition-all duration-500 hover:shadow-2xl hover:shadow-indigo-500/10">
                            <div class="aspect-[16/10] overflow-hidden relative">
                                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 rounded-full bg-white/90 dark:bg-zinc-900/90 backdrop-blur text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider shadow-lg">
                                        {{ $article->category->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2 leading-tight group-hover:text-indigo-500 transition-colors">
                                    <a href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
                                </h3>
                                <p class="text-zinc-500 dark:text-zinc-400 text-sm line-clamp-2 mb-4">
                                    {{ Str::limit(strip_tags($article->content), 100) }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="h-6 w-6 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center border border-zinc-200 dark:border-white/10 overflow-hidden">
                                            @if($article->author?->avatar)
                                                <img src="{{ Storage::url($article->author->avatar) }}" class="h-full w-full object-cover">
                                            @else
                                                <span class="text-[8px] font-bold">{{ substr($article->author->name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300">{{ $article->author->name }}</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-zinc-400">{{ $article->published_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 py-12 text-center glass-card rounded-[2rem]">
                            <p class="text-zinc-500">No new updates in your followed categories yet.</p>
                            <a href="#categories" class="text-indigo-500 font-bold mt-2 inline-block">Explore Categories</a>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Continue Reading -->
            @if($continueReading->isNotEmpty())
            <section>
                <h2 class="text-2xl font-black text-zinc-900 dark:text-white mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </span>
                    Continue Reading
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($continueReading as $article)
                    <div class="glass-card rounded-2xl p-4 flex gap-4 hover:border-indigo-500/30 transition-all group">
                        <div class="h-20 w-20 rounded-xl overflow-hidden shrink-0">
                            <img src="{{ $article->featured_image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-zinc-900 dark:text-white truncate mb-1">{{ $article->title }}</h4>
                            <div class="w-full bg-zinc-200 dark:bg-zinc-800 h-1.5 rounded-full overflow-hidden mb-2">
                                <div class="bg-indigo-500 h-full rounded-full" style="width: {{ $article->pivot->scroll_percentage }}%"></div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold text-indigo-400">{{ $article->pivot->scroll_percentage }}% completed</span>
                                <a href="{{ route('article.show', $article->slug) }}" class="text-[10px] font-black uppercase text-zinc-900 dark:text-white hover:text-indigo-500 transition-colors">Resume →</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Your Saved Articles -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-pink-500/20 flex items-center justify-center text-pink-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        </span>
                        Saved for Later
                    </h2>
                    <a href="#" class="text-xs font-bold text-indigo-500 hover:underline">View All</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($savedArticles as $article)
                        <div class="group">
                            <div class="aspect-video rounded-2xl overflow-hidden mb-3 border border-zinc-200 dark:border-white/5">
                                <img src="{{ $article->featured_image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <h4 class="text-sm font-bold text-zinc-900 dark:text-white line-clamp-2 leading-snug group-hover:text-indigo-500 transition-colors">
                                <a href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
                            </h4>
                            <p class="text-[10px] font-bold text-zinc-500 mt-2 uppercase tracking-wider">{{ $article->category->name }}</p>
                        </div>
                    @empty
                        <div class="col-span-3 py-10 text-center glass-card rounded-2xl border-dashed">
                            <p class="text-zinc-500 text-sm">Your reading list is empty.</p>
                        </div>
                    @endforelse
                </div>
            </section>

        </div>

        <!-- Right Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-10">
            
            <!-- Trending Right Now -->
            <div class="glass-card rounded-[2.5rem] p-8">
                <h3 class="text-xl font-black text-zinc-900 dark:text-white mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </span>
                    Trending Now
                </h3>
                <div class="space-y-6">
                    @foreach($trending as $index => $article)
                    <div class="flex gap-4 group">
                        <span class="text-3xl font-black text-zinc-200 dark:text-zinc-800 group-hover:text-indigo-500/20 transition-colors">0{{ $index + 1 }}</span>
                        <div>
                            <a href="{{ route('article.show', $article->slug) }}" class="text-sm font-bold text-zinc-800 dark:text-zinc-200 hover:text-indigo-500 transition-colors line-clamp-2 leading-tight">
                                {{ $article->title }}
                            </a>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] font-bold text-indigo-400 uppercase">{{ $article->category->name }}</span>
                                <span class="text-zinc-600 dark:text-zinc-500">•</span>
                                <span class="text-[10px] text-zinc-500">{{ $article->views_count ?? 0 }} views</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Followed Categories -->
            <div id="categories" class="glass-card rounded-[2.5rem] p-8">
                <h3 class="text-xl font-black text-zinc-900 dark:text-white mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </span>
                    Your Topics
                </h3>
                
                <div class="space-y-4">
                    <div class="flex flex-wrap gap-2">
                        @foreach($followedCategories as $category)
                            <a href="#" class="px-4 py-2 rounded-xl bg-indigo-500 text-white text-xs font-bold shadow-lg shadow-indigo-500/20">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                    
                    @if($suggestedCategories->isNotEmpty())
                    <div class="pt-4 border-t border-zinc-200 dark:border-white/5">
                        <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3">Explore More</p>
                        <div class="space-y-2">
                            @foreach($suggestedCategories as $category)
                                <div class="flex items-center justify-between p-3 rounded-xl bg-zinc-100 dark:bg-zinc-800/50 hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-colors group">
                                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-300">{{ $category->name }}</span>
                                    <button class="text-xs font-black text-indigo-500 group-hover:translate-x-1 transition-transform">Follow +</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Subscription Status -->
            <div class="glass-card rounded-[2.5rem] p-8 bg-gradient-to-br from-indigo-600 to-purple-700 border-none relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-xl font-black text-white mb-2">Premium Member</h3>
                    <p class="text-indigo-100 text-sm mb-6 opacity-80">Access exclusive insights and ad-free experience.</p>
                    <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-indigo-600 rounded-xl font-black text-sm hover:scale-105 transition-transform shadow-xl">
                        Manage Plan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            </div>

        </div>
    </div>
    <style>
        .animate-ticker {
            display: inline-flex;
            animation: ticker 30s linear infinite;
        }
        
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>
</div>
