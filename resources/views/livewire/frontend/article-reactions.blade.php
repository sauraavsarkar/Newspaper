<div class="flex flex-wrap items-center gap-2 py-4 my-6 border-t border-b border-gray-100 dark:border-gray-800">
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
            @if(!auth()->check() && !$isBasic) disabled title="Register to use this reaction" @elseif($tooltip) title="{{ $tooltip }}" @endif
            class="group flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium transition-all duration-200 ease-in-out border
            @if($isActive) 
                bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-400
            @elseif(!auth()->check() && !$isBasic)
                opacity-50 cursor-not-allowed bg-gray-50 border-gray-200 text-gray-400 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-500
            @else
                bg-white border-gray-200 text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:border-gray-600 dark:hover:text-white
            @endif"
        >
            <span class="text-base transform group-hover:scale-110 transition-transform duration-200">{{ $data['icon'] }}</span>
            <span>{{ $count }}</span>
        </button>
    @endforeach
    
    @if(!auth()->check() && $userReaction)
        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2 italic">Register to change your reaction anytime.</span>
    @endif
</div>
