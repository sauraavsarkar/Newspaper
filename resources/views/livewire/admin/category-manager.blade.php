<div class="py-6 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2
                class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">
                Category Hub
            </h2>
            <p class="text-zinc-500 dark:text-zinc-400 mt-2 font-medium">Organize and manage your news taxonomy with
                ease.</p>
        </div>
        <button wire:click="create"
            class="group relative inline-flex items-center justify-center px-8 py-3 font-bold text-white transition-all duration-200 bg-indigo-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/30">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Category
        </button>
    </div>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center text-emerald-600 dark:text-emerald-400 shadow-sm transition-all duration-500">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="font-semibold">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Data Table Container -->
    <div class="glass-card rounded-[2rem] overflow-hidden border border-zinc-200 dark:border-white/5">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-white/5">
                <thead>
                    <tr class="bg-zinc-50/50 dark:bg-zinc-900/50">
                        <th
                            class="px-8 py-5 text-left text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">
                            Category Details</th>
                        <th
                            class="px-8 py-5 text-left text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">
                            Slug / Identifier</th>
                        <th
                            class="px-8 py-5 text-left text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">
                            Visibility</th>
                        <th
                            class="px-8 py-5 text-right text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">
                            Management</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-white/5">
                    @forelse ($categories as $category)
                        <tr class="group hover:bg-zinc-100/50 dark:hover:bg-indigo-500/10 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div
                                        class="h-12 w-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                                        {{ substr($category->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-zinc-900 dark:text-zinc-100 leading-tight">
                                            {{ $category->name }}</div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-1">
                                            {{ $category->description ?? 'No description provided.' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-mono font-medium bg-zinc-100 dark:bg-zinc-800/50 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-white/5">
                                    /{{ $category->slug }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <button wire:click="toggleStatus({{ $category->id }})"
                                    class="relative inline-flex items-center cursor-pointer transition-all duration-300">
                                    <span
                                        class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider
                                            {{ $category->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 ring-1 ring-emerald-500/30' : 'bg-rose-500/10 text-rose-600 dark:text-rose-400 ring-1 ring-rose-500/30' }}">
                                        {{ $category->is_active ? '● Public' : '○ Private' }}
                                    </span>
                                </button>
                            </td>
                            <td class="px-8 py-6 text-right space-x-2">
                                <button wire:click="edit({{ $category->id }})"
                                    class="p-2.5 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-500 dark:hover:text-white transition-all duration-300 border border-transparent hover:border-indigo-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <button wire:click="delete({{ $category->id }})"
                                    onclick="confirm('Are you sure you want to delete this category?') || event.stopImmediatePropagation()"
                                    class="p-2.5 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-rose-500 hover:text-white dark:hover:bg-rose-500 dark:hover:text-white transition-all duration-300 border border-transparent hover:border-rose-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="h-20 w-20 bg-zinc-100 dark:bg-zinc-800/50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-zinc-400 dark:text-zinc-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-zinc-500 dark:text-zinc-400 font-medium">No categories found. Start by
                                        creating one!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="px-8 py-6 bg-zinc-50/50 dark:bg-zinc-900/50 border-t border-zinc-200 dark:border-white/5">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Smart Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-zinc-900/80 backdrop-blur-sm transition-opacity" aria-hidden="true"
                    wire:click="$set('isModalOpen', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white dark:bg-zinc-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-zinc-200 dark:border-zinc-700">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 px-8 py-10 text-white relative">
                        <button wire:click="$set('isModalOpen', false)"
                            class="absolute top-6 right-6 p-2 rounded-full bg-white/10 hover:bg-white/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <h3 class="text-3xl font-bold leading-6" id="modal-title">
                            {{ $editingCategoryId ? 'Update Category' : 'Design Category' }}
                        </h3>
                        <p class="mt-2 text-indigo-100 opacity-80 font-medium">Define the core taxonomy for your news feed.
                        </p>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="px-8 pt-8 pb-10">
                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2 uppercase tracking-wide">Category
                                        Name</label>
                                    <input type="text" wire:model.live="name" placeholder="e.g. Artificial Intelligence"
                                        class="block w-full px-4 py-4 rounded-2xl border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:bg-white dark:focus:bg-zinc-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 font-medium @error('name') border-rose-500 @enderror">
                                    @error('name') <p
                                        class="mt-2 text-sm text-rose-600 dark:text-rose-400 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                    </svg>{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2 uppercase tracking-wide">URL
                                        Slug</label>
                                    <div class="relative flex items-center">
                                        <span
                                            class="absolute left-4 text-zinc-400 dark:text-zinc-500 font-mono text-sm">/</span>
                                        <input type="text" wire:model="slug"
                                            class="block w-full pl-8 pr-4 py-4 rounded-2xl border-zinc-300 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800/50 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 font-mono text-sm @error('slug') border-rose-500 @enderror">
                                    </div>
                                    @error('slug') <p class="mt-2 text-sm text-rose-600 dark:text-rose-400 font-bold">
                                    {{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2 uppercase tracking-wide">Description</label>
                                    <textarea wire:model="description" rows="3"
                                        placeholder="What kind of news will be here?"
                                        class="block w-full px-4 py-4 rounded-2xl border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:bg-white dark:focus:bg-zinc-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 font-medium"></textarea>
                                </div>

                                <div
                                    class="flex items-center justify-between p-4 bg-indigo-50 dark:bg-indigo-500/10 rounded-2xl border border-indigo-100 dark:border-indigo-500/20">
                                    <div>
                                        <span class="block text-sm font-bold text-indigo-900 dark:text-indigo-400">Active
                                            Status</span>
                                        <span class="text-xs text-indigo-600 dark:text-indigo-300/70">Should this category
                                            be visible to readers?</span>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                        <div
                                            class="w-14 h-8 bg-zinc-300 dark:bg-zinc-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-500">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-zinc-50 dark:bg-zinc-900 px-8 py-6 flex flex-row-reverse gap-3 rounded-b-3xl border-t border-zinc-200 dark:border-zinc-800">
                            <button type="submit"
                                class="inline-flex justify-center px-8 py-3 rounded-xl border border-transparent shadow-lg text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-indigo-500/30">
                                {{ $editingCategoryId ? 'Update Changes' : 'Create Category' }}
                            </button>
                            <button type="button" wire:click="$set('isModalOpen', false)"
                                class="inline-flex justify-center px-8 py-3 rounded-xl border border-zinc-300 dark:border-zinc-700 shadow-sm text-sm font-bold text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none transition-all duration-200">
                                Dismiss
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>