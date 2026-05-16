<div class="relative min-h-screen bg-white dark:bg-zinc-950">
    <!-- Progress Bar -->
    <div class="fixed top-0 left-0 w-full h-1.5 z-50 pointer-events-none">
        <div id="reading-progress" class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 transition-all duration-300" style="width: 0%"></div>
    </div>

    <!-- Floating Side Actions -->
    <div class="fixed left-6 top-1/2 -translate-y-1/2 hidden xl:flex flex-col gap-4 z-40">
        <div class="glass-card rounded-full p-2 flex flex-col gap-2 shadow-2xl border-white/10">
            <button class="w-12 h-12 rounded-full flex items-center justify-center text-zinc-500 hover:text-indigo-500 hover:bg-indigo-500/10 transition-all group" title="Share on Twitter">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
            </button>
            <button class="w-12 h-12 rounded-full flex items-center justify-center text-zinc-500 hover:text-blue-500 hover:bg-blue-500/10 transition-all" title="Share on Facebook">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
            </button>
            <div class="w-full h-px bg-zinc-200 dark:bg-white/10 my-1"></div>
            <a href="#comments" class="w-12 h-12 rounded-full flex items-center justify-center text-zinc-500 hover:text-emerald-500 hover:bg-emerald-500/10 transition-all" title="Go to Comments">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            </a>
        </div>
    </div>

    <!-- Immersive Header Section -->
    <div class="relative h-[60vh] md:h-[80vh] w-full overflow-hidden bg-zinc-900">
        @if($article->featured_image)
            <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 scale-105 animate-slow-zoom">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
        
        <div class="absolute inset-0 flex flex-col justify-end pb-16 md:pb-24">
            <div class="max-w-5xl mx-auto px-6 lg:px-8 w-full">
                @if($article->category)
                    <span class="inline-block px-4 py-1 rounded-full bg-indigo-500 text-white text-[10px] font-black uppercase tracking-[0.3em] mb-6 shadow-xl shadow-indigo-500/20">
                        {{ $article->category->name }}
                    </span>
                @endif
                <h1 class="text-4xl md:text-7xl font-black text-white leading-[1.1] tracking-tight mb-8 animate-in slide-in-from-bottom-10 duration-1000">
                    {{ $article->title }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-6 text-white/80">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center text-white font-black overflow-hidden shadow-2xl">
                            @if($article->author?->avatar)
                                <img src="{{ Storage::url($article->author->avatar) }}" class="h-full w-full object-cover">
                            @else
                                {{ substr($article->author?->name ?? 'A', 0, 1) }}
                            @endif
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-black uppercase tracking-widest text-white">{{ $article->author?->name ?? 'Unknown' }}</p>
                            <p class="text-[10px] font-bold text-white/60 uppercase tracking-widest">{{ $article->published_at?->format('M d, Y') ?? 'Draft' }}</p>
                        </div>
                    </div>
                    <div class="h-10 w-px bg-white/10 hidden sm:block"></div>
                    <div class="flex items-center gap-4 text-xs font-black uppercase tracking-widest">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            {{ number_format($viewCount) }} Views
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} Min Read
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content Section -->
    <article class="max-w-4xl mx-auto px-6 lg:px-8 py-20 relative">
        @if($article->excerpt)
            <div class="mb-16">
                <p class="text-2xl md:text-3xl text-zinc-500 dark:text-zinc-400 italic leading-relaxed font-serif border-l-4 border-indigo-500 pl-8 py-2">
                    {{ $article->excerpt }}
                </p>
            </div>
        @endif

        <div class="prose prose-xl dark:prose-invert max-w-none 
            prose-p:text-zinc-700 dark:prose-p:text-zinc-300 prose-p:leading-[1.8] prose-p:mb-8
            prose-headings:text-zinc-950 dark:prose-headings:text-white prose-headings:font-black prose-headings:tracking-tight
            prose-a:text-indigo-600 dark:prose-a:text-indigo-400 prose-a:no-underline hover:prose-a:underline
            prose-blockquote:border-l-4 prose-blockquote:border-indigo-500 prose-blockquote:bg-indigo-500/5 dark:prose-blockquote:bg-white/5 prose-blockquote:py-4 prose-blockquote:px-8 prose-blockquote:rounded-r-3xl
            prose-img:rounded-[2.5rem] prose-img:shadow-2xl
            prose-strong:text-zinc-950 dark:prose-strong:text-white">
            {!! $article->content !!}
        </div>

        <!-- Reactions (Integrated) -->
        <livewire:shared.reaction-bar :article="$article" />

        <!-- Author Bio Footer -->
        <div class="mt-24 p-10 glass-card rounded-[3rem] border-zinc-200 dark:border-white/5 relative overflow-hidden group">
            <div class="flex flex-col md:flex-row gap-10 items-center md:items-start relative z-10">
                <div class="w-32 h-32 rounded-[2.5rem] bg-gradient-to-tr from-indigo-500 to-purple-600 p-1 shadow-2xl shrink-0 group-hover:rotate-6 transition-transform duration-700">
                    <div class="w-full h-full rounded-[2.25rem] bg-white dark:bg-zinc-900 overflow-hidden">
                        @if($article->author?->avatar)
                            <img src="{{ Storage::url($article->author->avatar) }}" class="h-full w-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl font-black text-zinc-200 dark:text-zinc-800">{{ substr($article->author?->name ?? 'A', 0, 1) }}</div>
                        @endif
                    </div>
                </div>
                <div class="text-center md:text-left flex-1">
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] mb-2 block">The Author</span>
                    <h3 class="text-3xl font-black text-zinc-900 dark:text-white mb-4">{{ $article->author?->name ?? 'Unknown Author' }}</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed mb-6 text-lg">
                        {{ $article->author?->name }} is a dedicated voice at Today Morning, committed to uncovering the truth and sharing stories that matter most to our community.
                    </p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4">
                        <a href="#" class="px-6 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-xl text-xs font-black uppercase tracking-widest hover:scale-105 transition-all">Follow +</a>
                        <a href="#" class="px-6 py-2 bg-zinc-100 dark:bg-white/10 text-zinc-900 dark:text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-white/20 transition-all">View Archive</a>
                    </div>
                </div>
            </div>
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Tags -->
        @if($article->tags && $article->tags->count() > 0)
        <div class="mt-12 flex flex-wrap gap-2 justify-center">
            @foreach($article->tags as $tag)
            <a href="#" class="px-4 py-1.5 bg-zinc-100 dark:bg-white/5 border border-zinc-200 dark:border-white/10 rounded-full text-[10px] font-black text-zinc-500 uppercase tracking-widest hover:border-indigo-500 transition-colors">
                #{{ $tag->name }}
            </a>
            @endforeach
        </div>
        @endif

        <!-- Comment Section -->
        <div id="comments">
            <livewire:shared.comment-section :article="$article" />
        </div>
    </article>

    @auth
    <script>
        document.addEventListener('scroll', function() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = Math.round((winScroll / height) * 100);
            
            // Update progress bar
            document.getElementById('reading-progress').style.width = scrolled + '%';

            // Only update backend if we've scrolled a significant amount
            if (scrolled % 10 === 0 || scrolled === 100) {
                @this.call('updateReadingProgress', scrolled);
            }
        }, { passive: true });
    </script>
    @endauth

    <style>
        @keyframes slow-zoom {
            0% { transform: scale(1.05); }
            100% { transform: scale(1.15); }
        }
        .animate-slow-zoom {
            animation: slow-zoom 20s ease-in-out infinite alternate;
        }
        .prose blockquote p:before, .prose blockquote p:after { content: none !important; }
    </style>
</div>
