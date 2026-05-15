<div class="p-8 bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-600">
                Editorial Newsroom
            </h2>
            <p class="text-gray-500 mt-2 font-medium">Craft, manage, and publish your breaking stories.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
            <div class="relative flex-grow sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" wire:model.live="searchTerm" placeholder="Search articles..." class="block w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-200 shadow-sm font-medium">
            </div>
            <button wire:click="create" class="inline-flex items-center justify-center px-6 py-3 font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all duration-200 shadow-lg shadow-indigo-100">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Story
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-6 p-4 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center text-indigo-800 shadow-sm transition-all duration-500">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="font-semibold">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Article Grid/Table -->
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Story</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Category</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Author</th>
                        <th class="px-8 py-5 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($articles as $article)
                        <tr class="group hover:bg-indigo-50/20 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="relative mr-4 shrink-0">
                                        @if($article->featured_image)
                                            <img src="{{ asset('storage/' . $article->featured_image) }}" class="h-14 w-14 rounded-2xl object-cover shadow-md group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        @if($article->is_featured)
                                            <span class="absolute -top-1 -right-1 flex h-4 w-4">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-4 w-4 bg-yellow-500 shadow-sm border-2 border-white"></span>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-lg font-bold text-gray-900 leading-tight line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $article->title }}</div>
                                        <div class="text-xs text-gray-400 mt-1 font-mono uppercase tracking-tight">{{ $article->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-100">
                                    {{ $article->category->name }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest
                                    {{ $article->status === 'published' ? 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200' : '' }}
                                    {{ $article->status === 'draft' ? 'bg-amber-100 text-amber-700 ring-1 ring-amber-200' : '' }}
                                    {{ $article->status === 'scheduled' ? 'bg-blue-100 text-blue-700 ring-1 ring-blue-200' : '' }}
                                    {{ $article->status === 'archived' ? 'bg-rose-100 text-rose-700 ring-1 ring-rose-200' : '' }}
                                ">
                                    {{ $article->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs mr-2">
                                        {{ substr($article->author->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700">{{ $article->author->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right space-x-2">
                                <button wire:click="edit({{ $article->id }})" class="p-2 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-sm border border-indigo-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="delete({{ $article->id }})" 
                                        onclick="confirm('Are you sure you want to delete this story?') || event.stopImmediatePropagation()"
                                        class="p-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm border border-rose-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="h-20 w-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                    </div>
                                    <p class="text-gray-400 font-medium text-lg">No stories found. Let's write something today!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
            {{ $articles->links() }}
        </div>
    </div>

    <!-- Editorial Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="editorial-modal" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-md transition-opacity" aria-hidden="true" wire:click="$set('isModalOpen', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full border border-gray-100">
                    <div class="flex flex-col lg:flex-row h-[90vh]">
                        <!-- Left Panel: Form -->
                        <div class="flex-grow overflow-y-auto p-10 bg-white">
                            <div class="flex justify-between items-center mb-10">
                                <div>
                                    <h3 class="text-4xl font-black text-gray-900">{{ $editingArticleId ? 'Refine Story' : 'New Draft' }}</h3>
                                    <p class="text-gray-400 mt-1 font-medium">Compose your article with our advanced editor.</p>
                                </div>
                                <button wire:click="$set('isModalOpen', false)" class="p-3 rounded-2xl bg-gray-50 hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <form wire:submit.prevent="save" id="storyForm">
                                <div class="grid grid-cols-1 gap-8">
                                    <div class="space-y-6">
                                        <div class="group">
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Headline</label>
                                            <input type="text" wire:model.live="title" placeholder="A compelling headline goes here..." class="block w-full px-6 py-5 rounded-3xl border-gray-100 bg-gray-50/50 text-2xl font-bold focus:bg-white focus:ring-8 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all @error('title') border-rose-400 @enderror">
                                            @error('title') <p class="mt-2 text-sm text-rose-500 font-bold">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">URL Identifier</label>
                                                <div class="relative flex items-center">
                                                    <span class="absolute left-6 text-gray-300 font-mono text-sm">/</span>
                                                    <input type="text" wire:model="slug" class="block w-full pl-10 pr-6 py-4 rounded-2xl border-gray-100 bg-gray-50/50 focus:ring-8 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-mono text-sm @error('slug') border-rose-400 @enderror">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Primary Category</label>
                                                <select wire:model="category_id" class="block w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50/50 focus:ring-8 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-bold text-gray-700">
                                                    <option value="">Select a category...</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id') <p class="mt-2 text-sm text-rose-500 font-bold">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Brief Excerpt</label>
                                            <textarea wire:model="excerpt" rows="2" placeholder="Summary for homepages and SEO..." class="block w-full px-6 py-4 rounded-2xl border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-8 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-medium"></textarea>
                                        </div>

                                        <div wire:ignore>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 text-center">Body Content</label>
                                            <div class="rounded-3xl border border-gray-100 overflow-hidden shadow-inner">
                                                <div id="editor" x-data x-init="
                                                    ClassicEditor
                                                        .create($refs.ckeditor)
                                                        .then(editor => {
                                                            editor.model.document.on('change:data', () => {
                                                                @this.set('content', editor.getData());
                                                            })
                                                        })
                                                " x-ref="ckeditor">
                                                    {!! $content !!}
                                                </div>
                                            </div>
                                            @error('content') <p class="mt-2 text-sm text-rose-500 font-bold">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Right Panel: Metadata & Settings -->
                        <div class="lg:w-96 bg-gray-50/50 p-10 border-l border-gray-100 flex flex-col justify-between">
                            <div class="space-y-8">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-5 text-center">Cover Visual</label>
                                    <div class="relative group cursor-pointer h-48 rounded-3xl bg-white border-2 border-dashed border-gray-200 flex flex-col items-center justify-center overflow-hidden transition-all hover:border-indigo-400">
                                        @if ($featured_image)
                                            <img src="{{ $featured_image->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <span class="text-white font-bold text-sm bg-white/20 backdrop-blur-md px-4 py-2 rounded-full">Change Media</span>
                                            </div>
                                        @else
                                            <svg class="w-12 h-12 text-gray-300 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p class="text-[10px] text-gray-400 mt-2 font-black uppercase">Upload Image</p>
                                        @endif
                                        <input type="file" wire:model="featured_image" class="absolute inset-0 opacity-0 cursor-pointer">
                                    </div>
                                    @error('featured_image') <p class="mt-2 text-sm text-rose-500 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-5 text-center">Publishing Controls</label>
                                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-6">
                                        <div>
                                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-2">Target Status</label>
                                            <select wire:model="status" class="w-full py-2 bg-transparent font-black text-indigo-600 focus:outline-none cursor-pointer">
                                                <option value="draft">● Draft</option>
                                                <option value="published">● Published</option>
                                                <option value="scheduled">● Scheduled</option>
                                                <option value="archived">● Archived</option>
                                            </select>
                                        </div>
                                        <div class="flex items-center justify-between py-2 border-t border-gray-50">
                                            <span class="text-sm font-bold text-gray-700">Highlight Story</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" wire:model="is_featured" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-5 text-center">Taxonomy Tags</label>
                                    <div class="flex flex-wrap gap-2 max-h-48 overflow-y-auto bg-white p-6 rounded-3xl border border-gray-100 shadow-inner">
                                        @foreach($tags as $tag)
                                            <label class="group relative flex items-center cursor-pointer">
                                                <input type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}" class="sr-only peer">
                                                <div class="px-4 py-2 rounded-xl text-[10px] font-bold border border-gray-100 bg-gray-50 text-gray-500 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all">
                                                    #{{ $tag->name }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="pt-8">
                                <button type="submit" form="storyForm" wire:loading.attr="disabled" class="w-full py-5 rounded-[2rem] bg-indigo-600 text-white text-lg font-black shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center">
                                    <span wire:loading.remove> {{ $editingArticleId ? 'Update Story' : 'Launch Story' }} </span>
                                    <span wire:loading class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.ckeditor.com/classic/27.1.0/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable_inline { min-height: 400px; border: none !important; padding: 2rem !important; font-size: 1.125rem !important; line-height: 1.75 !important; }
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) { background-color: transparent !important; }
        .ck.ck-toolbar { border: none !important; background: #f9fafb !important; padding: 0.5rem 1rem !important; border-bottom: 1px solid #f3f4f6 !important; }
    </style>
</div>
