<div class="flex gap-3 @if($comment->parent_id) ml-0 mt-3 @endif">
    <div class="flex-shrink-0">
        <div class="w-10 h-10 @if($comment->parent_id) w-8 h-8 @endif rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-sm overflow-hidden">
            @if($comment->user->avatar)
                <img src="{{ Storage::url($comment->user->avatar) }}" class="h-full w-full object-cover">
            @else
                {{ substr($comment->user->name, 0, 1) }}
            @endif
        </div>
    </div>
    <div class="flex-grow min-w-0">
        <div class="bg-zinc-50 dark:bg-zinc-900/40 rounded-2xl p-4 @if($comment->parent_id) p-3 @endif border border-zinc-100 dark:border-zinc-800 relative group">
            <div class="flex justify-between items-start mb-2">
                <div class="flex flex-wrap items-baseline gap-2">
                    <span class="font-bold text-sm text-zinc-900 dark:text-white">{{ $comment->user->name }}</span>
                    <span class="text-xs text-zinc-500" title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</span>
                    @if($comment->created_at != $comment->updated_at)
                        <span class="text-[10px] text-zinc-400 italic">(edited)</span>
                    @endif
                </div>
                
                @auth
                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    @if(auth()->id() === $comment->user_id)
                        @if($comment->created_at->diffInMinutes(now()) <= 15)
                        <button wire:click="toggleEdit" class="text-xs text-zinc-500 hover:text-indigo-500 transition-colors">Edit</button>
                        @endif
                        <button wire:click="deleteComment" wire:confirm="Are you sure you want to delete this comment?" class="text-xs text-zinc-500 hover:text-red-500 transition-colors">Delete</button>
                    @else
                        <button wire:click="reportComment" class="text-xs text-zinc-500 hover:text-orange-500 transition-colors">Report</button>
                    @endif
                </div>
                @endauth
            </div>

            @if($isEditing)
                <div class="mt-2">
                    <textarea wire:model="editBody" rows="2" class="w-full bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 text-zinc-900 dark:text-white resize-none"></textarea>
                    <div class="flex justify-end gap-2 mt-2">
                        <button wire:click="toggleEdit" class="text-xs px-3 py-1.5 text-zinc-600 hover:bg-zinc-200 dark:text-zinc-400 dark:hover:bg-zinc-700 rounded-md transition-colors">Cancel</button>
                        <button wire:click="updateComment" class="text-xs px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors">Save</button>
                    </div>
                </div>
            @else
                <p class="text-zinc-700 dark:text-zinc-300 text-sm whitespace-pre-wrap break-words">{{ $comment->body }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4 mt-2 ml-2 text-xs">
            <div class="flex items-center gap-3">
                <button wire:click="react('like')" class="flex items-center gap-1 hover:text-indigo-500 transition-colors @if($userReaction === 'like') text-indigo-500 font-bold @else text-zinc-500 dark:text-zinc-400 @endif">
                    <span class="text-[13px]">👍</span> {{ $reactionCounts['like'] > 0 ? $reactionCounts['like'] : '' }}
                </button>
                <button wire:click="react('love')" class="flex items-center gap-1 hover:text-red-500 transition-colors @if($userReaction === 'love') text-red-500 font-bold @else text-zinc-500 dark:text-zinc-400 @endif">
                    <span class="text-[13px]">❤️</span> {{ $reactionCounts['love'] > 0 ? $reactionCounts['love'] : '' }}
                </button>
            </div>

            @if(!$comment->parent_id)
            <button wire:click="toggleReply" class="text-zinc-500 dark:text-zinc-400 hover:text-indigo-500 font-medium transition-colors">
                Reply
            </button>
            @endif
        </div>

        @if($isReplying)
            <div class="mt-3 ml-4 border-l-2 border-zinc-200 dark:border-zinc-800 pl-4">
                <div class="bg-white dark:bg-zinc-900 rounded-xl p-2 border border-indigo-200 dark:border-indigo-900/50 shadow-sm focus-within:ring-1 focus-within:ring-indigo-500">
                    <div class="flex items-center gap-1 mb-1 text-[11px] text-indigo-500 font-medium">
                        <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg> Replying to {{ $comment->user->name }}
                    </div>
                    <textarea wire:model="replyBody" rows="2" class="w-full bg-transparent border-none text-sm focus:ring-0 resize-none text-zinc-900 dark:text-white placeholder-zinc-400" placeholder="Write a reply..."></textarea>
                </div>
                <div class="flex justify-end gap-2 mt-2">
                    <button wire:click="toggleReply" class="text-xs px-3 py-1.5 text-zinc-600 hover:bg-zinc-200 dark:text-zinc-400 dark:hover:bg-zinc-800 rounded-md transition-colors">Cancel</button>
                    <button wire:click="postReply" class="text-xs px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors font-medium">Reply</button>
                </div>
            </div>
        @endif

        @if(!$comment->parent_id && $comment->replies && $comment->replies->count() > 0)
            <div class="mt-4 space-y-4 border-l-2 border-zinc-100 dark:border-zinc-800/50 pl-4 md:pl-6 ml-2 md:ml-4">
                @foreach($comment->replies as $reply)
                    <livewire:frontend.comment-item :comment="$reply" :key="'reply-'.$reply->id" />
                @endforeach
            </div>
        @endif
    </div>
</div>
