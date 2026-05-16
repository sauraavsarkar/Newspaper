<div class="relative" x-data="{ open: false }">
    <!-- Bell Icon -->
    <button @click="open = !open" class="relative p-2 text-gray-500 hover:text-primary-600 transition-colors focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @if($unreadCount > 0)
            <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white animate-pulse">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 sm:w-96 origin-top-right rounded-2xl bg-white dark:bg-gray-800 shadow-2xl ring-1 ring-black ring-opacity-5 z-50 overflow-hidden border border-gray-100 dark:border-gray-700">
        
        <div class="p-4 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50 backdrop-blur-sm">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                Notifications
                <span class="px-2 py-0.5 rounded-full bg-primary-100 text-primary-700 text-[10px] uppercase tracking-wider">New</span>
            </h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs font-medium text-primary-600 hover:text-primary-700 transition-colors">
                    Mark all read
                </button>
            @endif
        </div>

        <div class="max-h-[400px] overflow-y-auto custom-scrollbar">
            @forelse($notifications as $notification)
                <div class="p-4 border-b border-gray-50 dark:border-gray-700 last:border-0 hover:bg-gray-50/80 dark:hover:bg-gray-700/50 transition-colors relative group">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            @php
                                $icon = $notification->data['icon'] ?? '🔔';
                                $type = $notification->data['type'] ?? 'info';
                                $color = match($type) {
                                    'article_status' => 'bg-blue-100 text-blue-600',
                                    'engagement' => 'bg-pink-100 text-pink-600',
                                    'system' => 'bg-amber-100 text-amber-600',
                                    'reader' => 'bg-green-100 text-green-600',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <div class="h-10 w-10 rounded-xl {{ $color }} flex items-center justify-center text-lg shadow-sm">
                                {{ $icon }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-800 dark:text-gray-200 leading-snug">
                                {!! $notification->data['message'] !!}
                            </p>
                            <div class="mt-1 flex items-center gap-2">
                                <span class="text-[11px] text-gray-400">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                @if(isset($notification->is_grouped) && $notification->is_grouped)
                                    <span class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-[9px] text-gray-500 font-bold uppercase">
                                        +{{ $notification->group_count - 1 }} others
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0 flex flex-col items-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button wire:click="markAsRead('{{ isset($notification->is_grouped) ? json_encode($notification->ids) : $notification->id }}')" 
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-white dark:hover:bg-gray-600 shadow-sm"
                                    title="Mark as read">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    @if(isset($notification->data['url']) && $notification->data['url'] !== '#')
                        <button wire:click="readAndRedirect('{{ isset($notification->is_grouped) ? json_encode($notification->ids) : $notification->id }}', '{{ $notification->data['url'] }}')" 
                                class="absolute inset-0 z-0 w-full h-full cursor-pointer bg-transparent border-none">
                        </button>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="mx-auto w-16 h-16 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">All caught up!</p>
                </div>
            @endforelse
        </div>

        <div class="p-3 bg-gray-50 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700 text-center">
            <a href="{{ route('admin.notifications') }}" class="text-xs font-bold text-primary-600 hover:text-primary-700 uppercase tracking-widest">
                View All Notifications
            </a>
        </div>
    </div>
</div>
