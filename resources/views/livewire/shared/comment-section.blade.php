<div class="mt-24 space-y-12 animate-in fade-in slide-in-from-bottom-10 duration-1000">
    <!-- Modern Header -->
    <div class="relative py-8 px-10 glass-card rounded-[3rem] border-zinc-200/50 dark:border-white/5 overflow-hidden shadow-2xl shadow-indigo-500/5">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-500 bg-indigo-500/10 px-3 py-1 rounded-full">Discussion Hub</span>
                <h2 class="text-4xl font-black text-zinc-900 dark:text-white tracking-tight">Reader Insights</h2>
            </div>
            <div class="flex items-center -space-x-3">
                @foreach($comments->take(4) as $c)
                    <div class="h-10 w-10 rounded-full border-2 border-white dark:border-zinc-900 overflow-hidden bg-zinc-100">
                        @if($c->user->avatar)
                            <img src="{{ Storage::url($c->user->avatar) }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-[10px] font-bold">{{ substr($c->user->name, 0, 1) }}</div>
                        @endif
                    </div>
                @endforeach
                <div class="h-10 w-10 rounded-full border-2 border-white dark:border-zinc-900 bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-[10px] font-black text-zinc-500">
                    +{{ max(0, ($comments->count() + $comments->sum(fn($c) => $c->replies->count())) - 4) }}
                </div>
            </div>
        </div>
        <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 blur-3xl rounded-full translate-x-1/2 -translate-y-1/2"></div>
    </div>

    <!-- Ultra-Modern Input -->
    @auth
        <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[2.5rem] blur opacity-10 group-focus-within:opacity-30 transition duration-1000 group-hover:duration-200"></div>
            <form wire:submit.prevent="postComment" class="relative bg-white dark:bg-zinc-900 rounded-[2.5rem] p-8 border border-zinc-200 dark:border-white/5 shadow-xl">
                <div class="flex items-start gap-6">
                    <div class="shrink-0 pt-1">
                        <div class="w-12 h-12 rounded-2xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center border border-zinc-200 dark:border-white/10 overflow-hidden ring-4 ring-zinc-50 dark:ring-zinc-900 shadow-inner">
                            @if(auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-xs font-black text-zinc-500">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <textarea 
                            wire:model="body" 
                            rows="4" 
                            class="w-full bg-transparent border-none focus:ring-0 resize-none text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-600 text-xl font-medium leading-relaxed" 
                            placeholder="Share your perspective..."
                            required
                        ></textarea>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-6">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest text-zinc-400 bg-zinc-50 dark:bg-white/5 px-3 py-1.5 rounded-xl border border-zinc-100 dark:border-white/5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Member Post
                        </span>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-3 px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-sm transition-all hover:scale-[1.02] active:scale-95 shadow-xl shadow-indigo-500/20 group/btn">
                        Broadcast Thought
                        <svg class="w-5 h-5 group-hover/btn:translate-x-1 group-hover/btn:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </div>
            </form>
            @error('body') <p class="text-red-500 text-[10px] font-black mt-3 ml-6 uppercase tracking-widest">{{ $message }}</p> @enderror
        </div>
    @else
        <div class="relative py-12 px-10 bg-zinc-900 dark:bg-white rounded-[3rem] text-center overflow-hidden">
            <div class="relative z-10 space-y-6">
                <h3 class="text-2xl font-black text-white dark:text-zinc-900">Elevate the Conversation</h3>
                <p class="text-zinc-400 dark:text-zinc-500 max-w-sm mx-auto text-sm leading-relaxed">Join our community of readers to share insights, engage in meaningful debate, and shape the news.</p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-10 py-4 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white rounded-2xl text-sm font-black transition-all hover:scale-105">Get Started</a>
                    <a href="{{ route('login') }}" class="text-white dark:text-zinc-900 text-sm font-black hover:opacity-70 transition-opacity">Sign In</a>
                </div>
            </div>
            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-600/20 to-purple-600/20"></div>
        </div>
    @endauth

    <!-- Comments Stream -->
    <div class="space-y-10">
        @forelse($comments as $comment)
            <div class="animate-in fade-in slide-in-from-bottom-5 duration-700" style="animation-delay: {{ $loop->index * 100 }}ms">
                <livewire:shared.comment-item :comment="$comment" :key="'comment-'.$comment->id" />
            </div>
        @empty
            <div class="py-32 text-center glass-card rounded-[3rem] border-dashed border-zinc-200 dark:border-white/5">
                <div class="h-24 w-24 rounded-[2rem] bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-8 rotate-12 group-hover:rotate-0 transition-transform duration-500 shadow-xl border border-zinc-200 dark:border-white/10">
                    <svg class="w-10 h-10 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                </div>
                <h4 class="text-2xl font-black text-zinc-300 dark:text-zinc-700 uppercase tracking-widest">Silence is golden</h4>
                <p class="text-zinc-500 text-sm mt-4 font-medium italic">...but your thoughts are better. Start the discussion.</p>
            </div>
        @endforelse
    </div>
</div>
