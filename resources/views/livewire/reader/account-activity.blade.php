<div class="max-w-5xl mx-auto px-6 py-12">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-zinc-900 dark:text-white tracking-tight mb-2">Account Activity</h1>
        <p class="text-zinc-500 dark:text-zinc-400">Your recent interactions and account events.</p>
    </div>

    <div class="space-y-4">
        @forelse($activities as $activity)
            <div class="glass-card p-6 rounded-3xl border-zinc-100 dark:border-white/5 flex items-start gap-6 hover:translate-x-1 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-zinc-100 dark:bg-white/5 flex items-center justify-center shrink-0">
                    @switch($activity->log_name)
                        @case('auth')
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            @break
                        @case('visit')
                        @case('reading')
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            @break
                        @default
                            <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    @endswitch
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-4 mb-1">
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white truncate">
                            {{ ucfirst($activity->description) }}
                        </h3>
                        <span class="text-xs text-zinc-400 font-medium whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>

                    @if($activity->subject)
                        <div class="text-sm text-zinc-500 dark:text-zinc-400 mb-3">
                            @if(isset($activity->subject->title))
                                Regarding: <span class="font-bold text-zinc-700 dark:text-zinc-200">"{{ $activity->subject->title }}"</span>
                            @else
                                {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                            @endif
                        </div>
                    @endif

                    <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400">
                        <span class="px-2 py-0.5 rounded bg-zinc-100 dark:bg-white/5">{{ $activity->log_name ?: 'System' }}</span>
                        <span>{{ $activity->created_at->format('M d, Y \a\t H:i') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-zinc-50 dark:bg-white/5 rounded-[2rem] border-2 border-dashed border-zinc-200 dark:border-white/10">
                <p class="text-zinc-500 dark:text-zinc-400">No activity recorded yet.</p>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $activities->links() }}
        </div>
    </div>
</div>
