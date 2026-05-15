<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="h-8 w-8 rounded-lg bg-indigo-500/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h2 class="font-bold text-2xl tracking-tight text-zinc-900 dark:text-white">
                Command Center
            </h2>
        </div>
    </x-slot>

    @php
        $totalArticles = \App\Models\Article::count();
        $publishedArticles = \App\Models\Article::where('status', 'published')->count();
        $draftArticles = \App\Models\Article::where('status', 'draft')->count();
        $totalViews = \App\Models\ArticleView::count();
        $weekViews = \App\Models\ArticleView::where('viewed_at', '>=', now()->subDays(7))->count();
        $prevWeekViews = \App\Models\ArticleView::whereBetween('viewed_at', [now()->subDays(14), now()->subDays(7)])->count();
        $viewsGrowth = $prevWeekViews > 0 ? round((($weekViews - $prevWeekViews) / $prevWeekViews) * 100) : ($weekViews > 0 ? 100 : 0);
        $activeReporters = \App\Models\User::whereHas('articles')->count();
        $categoryCount = \App\Models\Category::count();
        $recentActivity = \App\Models\Article::with(['author', 'category'])->latest()->limit(5)->get();
        $pendingDrafts = \App\Models\Article::where('status', 'draft')->with('author')->latest()->limit(3)->get();
    @endphp

    <!-- Welcome Section -->
    <div class="glass-card rounded-[2rem] p-8 mb-8 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-4">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    System Online
                </div>
                <h3 class="text-4xl font-extrabold text-zinc-900 dark:text-white mb-2">Welcome back, {{ auth()->user()->name }}</h3>
                <p class="text-zinc-600 dark:text-zinc-400 text-lg max-w-xl">Your news engine is primed and ready. You have <span class="text-zinc-900 dark:text-white font-medium">{{ $draftArticles }}</span> drafts waiting and <span class="text-zinc-900 dark:text-white font-medium">{{ $publishedArticles }}</span> articles published.</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.articles') }}" class="px-6 py-3 rounded-xl bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold hover:bg-zinc-700 dark:hover:bg-zinc-200 transition-colors shadow-xl shadow-black/10 dark:shadow-white/10 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    New Story
                </a>
            </div>
        </div>
        <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-indigo-500/10 to-transparent pointer-events-none group-hover:opacity-100 transition-opacity opacity-50"></div>
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/20 rounded-full blur-[80px] pointer-events-none group-hover:bg-indigo-500/30 transition-colors"></div>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="glass-card rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-zinc-900 dark:text-white mb-1">{{ $totalArticles }}</div>
            <div class="text-zinc-500 text-sm font-medium">Total Articles</div>
        </div>

        <div class="glass-card rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-purple-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <span class="text-xs font-bold {{ $viewsGrowth >= 0 ? 'text-emerald-400 bg-emerald-400/10' : 'text-red-400 bg-red-400/10' }} px-2 py-1 rounded-lg">{{ $viewsGrowth >= 0 ? '+' : '' }}{{ $viewsGrowth }}%</span>
            </div>
            <div class="text-3xl font-black text-zinc-900 dark:text-white mb-1">{{ number_format($totalViews) }}</div>
            <div class="text-zinc-500 text-sm font-medium">Total Views</div>
        </div>

        <div class="glass-card rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-pink-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-zinc-900 dark:text-white mb-1">{{ $activeReporters }}</div>
            <div class="text-zinc-500 text-sm font-medium">Active Reporters</div>
        </div>

        <div class="glass-card rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-orange-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-zinc-900 dark:text-white mb-1">{{ $categoryCount }}</div>
            <div class="text-zinc-500 text-sm font-medium">Categories</div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Activity Feed -->
        <div class="lg:col-span-2">
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Recent Activity</h3>
                    <a href="{{ route('admin.analytics') }}" class="text-sm text-indigo-400 hover:text-indigo-300">View Analytics →</a>
                </div>
                
                <div class="space-y-6">
                    @forelse($recentActivity as $article)
                    <div class="flex gap-4">
                        <div class="h-10 w-10 rounded-full bg-indigo-500/20 flex items-center justify-center shrink-0 border border-indigo-500/30">
                            <span class="text-sm font-bold text-indigo-400">{{ substr($article->author?->name ?? 'U', 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-zinc-600 dark:text-zinc-300 text-sm"><span class="font-bold text-zinc-900 dark:text-white">{{ $article->author?->name ?? 'Unknown' }}</span>
                                {{ $article->status === 'published' ? 'published' : ($article->status === 'draft' ? 'drafted' : $article->status) }}
                                <span class="text-indigo-500 dark:text-indigo-400 font-medium">"{{ Str::limit($article->title, 50) }}"</span>
                            </p>
                            <span class="text-xs text-zinc-500 mt-1 block">{{ $article->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-zinc-500 text-center py-4">No recent activity yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Quick Actions & Drafts -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">Quick Tools</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.articles') }}" class="p-4 rounded-xl bg-zinc-100/50 dark:bg-zinc-800/50 hover:bg-indigo-500/10 border border-transparent hover:border-indigo-500/20 transition-all group text-center">
                        <div class="h-10 w-10 mx-auto rounded-lg bg-white dark:bg-zinc-900 group-hover:bg-indigo-500/20 flex items-center justify-center mb-3 transition-colors">
                            <svg class="w-5 h-5 text-zinc-400 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">Write</span>
                    </a>
                    <a href="{{ route('admin.categories') }}" class="p-4 rounded-xl bg-zinc-100/50 dark:bg-zinc-800/50 hover:bg-purple-500/10 border border-transparent hover:border-purple-500/20 transition-all group text-center">
                        <div class="h-10 w-10 mx-auto rounded-lg bg-white dark:bg-zinc-900 group-hover:bg-purple-500/20 flex items-center justify-center mb-3 transition-colors">
                            <svg class="w-5 h-5 text-zinc-400 group-hover:text-purple-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                        <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">Categories</span>
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="p-4 rounded-xl bg-zinc-100/50 dark:bg-zinc-800/50 hover:bg-emerald-500/10 border border-transparent hover:border-emerald-500/20 transition-all group text-center">
                        <div class="h-10 w-10 mx-auto rounded-lg bg-white dark:bg-zinc-900 group-hover:bg-emerald-500/20 flex items-center justify-center mb-3 transition-colors">
                            <svg class="w-5 h-5 text-zinc-400 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">Analytics</span>
                    </a>
                    <a href="{{ route('home') }}" class="p-4 rounded-xl bg-zinc-100/50 dark:bg-zinc-800/50 hover:bg-cyan-500/10 border border-transparent hover:border-cyan-500/20 transition-all group text-center">
                        <div class="h-10 w-10 mx-auto rounded-lg bg-white dark:bg-zinc-900 group-hover:bg-cyan-500/20 flex items-center justify-center mb-3 transition-colors">
                            <svg class="w-5 h-5 text-zinc-400 group-hover:text-cyan-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        </div>
                        <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">View Site</span>
                    </a>
                </div>
            </div>

            <!-- Pending Drafts -->
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Pending Drafts</h3>
                    <span class="bg-indigo-500 text-white text-xs font-bold px-2 py-1 rounded-md">{{ $draftArticles }}</span>
                </div>
                
                <div class="space-y-4">
                    @forelse($pendingDrafts as $draft)
                    <div class="p-4 rounded-xl bg-zinc-100/30 dark:bg-zinc-800/30 border border-zinc-200/50 dark:border-white/5 hover:bg-zinc-100/50 dark:hover:bg-zinc-800/50 transition-colors cursor-pointer">
                        <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-1">{{ Str::limit($draft->title, 40) }}</h4>
                        <p class="text-xs text-zinc-500">Last edited {{ $draft->updated_at->diffForHumans() }} by {{ $draft->author?->name ?? 'Unknown' }}</p>
                    </div>
                    @empty
                    <p class="text-sm text-zinc-500 text-center py-4">No pending drafts.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
