<div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-zinc-200 before:to-transparent dark:before:via-white/10">
    @forelse($activities as $activity)
        <div class="relative flex items-start gap-6 group">
            <!-- Dot -->
            <div class="absolute left-5 -translate-x-1/2 w-3 h-3 rounded-full border-2 border-white dark:border-zinc-950 shadow-sm z-10 transition-colors duration-300
                {{ $activity->description === 'created' ? 'bg-emerald-500' : 'bg-indigo-500' }}">
            </div>

            <div class="flex-1 ml-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-black text-zinc-900 dark:text-white uppercase tracking-widest">
                            {{ ucfirst($activity->description) }}
                        </span>
                        <span class="text-[10px] px-2 py-0.5 bg-zinc-100 dark:bg-white/5 rounded-full text-zinc-500 font-bold">
                            {{ $activity->created_at->format('M d, H:i') }}
                        </span>
                    </div>
                    <span class="text-[10px] text-zinc-400 italic">
                        {{ $activity->created_at->diffForHumans() }}
                    </span>
                </div>

                <div class="glass-card p-4 rounded-2xl border-zinc-100 dark:border-white/5 text-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-6 h-6 rounded-lg bg-zinc-100 dark:bg-white/10 flex items-center justify-center text-[10px] font-black text-zinc-500">
                            {{ $activity->causer ? substr($activity->causer->name, 0, 1) : 'S' }}
                        </div>
                        <span class="font-bold text-zinc-700 dark:text-zinc-300">
                            {{ $activity->causer ? $activity->causer->name : 'System' }}
                        </span>
                    </div>

                    @if($activity->properties && count($activity->properties->toArray()) > 0)
                        <div class="space-y-2 mt-3 pt-3 border-t border-zinc-100 dark:border-white/5">
                            @php $props = $activity->properties->toArray(); @endphp
                            
                            @if(isset($props['old']) || isset($props['attributes']))
                                <div class="grid grid-cols-2 gap-4">
                                    @if(isset($props['old']))
                                        <div>
                                            <span class="text-[9px] font-black uppercase text-zinc-400 block mb-1">From</span>
                                            <div class="text-[11px] text-zinc-500 dark:text-zinc-400 bg-red-500/5 p-2 rounded-lg truncate">
                                                @foreach($props['old'] as $key => $val)
                                                    <div class="truncate"><strong>{{ $key }}:</strong> {{ is_array($val) ? json_encode($val) : $val }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($props['attributes']))
                                        <div>
                                            <span class="text-[9px] font-black uppercase text-zinc-400 block mb-1">To</span>
                                            <div class="text-[11px] text-zinc-500 dark:text-zinc-400 bg-emerald-500/5 p-2 rounded-lg truncate">
                                                @foreach($props['attributes'] as $key => $val)
                                                    <div class="truncate"><strong>{{ $key }}:</strong> {{ is_array($val) ? json_encode($val) : $val }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12 text-zinc-500 text-sm italic">
            No history recorded for this article.
        </div>
    @endforelse
</div>
