<div class="mt-12 pt-8 border-t border-zinc-200 dark:border-white/10">
    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Comments</h2>

    @auth
        <div class="mb-10">
            <form wire:submit.prevent="postComment" class="bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl p-4 border border-zinc-200 dark:border-white/10 shadow-sm relative focus-within:ring-2 focus-within:ring-indigo-500 transition-all">
                <textarea 
                    wire:model="body" 
                    rows="3" 
                    class="w-full bg-transparent border-none focus:ring-0 resize-none text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500" 
                    placeholder="Add to the discussion..."
                    required
                ></textarea>
                <div class="flex justify-between items-center mt-3 pt-3 border-t border-zinc-200 dark:border-white/10">
                    <span class="text-xs text-zinc-500">Keep it respectful.</span>
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full text-sm font-medium transition-colors">
                        Post Comment
                    </button>
                </div>
            </form>
            @error('body') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>
    @else
        <div class="mb-10 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl p-6 border border-zinc-200 dark:border-white/10 text-center">
            <p class="text-zinc-600 dark:text-zinc-400 mb-4 font-medium">Join the conversation</p>
            <p class="text-sm text-zinc-500 mb-6">Only registered users can comment on this article.</p>
            <a href="{{ route('register') }}" class="inline-block px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full text-sm font-medium transition-colors">Register to Comment</a>
        </div>
    @endauth

    <div class="space-y-6">
        @forelse($comments as $comment)
            <livewire:frontend.comment-item :comment="$comment" :key="'comment-'.$comment->id" />
        @empty
            <p class="text-zinc-500 dark:text-zinc-400 text-center py-8 bg-zinc-50 dark:bg-zinc-900/30 rounded-2xl border border-dashed border-zinc-300 dark:border-zinc-700">No comments yet. Be the first to start the discussion!</p>
        @endforelse
    </div>
</div>
