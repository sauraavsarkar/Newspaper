<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Notification Center</h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Stay updated with everything happening in your workspace.</p>
            </div>
            
            <div class="flex gap-2 p-1 bg-gray-100 dark:bg-gray-800 rounded-xl">
                <button wire:click="setFilter('all')" 
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $filter === 'all' ? 'bg-white dark:bg-gray-700 text-primary-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    All
                </button>
                <button wire:click="setFilter('unread')" 
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $filter === 'unread' ? 'bg-white dark:bg-gray-700 text-primary-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Unread
                </button>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="divide-y divide-gray-50 dark:divide-gray-800">
                @forelse($notifications as $notification)
                    <div class="p-6 hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors {{ $notification->read_at ? 'opacity-75' : 'bg-primary-50/20 dark:bg-primary-900/10' }}">
                        <div class="flex gap-6">
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
                                <div class="h-12 w-12 rounded-2xl {{ $color }} flex items-center justify-center text-xl shadow-sm ring-4 ring-white dark:ring-gray-900">
                                    {{ $icon }}
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-base text-gray-900 dark:text-white leading-relaxed">
                                            {!! $notification->data['message'] !!}
                                        </p>
                                        <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                            <span class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $notification->created_at->format('M d, Y • h:i A') }}
                                            </span>
                                            
                                            @if(isset($notification->is_grouped) && $notification->is_grouped)
                                                <span class="flex items-center gap-1 text-primary-600 font-semibold bg-primary-50 dark:bg-primary-900/30 px-2 py-0.5 rounded-md text-xs uppercase tracking-tighter">
                                                    Grouped ({{ $notification->group_count }})
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-2">
                                        @if(!$notification->read_at)
                                            <button wire:click="markAsRead('{{ isset($notification->is_grouped) ? json_encode($notification->ids) : $notification->id }}')" 
                                                    class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-gray-800 rounded-xl transition-all"
                                                    title="Mark as read">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        @endif
                                        <button wire:click="delete('{{ isset($notification->is_grouped) ? json_encode($notification->ids) : $notification->id }}')" 
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-xl transition-all"
                                                title="Delete notification">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                @if(isset($notification->data['url']) && $notification->data['url'] !== '#')
                                    <div class="mt-4">
                                        <button wire:click="readAndRedirect('{{ isset($notification->is_grouped) ? json_encode($notification->ids) : $notification->id }}', '{{ $notification->data['url'] }}')" 
                                           class="inline-flex items-center gap-2 text-sm font-bold text-primary-600 hover:text-primary-700 group transition-colors bg-transparent border-none p-0 cursor-pointer">
                                            View Details
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-20 text-center">
                        <div class="mx-auto w-24 h-24 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">No notifications found</h3>
                        <p class="mt-2 text-gray-500">You are all caught up for now!</p>
                    </div>
                @endforelse
            </div>
            
            @if($paginator->hasPages())
                <div class="p-6 bg-gray-50/50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800">
                    {{ $paginator->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
