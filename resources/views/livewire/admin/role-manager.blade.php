<div class="py-6 space-y-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">
                Authority Nexus
            </h1>
            <p class="text-zinc-500 dark:text-zinc-400 mt-2 font-medium">Define roles and orchestration permissions.</p>
        </div>
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative w-full md:w-96 group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-400 dark:text-zinc-500 group-focus-within:text-indigo-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" wire:model.live="searchTerm" placeholder="Search roles..."
                    class="w-full bg-white/70 dark:bg-zinc-900/50 border border-zinc-200 dark:border-white/5 rounded-2xl py-3 pl-11 pr-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
            </div>
            <button wire:click="syncAll"
                wire:loading.attr="disabled"
                class="shrink-0 flex items-center gap-2 px-6 py-3 bg-zinc-800 text-white rounded-xl text-sm font-bold hover:bg-zinc-900 transition-all shadow-lg border border-white/5 group">
                <svg wire:loading.remove wire:target="syncAll" class="w-5 h-5 text-indigo-400 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <svg wire:loading wire:target="syncAll" class="w-5 h-5 animate-spin text-indigo-400" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Master Sync</span>
            </button>
            <button wire:click="create"
                class="shrink-0 flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>New Role</span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-600 dark:text-emerald-400 text-sm font-bold animate-in fade-in slide-in-from-top-2">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl text-rose-600 dark:text-rose-400 text-sm font-bold animate-in fade-in slide-in-from-top-2">
            {{ session('error') }}
        </div>
    @endif

    <!-- Roles Table -->
    <div class="glass-card rounded-[2rem] overflow-hidden border border-zinc-200 dark:border-white/5">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-zinc-200 dark:border-white/5 bg-zinc-50/50 dark:bg-zinc-900/50">
                    <th class="px-8 py-5 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Role Name</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Capabilities</th>
                    <th class="px-8 py-5 text-right text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-white/5">
                @forelse ($roles as $role)
                    <tr class="group hover:bg-indigo-500/5 transition-colors duration-300">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-500/20">
                                    {{ substr($role->name, 0, 1) }}
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-zinc-900 dark:text-zinc-100">{{ $role->name }}</span>
                                    @if($role->name === 'Admin')
                                        <span class="ml-2 text-[9px] px-1.5 py-0.5 bg-indigo-500 text-white rounded font-black uppercase">System</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($role->permissions as $permission)
                                    <span class="px-2 py-0.5 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 text-[9px] font-bold uppercase rounded-md border border-zinc-200 dark:border-white/5">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                                @if($role->permissions->count() === 0)
                                    <span class="text-[10px] text-zinc-400 italic font-medium">No permissions assigned</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="edit({{ $role->id }})" class="p-2 rounded-lg bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-white/5 text-zinc-500 hover:text-indigo-600 transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                @if($role->name !== 'Admin')
                                    <button wire:click="delete({{ $role->id }})" 
                                            onclick="confirm('Are you sure you want to delete this role?') || event.stopImmediatePropagation()"
                                            class="p-2 rounded-lg bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-white/5 text-zinc-500 hover:text-rose-600 transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center">
                            <p class="text-sm font-bold text-zinc-400 dark:text-zinc-600 uppercase tracking-widest">No roles defined</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-8 py-4 bg-zinc-50/50 dark:bg-zinc-900/50 border-t border-zinc-200 dark:border-white/5">
            {{ $roles->links() }}
        </div>
    </div>

    <!-- Role Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
            <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm animate-in fade-in duration-300" wire:click="$set('isModalOpen', false)"></div>
            
            <div class="relative bg-white dark:bg-zinc-900 w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-zinc-200 dark:border-white/10 overflow-hidden animate-in zoom-in-95 duration-300">
                <div class="p-8 border-b border-zinc-100 dark:border-white/5">
                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white">{{ $editingRoleId ? 'Edit Configuration' : 'Forge New Role' }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 font-medium">Configure authority level and capability matrix.</p>
                </div>

                <div class="p-8 space-y-8 max-h-[60vh] overflow-y-auto custom-scrollbar">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Identity Designation</label>
                        <input type="text" wire:model="name" placeholder="e.g. Lead Editor"
                            class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-white/5 rounded-2xl py-4 px-6 text-sm font-bold text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                        @error('name') <p class="text-xs text-rose-500 font-bold mt-1 px-2">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Capability Matrix</label>
                            @if($name === 'Admin')
                                <span class="px-3 py-1 bg-indigo-500/10 text-indigo-500 text-[9px] font-black uppercase rounded-full border border-indigo-500/20">Omnipotent Access Enabled</span>
                            @endif
                        </div>
                        
                        @if($name === 'Admin')
                            <div class="p-6 rounded-3xl bg-indigo-500/5 border border-indigo-500/10 flex items-center gap-4">
                                <div class="h-12 w-12 rounded-2xl bg-indigo-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Full Authority Granted</h4>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 font-medium">As the system administrator, this role bypasses all capability checks.</p>
                                </div>
                            </div>
                        @else
                            @foreach($permissionGroups as $group => $permissions)
                                <div class="space-y-4">
                                    <h4 class="text-[9px] font-black text-indigo-500 uppercase tracking-[0.2em]">{{ $group }}</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach($permissions as $permission)
                                            <label class="relative flex items-start p-4 rounded-2xl border border-zinc-100 dark:border-white/5 bg-zinc-50 dark:bg-zinc-950/50 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-all group">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission }}"
                                                        class="h-5 w-5 rounded-lg border-zinc-300 dark:border-white/10 text-indigo-600 focus:ring-indigo-500 transition-all bg-white dark:bg-zinc-900">
                                                </div>
                                                <div class="ml-4 text-sm">
                                                    <span class="font-bold text-zinc-900 dark:text-zinc-100 uppercase text-[10px] tracking-tight">{{ $permission }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="p-8 bg-zinc-50/50 dark:bg-zinc-950/50 border-t border-zinc-100 dark:border-white/5 flex items-center justify-end gap-4">
                    <button wire:click="$set('isModalOpen', false)" class="px-6 py-3 text-sm font-bold text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">Cancel</button>
                    <button wire:click="save" class="px-8 py-3 bg-indigo-600 text-white rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20">
                        Synchronize Matrix
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
