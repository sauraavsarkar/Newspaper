<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10 animate-in fade-in duration-700">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-6">
            <div class="relative group">
                <div class="h-24 w-24 rounded-[2rem] overflow-hidden border-4 border-white dark:border-zinc-800 shadow-2xl transition-transform duration-500 group-hover:scale-105">
                    @if($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" class="h-full w-full object-cover">
                    @elseif($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-3xl font-black uppercase">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <label class="absolute -bottom-2 -right-2 p-2 bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-100 dark:border-white/10 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-all">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <input type="file" wire:model="avatar" class="hidden">
                </label>
            </div>
            <div>
                <h1 class="text-4xl font-black text-zinc-900 dark:text-white tracking-tight">
                    {{ $isAdminView && $user->id !== auth()->id() ? 'Edit Staff Profile' : 'Account Settings' }}
                </h1>
                <p class="text-zinc-500 dark:text-zinc-400 mt-1 font-medium">
                    {{ $user->email }} • <span class="uppercase tracking-widest text-[10px] font-black {{ $user->status === 'active' ? 'text-emerald-500' : 'text-rose-500' }}">{{ $user->status }}</span>
                </p>
            </div>
        </div>
        <div class="flex gap-3">
            <button wire:click="save" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                Save Changes
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-600 dark:text-emerald-400 text-sm font-bold animate-in slide-in-from-top-2">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Core Info -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card rounded-[2.5rem] p-10 border border-zinc-200 dark:border-white/5 space-y-8">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-white/5 pb-6">
                    <div class="h-2 w-2 rounded-full bg-indigo-500"></div>
                    <h2 class="text-sm font-black uppercase tracking-widest text-zinc-400">Core Identity</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 ml-1">Display Name</label>
                        <input type="text" wire:model="name" class="w-full bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                        @error('name') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 ml-1">Username</label>
                        <input type="text" wire:model="username" class="w-full bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                        @error('username') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 ml-1">Email Address</label>
                        <input type="email" wire:model="email" class="w-full bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                        @error('email') <span class="text-rose-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 ml-1">Short Biography</label>
                        <textarea wire:model="bio" rows="4" class="w-full bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all"></textarea>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-[2.5rem] p-10 border border-zinc-200 dark:border-white/5 space-y-8">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-white/5 pb-6">
                    <div class="h-2 w-2 rounded-full bg-purple-500"></div>
                    <h2 class="text-sm font-black uppercase tracking-widest text-zinc-400">Contact & Presence</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 ml-1">Location</label>
                        <input type="text" wire:model="location" placeholder="e.g. London, UK" class="w-full bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 ml-1">Website</label>
                        <input type="text" wire:model="website" placeholder="https://" class="w-full bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 ml-1">Twitter URL</label>
                        <input type="text" wire:model="twitter_url" class="w-full bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 ml-1">LinkedIn URL</label>
                        <input type="text" wire:model="linkedin_url" class="w-full bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 ml-1">Phone (Private)</label>
                        <input type="text" wire:model="phone" class="w-full bg-zinc-50 dark:bg-zinc-950/50 border border-zinc-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Admin & Meta -->
        <div class="space-y-8">
            
            @if($isAdminView)
            <!-- Admin Controls -->
            <div class="glass-card rounded-[2.5rem] p-8 border border-rose-500/20 bg-rose-500/5 space-y-6">
                <div class="flex items-center gap-3 border-b border-rose-500/10 pb-4">
                    <div class="h-2 w-2 rounded-full bg-rose-500"></div>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-500">System Authority</h2>
                </div>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-rose-500/60 ml-1">Access Role</label>
                        <select wire:model="selectedRole" class="w-full bg-white dark:bg-zinc-900 border border-rose-500/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-rose-500 transition-all">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-rose-500/60 ml-1">Account Status</label>
                        <select wire:model="status" class="w-full bg-white dark:bg-zinc-900 border border-rose-500/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-rose-500 transition-all">
                            <option value="active">Active</option>
                            <option value="suspended">Suspended</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>

                    <div class="pt-4 space-y-3">
                        <button wire:click="sendResetLink" class="w-full py-3 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-white/5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-zinc-50 transition-all">
                            Send Reset Link
                        </button>
                        @if($two_factor_enabled)
                        <button wire:click="revokeTwoFactor" class="w-full py-3 bg-rose-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 transition-all">
                            Revoke 2FA
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Journalist Specific -->
            @if($user->hasRole('Journalist') || $selectedRole === 'Journalist')
            <div class="glass-card rounded-[2.5rem] p-8 border border-emerald-500/20 bg-emerald-500/5 space-y-6">
                <div class="flex items-center gap-3 border-b border-emerald-500/10 pb-4">
                    <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500">Editorial Details</h2>
                </div>
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-emerald-500/60 ml-1">Assigned Beat</label>
                        <input type="text" wire:model="beat" placeholder="e.g. Politics, Tech" class="w-full bg-white dark:bg-zinc-900 border border-emerald-500/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-emerald-500/60 ml-1">Public Byline</label>
                        <input type="text" wire:model="byline" placeholder="e.g. Senior Editor" class="w-full bg-white dark:bg-zinc-900 border border-emerald-500/10 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                </div>
            </div>
            @endif
            @endif

            <!-- Stats (Read-only for all, but only shown to Admin or Self) -->
            <div class="glass-card rounded-[2.5rem] p-8 border border-zinc-200 dark:border-white/5 space-y-6">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-white/5 pb-4">
                    <div class="h-2 w-2 rounded-full bg-zinc-400"></div>
                    <h2 class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Insights & History</h2>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-950/50 rounded-2xl border border-zinc-100 dark:border-white/5">
                        <div class="text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-1">Articles</div>
                        <div class="text-xl font-black text-zinc-900 dark:text-white">{{ $articleCount }}</div>
                    </div>
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-950/50 rounded-2xl border border-zinc-100 dark:border-white/5">
                        <div class="text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-1">Total Views</div>
                        <div class="text-xl font-black text-zinc-900 dark:text-white">{{ number_format($totalViews) }}</div>
                    </div>
                </div>

                <div class="space-y-4 pt-2">
                    <div class="flex justify-between text-[10px] font-medium">
                        <span class="text-zinc-500 uppercase tracking-widest">Joined</span>
                        <span class="text-zinc-900 dark:text-zinc-100 font-bold">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($isAdminView)
                    <div class="flex justify-between text-[10px] font-medium">
                        <span class="text-zinc-500 uppercase tracking-widest">Last Login</span>
                        <span class="text-zinc-900 dark:text-zinc-100 font-bold">{{ $user->last_login_at?->diffForHumans() ?? 'Never' }}</span>
                    </div>
                    <div class="flex justify-between text-[10px] font-medium">
                        <span class="text-zinc-500 uppercase tracking-widest">Login IP</span>
                        <span class="text-zinc-900 dark:text-zinc-100 font-bold font-mono">{{ $user->last_login_ip ?? 'N/A' }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
