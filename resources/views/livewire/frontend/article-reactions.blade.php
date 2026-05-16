<div class="flex flex-wrap items-center gap-3 py-6 my-8 border-t border-b border-zinc-100 dark:border-white/5 animate-in fade-in duration-700">
    @php
        $reactions = [
            'like' => ['icon' => '👍', 'label' => 'Like'],
            'love' => ['icon' => '❤️', 'label' => 'Love'],
            'wow' => ['icon' => '😮', 'label' => 'Wow'],
            'sad' => ['icon' => '😢', 'label' => 'Sad'],
            'angry' => ['icon' => '😡', 'label' => 'Angry'],
            'fire' => ['icon' => '🔥', 'label' => 'Fire'],
        ];
    @endphp

    <div class="flex items-center gap-2">
        @foreach($reactions as $type => $data)
            @php
                $isBasic = in_array($type, ['like', 'love']);
                $count = $reactionCounts[$type] ?? 0;
                $isActive = $userReaction === $type;
                $users = $reactionUsers[$type] ?? [];
                $tooltip = count($users) > 0 ? implode(', ', $users) . (count($users) == 5 ? '...' : '') : '';
            @endphp
            <button 
                wire:click="react('{{ $type }}')"
                @if(!auth()->check() && !$isBasic) 
                    title="Only registered users can use this reaction" 
                @elseif($isActive && !auth()->check())
                    title="Register to change your reaction anytime"
                @elseif($tooltip) 
                    title="{{ $tooltip }}" 
                @endif
                class="group flex items-center gap-2 px-4 py-2 rounded-2xl text-sm font-bold transition-all duration-300 border
                @if($isActive) 
                    bg-indigo-50 border-indigo-200 text-indigo-600 dark:bg-indigo-500/20 dark:border-indigo-500/30 dark:text-indigo-400 shadow-lg shadow-indigo-500/10 scale-105
                @elseif(!auth()->check() && !$isBasic)
                    opacity-40 cursor-not-allowed bg-zinc-50 border-zinc-200 text-zinc-400 dark:bg-zinc-900 dark:border-white/5
                @else
                    bg-white border-zinc-200 text-zinc-600 hover:border-indigo-500/30 hover:bg-indigo-50/30 dark:bg-zinc-900 dark:border-white/5 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200
                @endif"
            >
                <span class="text-lg transform group-hover:scale-125 transition-transform duration-300 @if($isActive) animate-bounce-short @endif">{{ $data['icon'] }}</span>
                @if($count > 0)
                    <span class="tabular-nums">{{ number_format($count) }}</span>
                @endif
            </button>
        @endforeach
    </div>
    
    @if(!auth()->check() && $userReaction)
        <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500/10 border border-amber-500/20 animate-in slide-in-from-left-4 duration-500">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-xs font-bold text-amber-600 dark:text-amber-400">
                You reacted. <a href="{{ route('register') }}" class="underline decoration-2 underline-offset-2 hover:text-amber-700 transition-colors">Register</a> to change it anytime.
            </span>
        </div>
    @endif
    <style>
        @keyframes bounce-short {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .animate-bounce-short {
            animation: bounce-short 0.5s ease-in-out;
        }
    </style>
</div>
