<div class="py-6 space-y-8" x-data="{ 
    isModalOpen: @entangle('isModalOpen'),
    sidebarOpen: true,
    isMobile: window.innerWidth < 1024
}" x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 1024)">

    <!-- Editorial Overview Header -->
    <div class="px-6 space-y-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="space-y-3">
                <!-- Spacing placeholder removed for redundancy -->
            </div>

            <div class="flex items-center gap-4">
                <div class="relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur opacity-0 group-focus-within:opacity-20 transition duration-500"></div>
                    <div class="relative flex items-center">
                        <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search narrative registry..."
                            class="bg-white dark:bg-zinc-900/50 border border-zinc-200 dark:border-white/10 rounded-2xl pl-12 pr-6 py-4 text-sm font-medium focus:ring-4 focus:ring-indigo-500/10 w-full md:w-96 transition-all shadow-sm placeholder:text-zinc-400">
                        <svg class="w-5 h-5 absolute left-4 text-zinc-400 group-focus-within:text-indigo-500 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <button wire:click="create"
                    class="group relative inline-flex items-center gap-3 px-8 py-4 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-2xl font-black text-sm transition-all shadow-2xl shadow-zinc-500/20 active:scale-95 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>New Narrative</span>
                </button>
            </div>
        </div>

        <!-- Real-time Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="group relative p-8 bg-white dark:bg-zinc-900/40 backdrop-blur-xl border border-zinc-200 dark:border-white/5 rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-32 h-32 bg-indigo-500/10 blur-[60px] rounded-full group-hover:bg-indigo-500/20 transition-colors"></div>
                <div class="flex items-center justify-between mb-8">
                    <div class="h-14 w-14 rounded-2xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[9px] font-black text-indigo-500 uppercase tracking-[0.3em]">Registry</span>
                        <div class="h-1 w-4 bg-indigo-500/20 rounded-full mt-1 group-hover:w-8 transition-all duration-500"></div>
                    </div>
                </div>
                <div class="space-y-1 relative z-10">
                    <h4 class="text-5xl font-black text-zinc-900 dark:text-white tracking-tighter leading-none">{{ number_format($stats['total']) }}</h4>
                    <p class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest pt-1">Total Narrative Volume</p>
                </div>
            </div>

            <div class="group relative p-8 bg-white dark:bg-zinc-900/40 backdrop-blur-xl border border-zinc-200 dark:border-white/5 rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-32 h-32 bg-emerald-500/10 blur-[60px] rounded-full group-hover:bg-emerald-500/20 transition-colors"></div>
                <div class="flex items-center justify-between mb-8">
                    <div class="h-14 w-14 rounded-2xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em]">Active</span>
                        <div class="h-1 w-4 bg-emerald-500/20 rounded-full mt-1 group-hover:w-8 transition-all duration-500"></div>
                    </div>
                </div>
                <div class="space-y-1 relative z-10">
                    <h4 class="text-5xl font-black text-emerald-500 tracking-tighter leading-none">{{ number_format($stats['published']) }}</h4>
                    <p class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest pt-1">Live Editorial Feed</p>
                </div>
            </div>

            <div class="group relative p-8 bg-white dark:bg-zinc-900/40 backdrop-blur-xl border border-zinc-200 dark:border-white/5 rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:shadow-amber-500/10 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-32 h-32 bg-amber-500/10 blur-[60px] rounded-full group-hover:bg-amber-500/20 transition-colors"></div>
                <div class="flex items-center justify-between mb-8">
                    <div class="h-14 w-14 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[9px] font-black text-amber-500 uppercase tracking-[0.3em]">Queue</span>
                        <div class="h-1 w-4 bg-amber-500/20 rounded-full mt-1 group-hover:w-8 transition-all duration-500"></div>
                    </div>
                </div>
                <div class="space-y-1 relative z-10">
                    <h4 class="text-5xl font-black text-amber-500 tracking-tighter leading-none">{{ number_format($stats['pending']) }}</h4>
                    <p class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest pt-1">Awaiting Refinement</p>
                </div>
            </div>

            <div class="group relative p-8 bg-white dark:bg-zinc-900/40 backdrop-blur-xl border border-zinc-200 dark:border-white/5 rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-32 h-32 bg-zinc-500/10 blur-[60px] rounded-full group-hover:bg-zinc-500/20 transition-colors"></div>
                <div class="flex items-center justify-between mb-8">
                    <div class="h-14 w-14 rounded-2xl bg-zinc-100 dark:bg-white/5 text-zinc-500 flex items-center justify-center group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[9px] font-black text-zinc-500 uppercase tracking-[0.3em]">Drafts</span>
                        <div class="h-1 w-4 bg-zinc-500/20 rounded-full mt-1 group-hover:w-8 transition-all duration-500"></div>
                    </div>
                </div>
                <div class="space-y-1 relative z-10">
                    <h4 class="text-5xl font-black text-zinc-900 dark:text-white tracking-tighter leading-none">{{ number_format($stats['drafts']) }}</h4>
                    <p class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest pt-1">Unfinished Narratives</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-6 relative group/registry">
        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 rounded-[3.5rem] blur-2xl opacity-0 group-hover/registry:opacity-100 transition duration-1000"></div>
        <div class="relative bg-white/70 dark:bg-zinc-900/40 backdrop-blur-2xl rounded-[3rem] border border-zinc-200 dark:border-white/10 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-white/5 bg-zinc-50/50 dark:bg-white/[0.02]">
                            <th class="px-10 py-7 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">Story Registry</th>
                            <th class="px-8 py-7 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">Domain</th>
                            <th class="px-8 py-7 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">State</th>
                            <th class="px-8 py-7 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em]">Metrics</th>
                            <th class="px-10 py-7 text-[10px] font-black text-zinc-400 uppercase tracking-[0.4em] text-right">Ops</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-white/5">
                        @forelse($articles as $article)
                            <tr class="group/row hover:bg-indigo-500/[0.02] dark:hover:bg-indigo-500/[0.04] transition-all duration-500">
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-8">
                                        <div class="relative h-24 w-40 rounded-3xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 shrink-0 border border-zinc-200 dark:border-white/10 shadow-lg group-hover/row:shadow-indigo-500/20 group-hover/row:scale-[1.02] transition-all duration-500">
                                            @if($article->featured_image)
                                                <img src="{{ Storage::url($article->featured_image) }}"
                                                    class="h-full w-full object-cover group-hover/row:scale-110 transition-transform duration-1000">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-900">
                                                    <svg class="w-10 h-10 text-zinc-300 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            
                                            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                                @if($article->is_breaking)
                                                    <div class="px-3 py-1 rounded-full bg-red-600/90 backdrop-blur-md text-white text-[8px] font-black uppercase tracking-widest shadow-xl animate-pulse">Breaking</div>
                                                @endif
                                                @if($article->is_featured)
                                                    <div class="px-3 py-1 rounded-full bg-indigo-600/90 backdrop-blur-md text-white text-[8px] font-black uppercase tracking-widest shadow-xl">Featured</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="min-w-0 space-y-2">
                                            <h3 class="text-lg font-black text-zinc-900 dark:text-white truncate group-hover/row:text-indigo-500 transition-colors leading-tight tracking-tight">
                                                {{ $article->title }}
                                            </h3>
                                            <div class="flex items-center gap-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="h-5 w-5 rounded-full bg-zinc-100 dark:bg-white/5 flex items-center justify-center border border-zinc-200 dark:border-white/10">
                                                        <span class="text-[8px] font-black text-zinc-500 uppercase">{{ substr($article->author->name, 0, 1) }}</span>
                                                    </div>
                                                    <span class="text-[10px] font-bold text-zinc-500 truncate">{{ $article->author->name }}</span>
                                                </div>
                                                <div class="h-1 w-1 rounded-full bg-zinc-300 dark:bg-zinc-700"></div>
                                                <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest italic">{{ $article->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-8">
                                    <div class="relative inline-flex group/badge">
                                        <div class="absolute -inset-2 bg-indigo-500/20 rounded-xl blur opacity-0 group-hover/badge:opacity-100 transition-opacity"></div>
                                        <span class="relative inline-flex items-center px-5 py-2.5 rounded-2xl bg-zinc-100/50 dark:bg-white/5 text-[10px] font-black text-zinc-600 dark:text-zinc-400 uppercase tracking-[0.2em] border border-zinc-200/50 dark:border-white/10 shadow-sm transition-all group-hover/row:border-indigo-500/40 group-hover/row:text-indigo-500">
                                            {{ $article->category->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-8">
                                    @php
                                        $statusConfig = [
                                            'published' => ['color' => 'text-emerald-500', 'bg' => 'bg-emerald-500/10', 'border' => 'border-emerald-500/20', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                            'draft' => ['color' => 'text-zinc-500', 'bg' => 'bg-zinc-500/10', 'border' => 'border-zinc-500/20', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                                            'submitted' => ['color' => 'text-indigo-500', 'bg' => 'bg-indigo-500/10', 'border' => 'border-indigo-500/20', 'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'],
                                            'in_review' => ['color' => 'text-orange-500', 'bg' => 'bg-orange-500/10', 'border' => 'border-orange-500/20', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                                            'rejected' => ['color' => 'text-red-500', 'bg' => 'bg-red-500/10', 'border' => 'border-red-500/20', 'icon' => 'M6 18L18 6M6 6l12 12'],
                                            'scheduled' => ['color' => 'text-purple-500', 'bg' => 'bg-purple-500/10', 'border' => 'border-purple-500/20', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                        ];
                                        $conf = $statusConfig[$article->status] ?? $statusConfig['draft'];
                                    @endphp
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-xl {{ $conf['bg'] }} {{ $conf['color'] }} flex items-center justify-center border {{ $conf['border'] }} shadow-inner">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $conf['icon'] }}"></path></svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black uppercase tracking-widest {{ $conf['color'] }}">{{ $article->status }}</span>
                                            <span class="text-[8px] font-bold text-zinc-400 dark:text-zinc-600 uppercase tracking-tighter">Lifecycle Phase</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-8">
                                    <div class="flex flex-col gap-3 w-40">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[9px] font-black uppercase tracking-[0.2em] text-zinc-400">Interaction</span>
                                            <span class="text-xs font-black text-zinc-900 dark:text-white">{{ number_format($article->views_count ?? 0) }}</span>
                                        </div>
                                        <div class="relative w-full h-1.5 bg-zinc-100 dark:bg-white/5 rounded-full overflow-hidden">
                                            <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-1000 group-hover/row:brightness-125" style="width: {{ min(($article->views_count ?? 0) / 100, 100) }}%"></div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center gap-1.5 text-[8px] font-black text-zinc-500 uppercase">
                                                <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                {{ $article->comments_count ?? 0 }}
                                            </div>
                                            <div class="flex items-center gap-1.5 text-[8px] font-black text-zinc-500 uppercase">
                                                <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                                {{ number_format(($article->views_count ?? 0) * 0.1) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover/row:opacity-100 translate-x-4 group-hover/row:translate-x-0 transition-all duration-500">
                                        <button wire:click="edit({{ $article->id }})"
                                            class="h-12 w-12 bg-white dark:bg-zinc-800 text-zinc-400 hover:text-indigo-500 rounded-2xl border border-zinc-200 dark:border-white/10 shadow-sm hover:shadow-indigo-500/20 hover:scale-110 active:scale-95 transition-all"
                                            title="Refine Story">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button wire:click="delete({{ $article->id }})"
                                            wire:confirm="Permanent deletion: Are you sure you want to remove this story?"
                                            class="h-12 w-12 bg-white dark:bg-zinc-800 text-zinc-400 hover:text-red-500 rounded-2xl border border-zinc-200 dark:border-white/10 shadow-sm hover:shadow-red-500/20 hover:scale-110 active:scale-95 transition-all"
                                            title="Remove Permanently">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-10 py-40 text-center">
                                    <div class="relative inline-flex mb-10">
                                        <div class="absolute -inset-8 bg-indigo-500/10 blur-3xl rounded-full"></div>
                                        <div class="relative h-32 w-32 bg-zinc-100 dark:bg-white/5 rounded-[3rem] flex items-center justify-center shadow-inner">
                                            <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <h4 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight mb-4">Registry Inactive</h4>
                                    <p class="text-zinc-500 dark:text-zinc-400 max-w-md mx-auto text-lg font-medium leading-relaxed mb-10">Your editorial vault is currently empty. Start a new narrative to populate the registry.</p>
                                    <button wire:click="create" class="relative group px-10 py-5 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-[2rem] font-black text-xs uppercase tracking-[0.3em] overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-2xl">
                                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <span class="relative">Create First Narrative</span>
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($articles->hasPages())
                <div class="px-10 py-8 border-t border-zinc-100 dark:border-white/5 bg-zinc-50/50 dark:bg-white/[0.01]">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Story Editor Modal -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;"
        x-cloak>

        <div class="fixed inset-0 bg-zinc-950/80 backdrop-blur-sm transition-opacity" @click="isModalOpen = false">
        </div>

        <div class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
            <div class="relative w-full max-w-7xl bg-white dark:bg-zinc-950 rounded-[3.5rem] shadow-2xl border border-zinc-200 dark:border-white/10 overflow-hidden flex flex-col h-[90vh]"
                @click.stop>
                <!-- Premium Header -->
                <div class="px-12 py-10 border-b border-zinc-100 dark:border-white/5 flex items-center justify-between bg-white dark:bg-zinc-950 sticky top-0 z-30">
                    <div class="flex items-center gap-8">
                        <div class="relative">
                            <div class="absolute -inset-2 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                            <div class="relative h-14 w-14 bg-zinc-900 dark:bg-white rounded-2xl flex items-center justify-center shadow-2xl">
                                <svg class="w-7 h-7 text-white dark:text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-500/10 text-indigo-500 text-[9px] font-black uppercase tracking-[0.2em]">Story Studio v2.0</span>
                                @if($editingArticleId)
                                    <span class="px-2.5 py-1 rounded-lg bg-zinc-100 dark:bg-white/5 text-zinc-500 text-[9px] font-black uppercase tracking-[0.2em]">ID: #{{ $editingArticleId }}</span>
                                @endif
                            </div>
                            <h3 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight flex items-center gap-3">
                                {{ $editingArticleId ? 'Refining Masterpiece' : 'Crafting New Narrative' }}
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            </h3>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        @if($lastSaved)
                            <div class="hidden md:flex items-center gap-3 px-5 py-2.5 rounded-2xl bg-zinc-50 dark:bg-white/5 border border-zinc-100 dark:border-white/10">
                                <div class="flex flex-col items-end">
                                    <span class="text-[8px] font-black text-zinc-400 uppercase tracking-widest">Last Synced</span>
                                    <span class="text-[10px] font-bold text-zinc-600 dark:text-zinc-300">{{ $lastSaved }}</span>
                                </div>
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        @endif

                        <div class="h-10 w-px bg-zinc-100 dark:bg-white/5 mx-2"></div>

                        @if($editingArticleId)
                            <button type="button" wire:click="toggleHistory"
                                class="flex items-center gap-3 px-6 py-3.5 rounded-2xl bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-white/10 hover:border-indigo-500/50 hover:text-indigo-500 transition-all group shadow-sm">
                                <svg class="w-5 h-5 group-hover:rotate-[-20deg] transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-xs font-black uppercase tracking-widest">Chronicles</span>
                            </button>
                        @endif

                        <button type="button" @click="isModalOpen = false"
                            class="p-4 text-zinc-400 hover:text-red-500 hover:bg-red-500/5 rounded-2xl transition-all group">
                            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Auto-save trigger -->
                @if($editingArticleId)
                    <div wire:poll.30s="autoSave"></div>
                @endif

                <!-- Enhanced Form Content -->
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    <form wire:submit.prevent="save" class="p-12">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                            <!-- Creative Canvas (Left) -->
                            <div class="lg:col-span-8 space-y-12">
                                <div class="space-y-4">
                                    <label class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.2em] ml-2">Primary Headline</label>
                                    <input type="text" wire:model.blur="title"
                                        class="w-full bg-zinc-50 dark:bg-white/[0.02] border-none rounded-[2rem] px-8 py-7 text-3xl font-black text-zinc-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-zinc-300 dark:placeholder:text-zinc-700 shadow-sm"
                                        placeholder="What's the breaking story?">
                                    @error('title') <span class="text-red-500 text-[10px] font-black uppercase tracking-widest ml-8">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-8">
                                    <div class="space-y-4">
                                        <label class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.2em] ml-2">Slug Registry</label>
                                        <div class="relative">
                                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-zinc-400 text-xs font-bold">/story/</span>
                                            <input type="text" wire:model="slug"
                                                class="w-full bg-zinc-50 dark:bg-white/[0.02] border-none rounded-2xl pl-16 pr-6 py-4 text-xs font-bold text-zinc-500 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm"
                                                placeholder="auto-generated">
                                        </div>
                                        @error('slug') <span class="text-red-500 text-[10px] font-black uppercase tracking-widest ml-2">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="space-y-4">
                                        <label class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.2em] ml-2">Publication State</label>
                                        <div class="flex items-center gap-3 px-6 py-4 bg-zinc-50 dark:bg-white/[0.02] rounded-2xl border border-transparent">
                                            <span @class([
                                                'w-2 h-2 rounded-full animate-pulse',
                                                'bg-zinc-400' => $status === 'draft',
                                                'bg-indigo-500' => $status === 'submitted',
                                                'bg-emerald-500' => $status === 'published',
                                            ])></span>
                                            <span class="text-xs font-black uppercase tracking-widest text-zinc-900 dark:text-white">{{ str_replace('_', ' ', $status) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <label class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.2em] ml-2">Executive Summary</label>
                                    <textarea wire:model="excerpt"
                                        class="w-full bg-zinc-50 dark:bg-white/[0.02] border-none rounded-[2rem] p-8 text-base font-medium text-zinc-600 dark:text-zinc-400 focus:ring-4 focus:ring-indigo-500/10 transition-all resize-none h-40 leading-relaxed shadow-sm"
                                        placeholder="Write a hooks that captures attention in seconds..."></textarea>
                                    @error('excerpt') <span class="text-red-500 text-[10px] font-black uppercase tracking-widest ml-8">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-4">
                                    <div class="flex items-center justify-between ml-2">
                                        <label class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.2em]">Narrative Body</label>
                                        <div class="flex items-center gap-2 text-[10px] font-bold text-zinc-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Rich Text Enabled
                                        </div>
                                    </div>
                                    <div wire:ignore class="rich-text-wrapper relative group/editor" 
                                        x-data="{ content: @entangle('content') }"
                                        x-init="
                                            ClassicEditor
                                                .create($refs.editor, {
                                                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
                                                })
                                                .then(editor => {
                                                    editor.model.document.on('change:data', () => {
                                                        content = editor.getData();
                                                    });
                                                    $watch('content', value => {
                                                        if (value !== editor.getData()) {
                                                            editor.setData(value || '');
                                                        }
                                                    });
                                                })
                                        ">
                                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 rounded-[2.5rem] blur opacity-0 group-focus-within/editor:opacity-100 transition duration-500"></div>
                                        <textarea id="article-content" x-ref="editor"
                                            class="w-full hidden"
                                            wire:model="content"></textarea>
                                    </div>
                                    @error('content') <span class="text-red-500 text-[10px] font-black uppercase tracking-widest ml-8">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Editorial Control Panel (Right) -->
                            <div class="lg:col-span-4 space-y-10">
                                <!-- Visual Identity -->
                                <div class="p-8 rounded-[2.5rem] bg-zinc-50 dark:bg-white/[0.02] border border-zinc-100 dark:border-white/5 space-y-6">
                                    <label class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.2em]">Featured Asset</label>
                                    <div class="relative group aspect-[4/3] rounded-3xl bg-white dark:bg-zinc-900 border-2 border-dashed border-zinc-200 dark:border-white/10 overflow-hidden flex flex-col items-center justify-center text-center p-6 cursor-pointer hover:border-indigo-500 transition-all duration-500 shadow-sm">
                                        <input type="file" wire:model="featured_image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                        
                                        @if($featured_image)
                                            <img src="{{ $featured_image->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @elseif($editingArticleId && ($art = $articles->find($editingArticleId)) && $art->featured_image)
                                            <img src="{{ Storage::url($art->featured_image) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @endif

                                        <div class="relative z-0 flex flex-col items-center gap-4 group-hover:translate-y-[-5px] transition-transform duration-500">
                                            <div class="h-12 w-12 rounded-2xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors shadow-lg">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">Update Cover</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Metadata & Logic -->
                                <div class="p-8 rounded-[2.5rem] bg-zinc-50 dark:bg-white/[0.02] border border-zinc-100 dark:border-white/5 space-y-8">
                                    <div class="space-y-4">
                                        <label class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.2em]">Story Category</label>
                                        <select wire:model="category_id"
                                            class="w-full bg-white dark:bg-zinc-900 border-none rounded-2xl px-6 py-4 text-xs font-bold text-zinc-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 shadow-sm appearance-none cursor-pointer">
                                            <option value="">Choose Domain</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if($status === 'scheduled')
                                        <div class="space-y-4">
                                            <label class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.2em]">Launch Sequence</label>
                                            <input type="datetime-local" wire:model="published_at"
                                                class="w-full bg-white dark:bg-zinc-900 border-none rounded-2xl px-6 py-4 text-xs font-bold text-zinc-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 shadow-sm">
                                        </div>
                                    @endif

                                    <div class="grid grid-cols-2 gap-4">
                                        <label @class([
                                            'relative flex flex-col items-center justify-center p-5 rounded-[2rem] border-2 cursor-pointer transition-all duration-300 group',
                                            'bg-indigo-500/5 border-indigo-500 shadow-lg shadow-indigo-500/10' => $is_featured,
                                            'bg-white dark:bg-zinc-900 border-transparent hover:border-zinc-200 dark:hover:border-white/10' => !$is_featured,
                                        ])>
                                            <input type="checkbox" wire:model.live="is_featured" class="hidden">
                                            <div @class([
                                                'h-10 w-10 rounded-xl flex items-center justify-center mb-3 transition-colors',
                                                'bg-indigo-500 text-white' => $is_featured,
                                                'bg-zinc-100 dark:bg-zinc-800 text-zinc-400' => !$is_featured,
                                            ])>
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"></path></svg>
                                            </div>
                                            <span @class([
                                                'text-[9px] font-black uppercase tracking-widest',
                                                'text-indigo-600 dark:text-indigo-400' => $is_featured,
                                                'text-zinc-500' => !$is_featured,
                                            ])>Featured</span>
                                        </label>

                                        <label @class([
                                            'relative flex flex-col items-center justify-center p-5 rounded-[2rem] border-2 cursor-pointer transition-all duration-300 group',
                                            'bg-red-500/5 border-red-500 shadow-lg shadow-red-500/10' => $is_breaking,
                                            'bg-white dark:bg-zinc-900 border-transparent hover:border-zinc-200 dark:hover:border-white/10' => !$is_breaking,
                                        ])>
                                            <input type="checkbox" wire:model.live="is_breaking" class="hidden">
                                            <div @class([
                                                'h-10 w-10 rounded-xl flex items-center justify-center mb-3 transition-colors',
                                                'bg-red-500 text-white' => $is_breaking,
                                                'bg-zinc-100 dark:bg-zinc-800 text-zinc-400' => !$is_breaking,
                                            ])>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            </div>
                                            <span @class([
                                                'text-[9px] font-black uppercase tracking-widest',
                                                'text-red-600 dark:text-red-400' => $is_breaking,
                                                'text-zinc-500' => !$is_breaking,
                                            ])>Breaking</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Social & Tags -->
                                <div class="p-8 rounded-[2.5rem] bg-zinc-50 dark:bg-white/[0.02] border border-zinc-100 dark:border-white/5 space-y-6">
                                    <label class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.2em]">Story Keywords</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($tags as $tag)
                                            <label class="cursor-pointer">
                                                <input type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}" class="hidden peer">
                                                <span class="inline-block px-4 py-2 rounded-xl text-[10px] font-bold bg-white dark:bg-zinc-900 text-zinc-500 border border-transparent peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-indigo-500/20 hover:border-indigo-500/30 transition-all">
                                                    #{{ $tag->name }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Editorial Workflow -->
                                @if(auth()->user()->can('edit any article'))
                                    <div class="p-8 rounded-[2.5rem] bg-zinc-900 dark:bg-indigo-600/10 border border-zinc-800 dark:border-indigo-500/20 space-y-6">
                                        <label class="text-[11px] font-black text-zinc-400 dark:text-indigo-400 uppercase tracking-[0.2em]">Editorial Assignment</label>
                                        <select wire:model="editor_id"
                                            class="w-full bg-zinc-800 dark:bg-zinc-900 border-none rounded-2xl px-6 py-4 text-xs font-bold text-white focus:ring-4 focus:ring-indigo-500/30 appearance-none cursor-pointer">
                                            <option value="">Unassigned</option>
                                            @foreach($editors as $editor)
                                                <option value="{{ $editor->id }}">{{ $editor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                @if(count($remarks) > 0 || (auth()->user()->can('reject article') && $status === 'submitted'))
                                    <div class="p-8 rounded-[2.5rem] bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-white/5 space-y-6 shadow-xl">
                                        <div class="flex items-center justify-between">
                                            <label class="text-[11px] font-black text-zinc-400 uppercase tracking-[0.2em]">Editorial Feed</label>
                                            <span class="px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-white/5 text-[8px] font-black text-zinc-500">{{ count($remarks) }}</span>
                                        </div>

                                        @if(auth()->user()->can('reject article') && $status === 'submitted')
                                            <div class="space-y-3">
                                                <textarea wire:model="remark"
                                                    class="w-full bg-zinc-50 dark:bg-white/5 border-none rounded-2xl p-5 text-xs font-medium text-zinc-600 dark:text-zinc-400 focus:ring-2 focus:ring-red-500/20 transition-all resize-none h-28"
                                                    placeholder="Provide constructive feedback..."></textarea>
                                                @error('remark') <span class="text-red-500 text-[10px] font-black uppercase tracking-widest ml-2">{{ $message }}</span> @enderror
                                            </div>
                                        @endif

                                        <div class="space-y-4 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                                            @foreach($remarks as $rem)
                                                <div class="relative pl-6 before:absolute before:left-0 before:top-2 before:bottom-2 before:w-0.5 before:bg-indigo-500/20 before:rounded-full">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <span class="text-[9px] font-black text-zinc-900 dark:text-white uppercase">{{ $rem->user->name }}</span>
                                                        <span class="text-[8px] font-medium text-zinc-400 uppercase">{{ $rem->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed">{{ $rem->remark }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Premium Bottom Navigation -->
                <div class="px-12 py-10 border-t border-zinc-100 dark:border-white/5 bg-white dark:bg-zinc-950/80 backdrop-blur-xl flex items-center justify-between z-30">
                    <div class="flex items-center gap-6">
                        <button type="button" @click="isModalOpen = false"
                            class="group flex items-center gap-2 text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-all">
                            <span class="h-8 w-8 rounded-full bg-zinc-50 dark:bg-white/5 flex items-center justify-center group-hover:bg-zinc-100 dark:group-hover:bg-white/10 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </span>
                            <span class="text-xs font-black uppercase tracking-widest">Abandon Draft</span>
                        </button>
                    </div>

                    <div class="flex items-center gap-6">
                        @if($status === 'draft')
                            <button type="button" wire:click="save"
                                class="px-10 py-4 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-2xl shadow-zinc-500/20 flex items-center gap-3 group">
                                <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Save Draft
                            </button>
                            <button type="button" wire:click="submitForReview"
                                class="relative group px-12 py-4 bg-indigo-600 text-white rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:bg-indigo-700 hover:scale-105 active:scale-95 transition-all shadow-2xl shadow-indigo-500/40 flex items-center gap-3 overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Dispatch for Review
                            </button>
                        @elseif($status === 'submitted' || $status === 'in_review')
                            @if(auth()->user()->can('approve article'))
                                <button type="button" wire:click="reject"
                                    class="px-10 py-4 bg-red-500 text-white rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:bg-red-600 hover:scale-105 active:scale-95 transition-all shadow-2xl shadow-red-500/20 flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Reject Story
                                </button>
                                <button type="button" wire:click="approve"
                                    class="px-10 py-4 bg-emerald-500 text-white rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:bg-emerald-600 hover:scale-105 active:scale-95 transition-all shadow-2xl shadow-emerald-500/20 flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    Approve & Publish
                                </button>
                            @else
                                <div class="flex items-center gap-3 px-6 py-4 bg-amber-500/5 border border-amber-500/20 rounded-2xl">
                                    <svg class="w-4 h-4 text-amber-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-600">Under Review</span>
                                </div>
                                <button type="button" wire:click="save"
                                    class="px-10 py-4 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-2xl shadow-zinc-500/20">
                                    Sync Updates
                                </button>
                            @endif
                        @else
                            <button type="button" wire:click="save"
                                class="px-12 py-4 bg-indigo-600 text-white rounded-[1.5rem] text-xs font-black uppercase tracking-widest hover:bg-indigo-700 hover:scale-105 active:scale-95 transition-all shadow-2xl shadow-indigo-500/40 flex items-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Commit Changes
                            </button>
                        @endif
                    </div>
                </div>

                <!-- History Side Panel -->
                <div x-show="$wire.showHistory" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="absolute inset-y-0 right-0 w-96 bg-white dark:bg-zinc-900 border-l border-zinc-200 dark:border-white/10 shadow-2xl z-20 overflow-hidden flex flex-col"
                    style="display: none;">
                    
                    <div class="p-8 border-b border-zinc-100 dark:border-white/5 flex items-center justify-between bg-zinc-50/50 dark:bg-white/[0.02]">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-xl bg-indigo-500/10 text-indigo-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-black text-zinc-900 dark:text-white uppercase tracking-widest">Version History</h4>
                        </div>
                        <button type="button" wire:click="toggleHistory" class="text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-6 space-y-4">
                        @if(count($selectedVersions) > 0)
                            <div class="p-4 bg-indigo-600 rounded-2xl text-white shadow-lg shadow-indigo-500/20 mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] font-black uppercase tracking-widest opacity-80">Selection ({{ count($selectedVersions) }}/2)</span>
                                    <button wire:click="$set('selectedVersions', [])" class="text-[10px] font-black uppercase tracking-widest underline decoration-white/30 hover:decoration-white transition-all">Clear</button>
                                </div>
                                @if(count($selectedVersions) === 2)
                                    <button wire:click="compareVersions" class="w-full py-2.5 bg-white text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-zinc-50 transition-all shadow-sm">Compare Versions</button>
                                @else
                                    <p class="text-[10px] font-medium opacity-90 italic">Select one more version to compare changes...</p>
                                @endif
                            </div>
                        @endif

                        <div class="relative space-y-6 before:absolute before:inset-0 before:left-4 before:h-full before:w-0.5 before:bg-zinc-100 dark:before:bg-white/5 before:rounded-full">
                            @forelse($versions as $version)
                                <div class="relative pl-10 group">
                                    <div @class([
                                        'absolute left-3 top-1.5 w-2.5 h-2.5 rounded-full ring-4 transition-all z-10',
                                        'bg-indigo-500 ring-indigo-500/20' => in_array($version->id, $selectedVersions),
                                        'bg-zinc-300 dark:bg-zinc-700 ring-transparent group-hover:bg-indigo-500 group-hover:ring-indigo-500/20' => !in_array($version->id, $selectedVersions),
                                    ])></div>

                                    <div @class([
                                        'p-4 rounded-2xl border transition-all cursor-pointer',
                                        'bg-indigo-500/5 border-indigo-500/20' => in_array($version->id, $selectedVersions),
                                        'bg-zinc-50 dark:bg-white/[0.02] border-transparent hover:border-zinc-200 dark:hover:border-white/10' => !in_array($version->id, $selectedVersions),
                                    ]) wire:click="selectVersion({{ $version->id }})">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[10px] font-black text-zinc-900 dark:text-white uppercase tracking-widest">Version {{ $version->version_number }}</span>
                                            <span @class([
                                                'px-2 py-0.5 rounded-lg text-[8px] font-black uppercase tracking-widest border',
                                                'bg-zinc-100 dark:bg-white/5 text-zinc-500 border-zinc-200 dark:border-white/10' => $version->trigger_type === 'auto',
                                                'bg-indigo-500/10 text-indigo-500 border-indigo-500/20' => $version->trigger_type === 'manual',
                                                'bg-amber-500/10 text-amber-500 border-amber-500/20' => $version->trigger_type === 'submitted',
                                                'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' => in_array($version->trigger_type, ['approved', 'published']),
                                            ])>{{ $version->trigger_type }}</span>
                                        </div>
                                        <p class="text-xs font-black text-zinc-900 dark:text-white mb-1 truncate">{{ $version->title }}</p>
                                        <div class="flex items-center justify-between text-[9px] font-medium text-zinc-500">
                                            <span>{{ $version->user->name ?? 'System' }}</span>
                                            <span>{{ $version->created_at->diffForHumans() }}</span>
                                        </div>

                                        <div class="mt-3 pt-3 border-t border-zinc-200/50 dark:border-white/5 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" wire:click.stop="previewVersion({{ $version->id }})" class="flex-1 py-1.5 rounded-lg bg-zinc-200 dark:bg-white/10 text-[9px] font-black uppercase tracking-widest hover:bg-zinc-300 dark:hover:bg-white/20 transition-all">Preview</button>
                                            <button type="button" wire:click.stop="restoreVersion({{ $version->id }})" 
                                                wire:confirm="Are you sure you want to restore Version {{ $version->version_number }}? Current changes will be snapshotted."
                                                class="flex-1 py-1.5 rounded-lg bg-indigo-500 text-white text-[9px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-sm">Restore</button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <p class="text-xs font-medium text-zinc-500 italic">No versions recorded yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Version Preview Modal -->
                @if($versionPreview)
                    <div x-show="$wire.versionPreview" 
                        class="fixed inset-0 z-[70] flex items-center justify-center p-4 sm:p-6"
                        style="display: none;" x-cloak>
                        <div class="fixed inset-0 bg-zinc-950/90 backdrop-blur-md" wire:click="closePreview"></div>
                        <div class="relative w-full max-w-4xl bg-white dark:bg-zinc-950 rounded-[3rem] shadow-2xl border border-zinc-200 dark:border-white/10 overflow-hidden flex flex-col max-h-[90vh]">
                            <div class="p-8 border-b border-zinc-100 dark:border-white/5 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xl font-black text-zinc-900 dark:text-white tracking-tight">Version {{ $versionPreview->version_number }} Preview</h4>
                                    <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mt-1">
                                        Saved by {{ $versionPreview->user->name ?? 'System' }} • {{ $versionPreview->created_at->format('M d, Y H:i') }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button wire:click="restoreVersion({{ $versionPreview->id }})" class="px-6 py-2.5 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 transition-all">Restore This Version</button>
                                    <button wire:click="closePreview" class="p-3 text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex-1 overflow-y-auto p-10 prose dark:prose-invert max-w-none">
                                <h1 class="text-3xl font-black tracking-tight mb-8">{{ $versionPreview->title }}</h1>
                                <div class="text-zinc-600 dark:text-zinc-400 font-medium text-lg leading-relaxed mb-8 border-l-4 border-indigo-500/20 pl-6">
                                    {{ $versionPreview->excerpt }}
                                </div>
                                <div class="content-preview text-zinc-800 dark:text-zinc-200 leading-loose">
                                    {!! $versionPreview->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Diff Modal -->
                @if($diffData)
                    <div x-show="$wire.compareMode" 
                        class="fixed inset-0 z-[70] flex items-center justify-center p-4 sm:p-6"
                        style="display: none;" x-cloak
                        x-on:render-diff.window="renderDiff($event.detail.old, $event.detail.new, 'diff-viewer')">
                        <div class="fixed inset-0 bg-zinc-950/90 backdrop-blur-md" wire:click="$set('compareMode', false)"></div>
                        <div class="relative w-full max-w-7xl bg-white dark:bg-zinc-950 rounded-[3rem] shadow-2xl border border-zinc-200 dark:border-white/10 overflow-hidden flex flex-col max-h-[90vh]">
                            <div class="p-8 border-b border-zinc-100 dark:border-white/5 flex items-center justify-between">
                                <div class="flex items-center gap-6">
                                    <h4 class="text-xl font-black text-zinc-900 dark:text-white tracking-tight">Version Comparison</h4>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-zinc-100 dark:bg-white/5 border border-zinc-200 dark:border-white/10">
                                            <span class="w-2 h-2 rounded-full bg-zinc-400"></span>
                                            <span class="text-[9px] font-black uppercase text-zinc-500">V{{ $diffData['old']->version_number }}</span>
                                        </div>
                                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                        <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20">
                                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                            <span class="text-[9px] font-black uppercase text-indigo-500">V{{ $diffData['new']->version_number }}</span>
                                        </div>
                                    </div>
                                </div>
                                <button wire:click="$set('compareMode', false)" class="p-3 text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-1 overflow-y-auto p-8">
                                <div id="diff-viewer" class="rounded-2xl overflow-hidden border border-zinc-100 dark:border-white/5 shadow-inner">
                                    <!-- Diff rendered here -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <script>
                    window.addEventListener('render-diff', event => {
                        setTimeout(() => {
                            if (window.renderDiff) {
                                window.renderDiff(event.detail.old, event.detail.new, 'diff-viewer');
                            }
                        }, 200);
                    });
                </script>
            </div>
        </div>
    </div>
</div>