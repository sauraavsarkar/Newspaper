<article class="max-w-4xl mx-auto px-6 lg:px-8 py-12">
    <!-- Article Header -->
    <header class="mb-12 text-center">
        @if($article->category)
        <a href="#" class="inline-flex items-center px-4 py-1.5 rounded-full bg-indigo-500/10 text-indigo-400 text-sm font-bold uppercase tracking-wider border border-indigo-500/20 mb-6 hover:bg-indigo-500/20 transition-colors">
            {{ $article->category->name }}
        </a>
        @endif
        
        <h1 class="text-4xl md:text-6xl font-black text-zinc-900 dark:text-white mb-6 leading-tight tracking-tight">
            {{ $article->title }}
        </h1>
        
        @if($article->excerpt)
        <p class="text-xl md:text-2xl text-zinc-600 dark:text-zinc-400 max-w-3xl mx-auto mb-8 font-light leading-relaxed">
            {{ $article->excerpt }}
        </p>
        @endif

        <div class="flex items-center justify-center gap-6 mt-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-lg font-bold shadow-lg shadow-indigo-500/20">
                    {{ substr($article->author?->name ?? 'A', 0, 1) }}
                </div>
                <div class="text-left">
                    <p class="text-sm font-bold text-zinc-800 dark:text-zinc-200">{{ $article->author?->name ?? 'Unknown Author' }}</p>
                    <p class="text-xs text-zinc-500">{{ $article->published_at?->format('F j, Y') ?? 'Unpublished' }}</p>
                </div>
            </div>
            
            <div class="w-px h-10 bg-zinc-300 dark:bg-white/10"></div>
            
            <div class="flex gap-2">
                <button class="p-2 rounded-full glass-card hover:bg-white/10 text-zinc-400 hover:text-indigo-400 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </button>
                <button class="p-2 rounded-full glass-card hover:bg-white/10 text-zinc-400 hover:text-blue-500 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Featured Image -->
    @if($article->featured_image)
    <div class="mb-16 rounded-[2rem] overflow-hidden relative shadow-2xl shadow-indigo-500/10 ring-1 ring-zinc-200 dark:ring-white/10">
        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-auto max-h-[600px] object-cover">
    </div>
    @endif

    <!-- Article Content -->
    <div class="prose dark:prose-invert prose-lg max-w-none prose-p:text-zinc-700 dark:prose-p:text-zinc-300 prose-headings:text-zinc-900 dark:prose-headings:text-white prose-a:text-indigo-500 dark:prose-a:text-indigo-400 hover:prose-a:text-indigo-400 dark:hover:prose-a:text-indigo-300 prose-strong:text-zinc-900 dark:prose-strong:text-white prose-blockquote:border-indigo-500 prose-blockquote:bg-indigo-500/5 prose-blockquote:py-1 prose-blockquote:px-4 prose-blockquote:rounded-r-lg prose-img:rounded-xl">
        {!! $article->content !!}
    </div>

    <!-- Tags -->
    @if($article->tags && $article->tags->count() > 0)
    <div class="mt-16 pt-8 border-t border-zinc-200 dark:border-white/10 flex flex-wrap gap-2">
        @foreach($article->tags as $tag)
        <a href="#" class="px-3 py-1 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-white/10 rounded-lg text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-indigo-500/50 transition-colors">
            #{{ $tag->name }}
        </a>
        @endforeach
    </div>
    @endif

    <!-- Author Bio -->
    <div class="mt-16 glass-card rounded-2xl p-8 border border-zinc-200 dark:border-white/5 flex flex-col md:flex-row gap-6 items-center md:items-start">
        <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-indigo-500/20 flex-shrink-0">
            {{ substr($article->author?->name ?? 'A', 0, 1) }}
        </div>
        <div class="text-center md:text-left">
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Written by {{ $article->author?->name ?? 'Unknown Author' }}</h3>
            <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed mb-4">
                {{ $article->author?->name }} is a contributor to Chronicle OS. They cover breaking news, in-depth analysis, and engaging stories across various topics.
            </p>
            <a href="#" class="text-indigo-400 hover:text-indigo-300 font-semibold text-sm inline-flex items-center gap-1 transition-colors">
                View all stories <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</article>
