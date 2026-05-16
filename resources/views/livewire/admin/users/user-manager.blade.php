<div class="py-6 space-y-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">
                Staff Registry
            </h1>
            <p class="text-zinc-500 dark:text-zinc-400 mt-2 font-medium">Manage user identities and role assignments.</p>
        </div>
        <div class="relative w-full md:w-96 group">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-400 dark:text-zinc-500 group-focus-within:text-indigo-500 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" wire:model.live="searchTerm" placeholder="Search staff..."
                class="w-full bg-white/70 dark:bg-zinc-900/50 border border-zinc-200 dark:border-white/5 rounded-2xl py-3 pl-11 pr-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-600 dark:text-emerald-400 text-sm font-bold animate-in fade-in slide-in-from-top-2">
            {{ session('message') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="glass-card rounded-[2rem] overflow-hidden border border-zinc-200 dark:border-white/5">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-zinc-200 dark:border-white/5 bg-zinc-50/50 dark:bg-zinc-900/50">
                    <th class="px-8 py-5 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">User</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Current Role</th>
                    <th class="px-8 py-5 text-right text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-white/5">
                @forelse ($users as $user)
                    <tr class="group hover:bg-indigo-500/5 transition-colors duration-300">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 font-bold border border-zinc-200 dark:border-white/5">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-zinc-900 dark:text-zinc-100">{{ $user->name }}</div>
                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @foreach($user->roles as $role)
                                <span class="px-3 py-1 bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase rounded-full border border-indigo-500/20">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                            @if($user->roles->count() === 0)
                                <span class="text-[10px] text-zinc-400 italic">No Role Assigned</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.users.edit', $user) }}" wire:navigate class="p-2.5 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-white/5 text-zinc-500 hover:text-indigo-600 transition-all shadow-sm inline-block">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center">
                            <p class="text-sm font-bold text-zinc-400 dark:text-zinc-600 uppercase tracking-widest">No users found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-8 py-4 bg-zinc-50/50 dark:bg-zinc-900/50 border-t border-zinc-200 dark:border-white/5">
            {{ $users->links() }}
        </div>
    </div>

</div>
