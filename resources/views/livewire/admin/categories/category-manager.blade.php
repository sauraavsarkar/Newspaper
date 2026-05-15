<div class="p-8 bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">
                Category Hub
            </h2>
            <p class="text-gray-500 mt-2 font-medium">Organize and manage your news taxonomy with ease.</p>
        </div>
        <button wire:click="create" class="group relative inline-flex items-center justify-center px-8 py-3 font-bold text-white transition-all duration-200 bg-indigo-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create New Category
        </button>
    </div>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex items-center text-green-800 shadow-sm transition-all duration-500">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="font-semibold">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Data Table Container -->
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Category Details</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Slug / Identifier</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Visibility</th>
                        <th class="px-8 py-5 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Management</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($categories as $category)
                        <tr class="group hover:bg-indigo-50/30 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                                        {{ substr($category->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-gray-900 leading-tight">{{ $category->name }}</div>
                                        <div class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $category->description ?? 'No description provided.' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-mono font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                    /{{ $category->slug }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <button wire:click="toggleStatus({{ $category->id }})" 
                                        class="relative inline-flex items-center cursor-pointer transition-all duration-300">
                                    <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider
                                        {{ $category->is_active ? 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200' : 'bg-rose-100 text-rose-700 ring-1 ring-rose-200' }}">
                                        {{ $category->is_active ? '● Public' : '○ Private' }}
                                    </span>
                                </button>
                            </td>
                            <td class="px-8 py-6 text-right space-x-2">
                                <button wire:click="edit({{ $category->id }})" class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-sm border border-indigo-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="delete({{ $category->id }})" 
                                        onclick="confirm('Are you sure you want to delete this category?') || event.stopImmediatePropagation()"
                                        class="p-2.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm border border-rose-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="h-20 w-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="text-gray-400 font-medium">No categories found. Start by creating one!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Smart Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="$set('isModalOpen', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 px-8 py-10 text-white relative">
                        <button wire:click="$set('isModalOpen', false)" class="absolute top-6 right-6 p-2 rounded-full bg-white/10 hover:bg-white/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        <h3 class="text-3xl font-bold leading-6" id="modal-title">
                            {{ $editingCategoryId ? 'Update Category' : 'Design Category' }}
                        </h3>
                        <p class="mt-2 text-indigo-100 opacity-80 font-medium">Define the core taxonomy for your news feed.</p>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="bg-white px-8 pt-8 pb-10">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Category Name</label>
                                    <input type="text" wire:model.live="name" placeholder="e.g. Artificial Intelligence" class="block w-full px-4 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-200 font-medium @error('name') border-rose-500 @enderror">
                                    @error('name') <p class="mt-2 text-sm text-rose-600 font-bold flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">URL Slug</label>
                                    <div class="relative flex items-center">
                                        <span class="absolute left-4 text-gray-400 font-mono text-sm">/</span>
                                        <input type="text" wire:model="slug" class="block w-full pl-8 pr-4 py-4 rounded-2xl border-gray-200 bg-gray-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-200 font-mono text-sm @error('slug') border-rose-500 @enderror">
                                    </div>
                                    @error('slug') <p class="mt-2 text-sm text-rose-600 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Description</label>
                                    <textarea wire:model="description" rows="3" placeholder="What kind of news will be here?" class="block w-full px-4 py-4 rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-200 font-medium"></textarea>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-indigo-50 rounded-2xl border border-indigo-100">
                                    <div>
                                        <span class="block text-sm font-bold text-indigo-900">Active Status</span>
                                        <span class="text-xs text-indigo-600">Should this category be visible to readers?</span>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                        <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50/50 px-8 py-6 flex flex-row-reverse gap-3 rounded-b-3xl">
                            <button type="submit" class="inline-flex justify-center px-8 py-3 rounded-xl border border-transparent shadow-lg text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-indigo-100">
                                {{ $editingCategoryId ? 'Update Changes' : 'Create Category' }}
                            </button>
                            <button type="button" wire:click="$set('isModalOpen', false)" class="inline-flex justify-center px-8 py-3 rounded-xl border border-gray-200 shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-all duration-200">
                                Dismiss
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
