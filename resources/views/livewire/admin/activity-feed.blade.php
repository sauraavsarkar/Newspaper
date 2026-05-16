<div class="p-6">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight">System Activity Log</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Track and audit every event across the platform</p>
        </div>
        
        <div class="flex flex-wrap gap-2">
            <button wire:click="$refresh" class="px-4 py-2 bg-zinc-100 dark:bg-white/5 text-zinc-700 dark:text-zinc-300 rounded-xl text-sm font-bold hover:bg-zinc-200 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-card p-6 rounded-3xl border-zinc-200 dark:border-white/5 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-2">Search Events</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search description..." class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-white/10 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-2">Filter by Role</label>
                <select wire:model.live="role" class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-white/10 rounded-xl text-sm">
                    <option value="">All Roles</option>
                    @foreach($roles as $r)
                        <option value="{{ $r }}">{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-2">Action Type</label>
                <select wire:model.live="actionType" class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-white/10 rounded-xl text-sm">
                    <option value="">All Actions</option>
                    @foreach($actionTypes as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-2">Date From</label>
                <input type="date" wire:model.live="dateFrom" class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-white/10 rounded-xl text-sm">
            </div>
            <div>
                <label class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-2">Date To</label>
                <input type="date" wire:model.live="dateTo" class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-200 dark:border-white/10 rounded-xl text-sm">
            </div>
        </div>
    </div>

    <!-- Timeline/Table -->
    <div class="glass-card rounded-[2rem] border-zinc-200 dark:border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-white/5">
                        <th class="px-6 py-4 text-[10px] font-black text-zinc-400 uppercase tracking-widest">Time</th>
                        <th class="px-6 py-4 text-[10px] font-black text-zinc-400 uppercase tracking-widest">User</th>
                        <th class="px-6 py-4 text-[10px] font-black text-zinc-400 uppercase tracking-widest">Action</th>
                        <th class="px-6 py-4 text-[10px] font-black text-zinc-400 uppercase tracking-widest">Subject</th>
                        <th class="px-6 py-4 text-[10px] font-black text-zinc-400 uppercase tracking-widest">IP / Device</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-white/5">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $activity->created_at->format('M d, H:i:s') }}</span>
                                <span class="block text-[10px] text-zinc-400">{{ $activity->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($activity->causer)
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-500 flex items-center justify-center font-black text-xs">
                                            {{ substr($activity->causer->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $activity->causer->name }}</span>
                                            <div class="flex gap-1 mt-0.5">
                                                @foreach($activity->causer->roles as $role)
                                                    <span class="text-[9px] px-1.5 py-0.5 bg-zinc-100 dark:bg-white/10 rounded-md text-zinc-500 uppercase font-black tracking-tighter">{{ $role->name }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs text-zinc-400 italic">System / Guest</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-zinc-900 dark:text-white">
                                        {{ ucfirst($activity->description) }}
                                    </span>
                                    <span class="text-[10px] text-indigo-500 font-black uppercase tracking-widest">{{ $activity->log_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($activity->subject)
                                    <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                        @if(isset($activity->subject->title))
                                            <span class="block text-[10px] font-medium truncate max-w-[200px]">{{ $activity->subject->title }}</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-xs text-zinc-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 text-[10px] text-zinc-500 font-medium">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.382V6a2 2 0 011.553-1.943l7-1.75a2 2 0 01.894 0l7 1.75A2 2 0 0121 6v9.382a2 2 0 01-1.553 1.944L14 20l-5-5z"></path></svg>
                                        {{ $activity->ip ?? 'Unknown IP' }}
                                    </div>
                                    @if($activity->user_agent)
                                        <div class="text-[9px] text-zinc-400 truncate max-w-[150px]" title="{{ $activity->user_agent }}">
                                            {{ Str::limit($activity->user_agent, 30) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-zinc-500">
                                No activity records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900/50">
            {{ $activities->links() }}
        </div>
    </div>
</div>
