<div class="py-6 space-y-8" x-data="{ 
        view: @entangle('isModalOpen').live ? 'editor' : 'registry',
        sidebarOpen: true,
        isMobile: window.innerWidth < 1024
     }" x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 1024)">

    @push('styles')
        <style>
            /* CKEditor Custom Minimalist Style for Dark Mode */
            .ck-editor__editable_inline {
                min-height: 50vh;
                border: none !important;
                padding: 0 !important;
                font-size: 1.15rem !important;
                line-height: 1.9 !important;
                background: transparent !important;
                box-shadow: none !important;
            }

            .dark .ck-editor__editable_inline {
                color: #f4f4f5 !important;
            }

            .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
                background-color: transparent !important;
            }

            .ck.ck-toolbar {
                border: none !important;
                padding: 0.5rem 0 !important;
                margin-bottom: 2.5rem;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .ck.ck-button {
                border-radius: 8px !important;
            }

            .ck.ck-editor {
                border: none !important;
            }

            .dark .ck.ck-toolbar {
                background: rgba(24, 24, 27, 0.9) !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            }

            .dark .ck.ck-button {
                color: #a1a1aa !important;
            }

            .dark .ck.ck-button:hover,
            .dark .ck.ck-button.ck-on {
                background: rgba(255, 255, 255, 0.1) !important;
                color: #f4f4f5 !important;
            }

            .dark .ck.ck-tooltip__text {
                background: #27272a !important;
                color: #f4f4f5 !important;
            }
        </style>
    @endpush

    <!-- Registry View (Responsive Table/Cards) -->
    @if(!$isModalOpen)
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1
                    class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">
                    Story Journal
                </h1>
                <p class="text-zinc-500 dark:text-zinc-400 mt-2 font-medium">Manage and curate your editorial pipeline.</p>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative w-full md:w-96 group">
                    <span
                        class="absolute inset-y-0 left-0 flex items-center pl-4 text-zinc-400 dark:text-zinc-500 group-focus-within:text-indigo-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" wire:model.live="searchTerm" placeholder="Search archive..."
                        class="w-full bg-white/70 dark:bg-zinc-900/50 border border-zinc-200 dark:border-white/5 rounded-2xl py-3 pl-11 pr-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                </div>
                @can('create article')
                <button wire:click="create"
                    class="shrink-0 flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="hidden xs:inline">Draft Story</span>
                </button>
                @endcan
            </div>
        </div>

        <!-- Desktop View -->
        <div class="hidden lg:block glass-card rounded-[2rem] overflow-hidden border border-zinc-200 dark:border-white/5">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-white/5 bg-zinc-50/50 dark:bg-zinc-900/50">
                        <th
                            class="px-8 py-5 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">
                            Story Details</th>
                        <th
                            class="px-8 py-5 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">
                            Category</th>
                        <th
                            class="px-8 py-5 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">
                            Status</th>
                        <th
                            class="px-8 py-5 text-right text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-white/5">
                    @forelse ($articles as $article)
                        <tr class="group hover:bg-zinc-100/50 dark:hover:bg-indigo-500/10 transition-colors duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-5">
                                    <div
                                        class="h-16 w-16 rounded-2xl bg-zinc-100 dark:bg-zinc-800/50 overflow-hidden shrink-0 border border-zinc-200 dark:border-white/5">
                                        @if($article->featured_image)
                                            <img src="{{ asset('storage/' . $article->featured_image) }}" class="h-full w-full object-cover">
                                        @else
                                                    <div class="h-full w-full flex items-center justify-center text-zinc-400 dark:text-zinc-500">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <button wire:click="edit({{ $article->id }})" class="text-lg font-bold text-zinc-900 dark:text-zinc-100 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-left">{{ $article->title }}</button>
                                                <div class="flex items-center gap-3 mt-1.5 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-tight">
                                                    <span>{{ $article->author->name }}</span>
                                                    <span class="w-1 h-1 rounded-full bg-zinc-300 dark:bg-zinc-600"></span>
                                                    <span>{{ $article->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="inline-flex px-3 py-1 bg-zinc-100 dark:bg-zinc-800/50 text-zinc-600 dark:text-zinc-300 border border-zinc-200 dark:border-white/5 text-[10px] font-bold uppercase rounded-lg">
                                            {{ $article->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full 
                                                {{ $article->status === 'published' ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : '' }}
                                                {{ in_array($article->status, ['submitted', 'in_review']) ? 'bg-indigo-500' : '' }}
                                                {{ $article->status === 'draft' ? 'bg-zinc-400 dark:bg-zinc-600' : '' }}
                                                {{ $article->status === 'scheduled' ? 'bg-amber-500' : '' }}
                                                {{ $article->status === 'rejected' ? 'bg-rose-500' : '' }}
                                            "></div>
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">{{ $article->status }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                         <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            @if(auth()->user()->can('edit any article') || (auth()->user()->can('edit own article') && $article->user_id === auth()->id()))
                                            <button wire:click="edit({{ $article->id }})" class="p-2.5 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-white/5 text-zinc-500 dark:text-zinc-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-500 transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            @endif
                                            @can('delete article')
                                            <button wire:click="delete({{ $article->id }})" 
                                                    onclick="confirm('Move this story to trash?') || event.stopImmediatePropagation()"
                                                    class="p-2.5 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-white/5 text-zinc-500 dark:text-zinc-400 hover:text-rose-600 dark:hover:text-rose-400 hover:border-rose-500 transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                    @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <p class="text-sm font-bold text-zinc-400 dark:text-zinc-600 uppercase tracking-widest">No manuscripts found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($articles->hasPages())
                    <div class="px-8 py-6 bg-zinc-50/50 dark:bg-zinc-900/50 border-t border-zinc-200 dark:border-white/5">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>

            <!-- Mobile View (Cards) -->
            <div class="lg:hidden space-y-4">
                @forelse ($articles as $article)
                    <div class="glass-card p-5 rounded-3xl border border-zinc-200 dark:border-white/5 space-y-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="h-14 w-14 rounded-2xl bg-zinc-100 dark:bg-zinc-800/50 shrink-0 border border-zinc-200 dark:border-white/5 overflow-hidden">
                                    @if($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-zinc-900 dark:text-zinc-100 leading-tight line-clamp-2">{{ $article->title }}</h4>
                                    <span class="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-tight">{{ $article->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                @if(auth()->user()->can('edit any article') || (auth()->user()->can('edit own article') && $article->user_id === auth()->id()))
                                <button wire:click="edit({{ $article->id }})" class="p-2 text-zinc-400 dark:text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                @endif
                                
                                @can('delete article')
                                <button wire:click="delete({{ $article->id }})" 
                                        onclick="confirm('Delete this story permanently?') || event.stopImmediatePropagation()"
                                        class="p-2 text-zinc-400 dark:text-zinc-500 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                @endcan
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-zinc-100 dark:border-white/5">
                            <span class="px-2 py-0.5 bg-zinc-100 dark:bg-zinc-800/50 text-zinc-600 dark:text-zinc-300 text-[9px] font-black uppercase rounded">{{ $article->category->name }}</span>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full {{ $article->status === 'published' ? 'bg-emerald-500' : (in_array($article->status, ['submitted', 'in_review']) ? 'bg-indigo-500' : 'bg-zinc-400 dark:bg-zinc-600') }}"></div>
                                <span class="text-[9px] font-bold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">{{ $article->status }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center glass-card rounded-3xl">
                        <p class="text-[10px] font-bold text-zinc-400 dark:text-zinc-600 uppercase tracking-widest">Draft list empty</p>
                    </div>
                @endforelse
                <div class="mt-4">
                    {{ $articles->links() }}
                </div>
            </div>

    @else
        <!-- Editor View (Modern Layout) -->
        <div class="glass-card rounded-[2rem] overflow-hidden flex flex-col lg:flex-row h-[calc(100vh-140px)] border border-zinc-200 dark:border-white/5 shadow-2xl relative z-10">

            <button wire:click="$set('isModalOpen', false)" class="absolute top-6 right-6 lg:left-6 lg:right-auto z-20 p-2 rounded-full bg-white/50 dark:bg-zinc-900/50 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white backdrop-blur-md transition-colors border border-zinc-200 dark:border-white/10 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </button>

            <!-- Left: Writing Area -->
            <div class="flex-1 overflow-y-auto custom-scrollbar px-6 sm:px-12 md:px-20 py-10 sm:py-20 lg:border-r border-zinc-200 dark:border-white/5 bg-white/30 dark:bg-zinc-950/30">
                <div class="max-w-3xl mx-auto lg:ml-20">
                    <form id="storyForm" wire:submit.prevent="save" class="space-y-10">
                        <!-- Headline -->
                        <textarea 
                            wire:model.live="title" 
                            rows="2"
                            placeholder="A compelling headline..." 
                            class="w-full bg-transparent border-none focus:ring-0 text-4xl sm:text-5xl font-bold tracking-tight text-zinc-900 dark:text-white placeholder-zinc-300 dark:placeholder-zinc-700 resize-none p-0 leading-tight"
                        ></textarea>

                        <div class="flex flex-wrap items-center gap-6 py-6 border-y border-zinc-200 dark:border-white/5">
                            <div class="space-y-1">
                                <label class="text-[9px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Editorial Category</label>
                                <select wire:model="category_id" class="block bg-transparent border-none p-0 text-xs font-bold text-indigo-600 dark:text-indigo-400 focus:ring-0 focus:outline-none appearance-none">
                                    <option value="" class="dark:bg-zinc-900">Choose Path...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" class="dark:bg-zinc-900">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="h-8 w-[1px] bg-zinc-200 dark:bg-white/10 hidden sm:block"></div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Permanent Slug</label>
                                <div class="flex items-center gap-1">
                                    <span class="text-[10px] font-bold text-zinc-400 dark:text-zinc-600">/news/</span>
                                    <input type="text" wire:model="slug" class="bg-transparent border-none p-0 text-xs font-bold text-zinc-700 dark:text-zinc-300 focus:ring-0">
                                </div>
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="pt-4">
                            <textarea wire:model="excerpt" rows="2" placeholder="Write a brief teaser for the news feed..." class="w-full bg-transparent border-none focus:ring-0 text-lg sm:text-xl text-zinc-600 dark:text-zinc-400 font-medium italic p-0 resize-none leading-relaxed"></textarea>
                        </div>

                        <div wire:ignore class="pt-10">
                            <div id="editor" x-data="{ 
                                init() {
                                    ClassicEditor
                                        .create($refs.ckeditor)
                                        .then(editor => {
                                            editor.model.document.on('change:data', () => {
                                                clearTimeout(this.timeout);
                                                this.timeout = setTimeout(() => {
                                                    @this.set('content', editor.getData());
                                                }, 500);
                                            })
                                        })
                                }
                            }" x-init="init()" x-ref="ckeditor">
                                {!! $content !!}
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Command Center Sidebar -->
            <aside class="w-full lg:w-[420px] border-t lg:border-t-0 bg-zinc-50/50 dark:bg-zinc-900/50 flex flex-col h-full overflow-hidden"
                   x-show="!isMobile || sidebarOpen"
                   x-transition:enter="transition ease-out duration-300"
                   x-transition:enter-start="translate-x-full"
                   x-transition:enter-end="translate-x-0">

                <div class="flex-1 overflow-y-auto custom-scrollbar p-8 space-y-12">

                    <!-- Feature Image / Media Frame -->
                    <div class="group">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em]">Story Canvas</label>
                            @if($featured_image)
                                <button wire:click="$set('featured_image', null)" class="text-[9px] font-bold text-rose-500 uppercase hover:underline">Remove</button>
                            @endif
                        </div>
                        <div class="relative aspect-[16/10] rounded-[2rem] overflow-hidden bg-zinc-100 dark:bg-zinc-800/50 border border-zinc-200 dark:border-white/5 shadow-inner group-hover:shadow-xl transition-all duration-500">
                            @if ($featured_image)
                                <img src="{{ $featured_image->temporaryUrl() }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-zinc-900/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center backdrop-blur-[2px]">
                                    <div class="px-6 py-2.5 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md rounded-full shadow-2xl flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-[10px] font-black text-zinc-900 dark:text-white uppercase tracking-widest">Update Visual</span>
                                    </div>
                                </div>
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-zinc-400 dark:text-zinc-600">
                                    <div class="w-12 h-12 rounded-2xl bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all">
                                        <svg class="w-6 h-6 text-zinc-300 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">Deploy Cover Image</span>
                                </div>
                            @endif
                            <input type="file" wire:model="featured_image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                        </div>
                        @error('featured_image') <p class="text-[10px] text-rose-500 font-bold mt-3 px-2">{{ $message }}</p> @enderror
                    </div>

                    <!-- Workflow & Status -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em]">Lifecycle Stage</label>
                            <div class="flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full {{ $status === 'published' ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-amber-500' }}"></span>
                                <span class="text-[9px] font-black uppercase text-zinc-600 dark:text-zinc-400 tracking-tighter">{{ $status }}</span>
                            </div>
                        </div>

                        <div class="bg-white/50 dark:bg-zinc-950/50 p-1.5 rounded-[1.5rem] flex flex-col gap-1 border border-zinc-200 dark:border-white/5">
                            @foreach(['draft' => 'Draft Manuscript', 'submitted' => 'Editorial Review', 'in_review' => 'Peer Review', 'published' => 'Public Release', 'scheduled' => 'Future Launch'] as $val => $label)
                                <button 
                                    wire:click="$set('status', '{{ $val }}')"
                                    class="flex items-center justify-between px-5 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-300
                                    {{ $status === $val ? 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white shadow-lg shadow-zinc-200/50 dark:shadow-none scale-[1.02] translate-x-1' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300 hover:bg-white/50 dark:hover:bg-zinc-800/50' }}"
                                >
                                    <span>{{ $label }}</span>
                                    @if($status === $val)
                                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    @endif
                                </button>
                            @endforeach
                        </div>

                        @if($status === 'scheduled')
                            <div class="p-6 bg-indigo-50/50 dark:bg-indigo-500/10 rounded-3xl border border-indigo-100/50 dark:border-indigo-500/20 space-y-4 animate-in fade-in slide-in-from-top-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <label class="text-[10px] font-black text-indigo-900 dark:text-indigo-400 uppercase tracking-widest">Scheduled Slot</label>
                                </div>
                                <input type="datetime-local" wire:model="published_at" class="w-full bg-white dark:bg-zinc-900 border-none rounded-xl py-3 px-4 text-xs font-bold text-indigo-600 dark:text-indigo-400 focus:ring-2 focus:ring-indigo-500 transition-all">
                            </div>
                        @endif

                        <div class="flex items-center justify-between p-6 bg-white/50 dark:bg-zinc-950/50 rounded-3xl border border-zinc-200 dark:border-white/5 shadow-sm">
                            <div>
                                <span class="text-[10px] font-black text-zinc-900 dark:text-zinc-100 uppercase tracking-widest block">Featured Story</span>
                                <span class="text-[9px] font-medium text-zinc-500 dark:text-zinc-400 mt-1 block">Highlight on main gateway</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="is_featured" class="sr-only peer">
                                <div class="w-11 h-6 bg-zinc-300 dark:bg-zinc-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-6 bg-white/50 dark:bg-zinc-950/50 rounded-3xl border border-zinc-200 dark:border-white/5 shadow-sm">
                            <div>
                                <span class="text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest block">Breaking News</span>
                                <span class="text-[9px] font-medium text-zinc-500 dark:text-zinc-400 mt-1 block">Push to live ticker</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="is_breaking" class="sr-only peer">
                                <div class="w-11 h-6 bg-zinc-300 dark:bg-zinc-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-600 dark:peer-checked:bg-rose-500"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Taxonomy / Tags -->
                    <div class="space-y-6">
                        <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em]">Taxonomy Tags</label>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach($tags as $tag)
                                <label class="cursor-pointer group">
                                    <input type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}" class="sr-only peer">
                                    <div class="px-5 py-2.5 rounded-2xl border border-zinc-200 dark:border-white/5 bg-white dark:bg-zinc-900 text-[10px] font-black text-zinc-500 dark:text-zinc-400 transition-all duration-300 peer-checked:bg-zinc-900 dark:peer-checked:bg-white peer-checked:text-white dark:peer-checked:text-zinc-900 peer-checked:border-zinc-900 dark:peer-checked:border-white group-hover:border-zinc-300 dark:group-hover:border-white/20">
                                        #{{ strtoupper($tag->name) }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Remarks / Feedback Loop -->
                    @if($editingArticleId && count($remarks) > 0)
                        <div class="space-y-6 pt-6 border-t border-zinc-200 dark:border-white/5">
                            <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em]">Editorial Feedback</label>
                            <div class="space-y-4">
                                @foreach($remarks as $remarkItem)
                                    <div class="p-6 bg-amber-50/50 dark:bg-amber-500/10 rounded-[2rem] border border-amber-100/50 dark:border-amber-500/20 relative overflow-hidden group">
                                        <div class="flex justify-between items-center mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-7 h-7 rounded-xl bg-amber-200 dark:bg-amber-500/30 flex items-center justify-center text-[10px] font-black text-amber-700 dark:text-amber-400 overflow-hidden">
                                                    @if($remarkItem->user->avatar)
                                                        <img src="{{ Storage::url($remarkItem->user->avatar) }}" class="h-full w-full object-cover">
                                                    @else
                                                        {{ substr($remarkItem->user->name, 0, 1) }}
                                                    @endif
                                                </div>
                                                <span class="text-[10px] font-black text-amber-900 dark:text-amber-400 uppercase">{{ $remarkItem->user->name }}</span>
                                            </div>
                                            <span class="text-[8px] font-bold text-amber-500 dark:text-amber-600 uppercase">{{ $remarkItem->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-xs text-amber-800/80 dark:text-amber-400/80 leading-relaxed font-medium italic">"{{ $remarkItem->remark }}"</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Footer Operations -->
                <div class="p-8 bg-white/50 dark:bg-zinc-950/50 border-t border-zinc-200 dark:border-white/5 space-y-4 backdrop-blur-md">
                    @if(in_array($status, ['submitted', 'in_review']) && auth()->user()->can('publish article'))
                        <div class="grid grid-cols-2 gap-3">
                            <button wire:click="approve" class="py-4 bg-emerald-600 dark:bg-emerald-500/20 text-white dark:text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-emerald-700 dark:hover:bg-emerald-500/30 transition-all shadow-xl shadow-emerald-500/20 dark:shadow-none flex items-center justify-center gap-2 border border-transparent dark:border-emerald-500/30">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                Approve
                            </button>
                            <button wire:click="reject" class="py-4 bg-rose-600 dark:bg-rose-500/20 text-white dark:text-rose-400 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-rose-700 dark:hover:bg-rose-500/30 transition-all shadow-xl shadow-rose-500/20 dark:shadow-none flex items-center justify-center gap-2 border border-transparent dark:border-rose-500/30">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Reject
                            </button>
                        </div>
                    @endif

                    <button wire:click="save" class="w-full py-5 bg-indigo-600 text-white text-xs font-black uppercase tracking-[0.2em] rounded-[1.5rem] hover:bg-indigo-700 transition-all shadow-2xl shadow-indigo-500/30 flex items-center justify-center gap-3 group">
                        <span>Commit to Registry</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    </button>

                    @if($status === 'draft' || $status === 'rejected')
                        <button wire:click="submitForReview" class="w-full py-4 mt-2 bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-amber-500/20 transition-all border border-amber-500/20 flex items-center justify-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Request Editorial Approval
                        </button>
                    @endif
                </div>
            </aside>
        </div>
    @endif
</div>
