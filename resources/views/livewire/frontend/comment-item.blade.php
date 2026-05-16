<div class="group/item flex gap-4 @if($comment->parent_id) ml-0 mt-6 @endif animate-in fade-in slide-in-from-left-4 duration-500">
    <!-- Avatar with Status -->
    <div class="flex-shrink-0 relative">
        <div class="w-12 h-12 @if($comment->parent_id) w-10 h-10 @endif rounded-[1.25rem] bg-zinc-100 dark:bg-zinc-800 border-2 border-white dark:border-zinc-900 shadow-xl overflow-hidden group-hover/item:scale-105 transition-transform duration-500">
            @if($comment->user->avatar)
                <img src="{{ Storage::url($comment->user->avatar) }}" class="h-full w-full object-cover">
            @else
                <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-black text-sm uppercase">
                    {{ substr($comment->user->name, 0, 1) }}
                </div>
            @endif
        </div>
        @if($comment->user_id === $comment->article->user_id)
            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-indigo-500 rounded-full border-2 border-white dark:border-zinc-900 flex items-center justify-center shadow-lg" title="Author">
                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            </div>
        @endif
    </div>

    <!-- Content Area -->
    <div class="flex-grow min-w-0">
        <div class="relative bg-zinc-50 dark:bg-zinc-800/40 rounded-[2rem] rounded-tl-none p-6 border border-transparent group-hover/item:border-indigo-500/10 transition-all duration-500">
            <div class="flex justify-between items-start mb-4">
                <div class="space-y-0.5">
                    <div class="flex items-center gap-2">
                        <span class="font-black text-sm text-zinc-900 dark:text-white uppercase tracking-tight">{{ $comment->user->name }}</span>
                        @if($comment->user_id === $comment->article->user_id)
                            <span class="text-[8px] font-black bg-indigo-500 text-white px-1.5 py-0.5 rounded-md uppercase tracking-widest">Author</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 text-[10px] font-bold text-zinc-400 uppercase tracking-tighter">
                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                        @if($comment->created_at != $comment->updated_at)
                            <span class="text-indigo-400">• Edited</span>
                        @endif
                    </div>
                </div>

                @auth
                <div class="flex items-center gap-1 opacity-0 group-hover/item:opacity-100 transition-opacity">
                    @if(auth()->id() === $comment->user_id)
                        @if($comment->created_at->diffInMinutes(now()) <= 15)
                            <button wire:click="toggleEdit" class="p-2 text-zinc-400 hover:text-indigo-500 hover:bg-indigo-500/5 rounded-xl transition-all" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        @endif
                        <button wire:click="deleteComment" wire:confirm="Delete this thought?" class="p-2 text-zinc-400 hover:text-red-500 hover:bg-red-500/5 rounded-xl transition-all" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    @else
                        <button wire:click="reportComment" class="p-2 text-zinc-400 hover:text-orange-500 hover:bg-orange-500/5 rounded-xl transition-all" title="Report">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </button>
                    @endif
                </div>
                @endauth
            </div>

            @if($isEditing)
                <div class="mt-2 space-y-4">
                    <textarea wire:model="editBody" rows="4" class="w-full bg-white dark:bg-zinc-900 border-2 border-zinc-100 dark:border-white/5 rounded-2xl p-4 text-sm focus:border-indigo-500 focus:ring-0 text-zinc-900 dark:text-white resize-none transition-colors shadow-inner"></textarea>
                    <div class="flex justify-end gap-2">
                        <button wire:click="toggleEdit" class="px-5 py-2 text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:bg-zinc-100 dark:hover:bg-white/5 rounded-xl transition-all">Cancel</button>
                        <button wire:click="updateComment" class="px-6 py-2 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:scale-105 active:scale-95 transition-all shadow-lg shadow-indigo-500/20">Save Changes</button>
                    </div>
                </div>
            @else
                <div class="text-zinc-700 dark:text-zinc-300 text-[15px] leading-relaxed whitespace-pre-wrap break-words font-medium">
                    @php
                        $body = $comment->body;
                        if ($comment->parent_id && str_starts_with($body, '@')) {
                            $parts = explode(' ', $body, 2);
                            $tag = $parts[0];
                            $content = $parts[1] ?? '';
                            echo '<span class="text-indigo-500 font-black inline-flex items-center gap-1 mr-1 bg-indigo-500/5 px-2 py-0.5 rounded-lg">' . e($tag) . '</span>' . e($content);
                        } else {
                            echo e($body);
                        }
                    @endphp
                </div>
            @endif

            <!-- Interaction Bar Pill -->
            <div class="absolute -bottom-4 right-6 flex items-center gap-1 bg-white dark:bg-zinc-900 px-2 py-1 rounded-2xl border border-zinc-100 dark:border-white/5 shadow-xl">
                <button wire:click="react('like')" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl hover:bg-zinc-50 dark:hover:bg-white/5 transition-all @if($userReaction === 'like') text-indigo-500 @else text-zinc-400 @endif">
                    <span class="text-base @if($userReaction === 'like') animate-bounce-short @endif">👍</span>
                    <span class="text-[10px] font-black">{{ $reactionCounts['like'] > 0 ? $reactionCounts['like'] : '' }}</span>
                </button>
                <div class="w-px h-4 bg-zinc-100 dark:bg-white/5 mx-0.5"></div>
                <button wire:click="react('love')" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl hover:bg-zinc-50 dark:hover:bg-white/5 transition-all @if($userReaction === 'love') text-red-500 @else text-zinc-400 @endif">
                    <span class="text-base @if($userReaction === 'love') animate-bounce-short @endif">❤️</span>
                    <span class="text-[10px] font-black">{{ $reactionCounts['love'] > 0 ? $reactionCounts['love'] : '' }}</span>
                </button>
                @if(!$comment->parent_id)
                <div class="w-px h-4 bg-zinc-100 dark:bg-white/5 mx-0.5"></div>
                <button wire:click="toggleReply" class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:text-indigo-500 transition-colors">
                    Reply
                </button>
                @endif
            </div>
        </div>

        <!-- Reply Area -->
        @if($isReplying)
            <div class="mt-8 ml-6 animate-in slide-in-from-top-4 duration-500">
                @auth
                    <div class="bg-indigo-500/5 rounded-[2rem] p-6 border border-indigo-500/10 shadow-2xl shadow-indigo-500/5">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] bg-indigo-500/10 px-3 py-1 rounded-lg">Drafting Reply</span>
                        </div>
                        <textarea 
                            wire:model="replyBody" 
                            rows="3" 
                            class="w-full bg-transparent border-none text-base font-medium focus:ring-0 resize-none text-zinc-900 dark:text-white placeholder-zinc-400" 
                            placeholder="Join the thread..."
                            autofocus
                        ></textarea>
                        <div class="flex justify-end gap-3 mt-4">
                            <button wire:click="toggleReply" class="px-5 py-2 text-[10px] font-black uppercase tracking-widest text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-all">Discard</button>
                            <button wire:click="postReply" class="px-8 py-2.5 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:scale-105 active:scale-95 transition-all shadow-xl shadow-indigo-500/20">Send Reply</button>
                        </div>
                    </div>
                @else
                    <div class="relative group overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[2rem] blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                        <div class="relative bg-white dark:bg-zinc-900 rounded-[2rem] p-8 border border-zinc-200 dark:border-white/5 shadow-2xl flex flex-col items-center text-center">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 flex items-center justify-center mb-6 border border-indigo-500/20">
                                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <h4 class="text-xl font-black text-zinc-900 dark:text-white mb-2 tracking-tight">Voices of Today Morning</h4>
                            <p class="text-zinc-500 dark:text-zinc-400 text-sm max-w-xs mb-8">Please register or sign in to join this conversation and share your perspective.</p>
                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                <a href="{{ route('register') }}" class="flex-1 sm:flex-none px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-xl shadow-indigo-500/20 text-center">Register Now</a>
                                <button wire:click="toggleReply" class="flex-1 sm:flex-none px-8 py-3 bg-zinc-100 dark:bg-white/5 text-zinc-900 dark:text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-white/10 transition-all text-center">Maybe Later</button>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        @endif

        <!-- Nested Stream with Connector -->
        @if(!$comment->parent_id && $comment->replies && $comment->replies->count() > 0)
            <div class="mt-10 space-y-10 relative">
                <!-- Thread Line Connector -->
                <div class="absolute top-0 left-[-2rem] bottom-0 w-1 bg-gradient-to-b from-indigo-500/20 via-zinc-100/50 to-transparent dark:via-white/5 rounded-full hidden sm:block"></div>
                
                <div class="pl-4 sm:pl-8">
                    @foreach($comment->replies as $reply)
                        <livewire:frontend.comment-item :comment="$reply" :key="'reply-'.$reply->id" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
