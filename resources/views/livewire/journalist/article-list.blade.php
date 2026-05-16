<div class="py-6 space-y-8" x-data="{ 
    isModalOpen: @entangle('isModalOpen'),
    sidebarOpen: true,
    isMobile: window.innerWidth < 1024
}" x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 1024)">

    <!-- Dashboard Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 px-4">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight">Editorial Workspace</h2>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">Craft and manage stories that matter.</p>
        </div>

        <div class="flex items-center gap-4">
            <div class="relative group">
                <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search stories..."
                    class="bg-white dark:bg-zinc-900/50 border border-zinc-200 dark:border-white/5 rounded-2xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 w-full md:w-80 transition-all shadow-sm">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-indigo-500 transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <button wire:click="create"
                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-sm transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                New Story
            </button>
        </div>
    </div>

    <!-- Registry Table -->
    <div
        class="bg-white dark:bg-zinc-900/50 rounded-[2.5rem] border border-zinc-200 dark:border-white/5 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-white/5 bg-zinc-50/50 dark:bg-white/[0.02]">
                        <th class="px-8 py-5 text-[10px] font-black text-zinc-400 uppercase tracking-widest">Story Info
                        </th>
                        <th class="px-6 py-5 text-[10px] font-black text-zinc-400 uppercase tracking-widest">Category
                        </th>
                        <th class="px-6 py-5 text-[10px] font-black text-zinc-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-zinc-400 uppercase tracking-widest">Metrics
                        </th>
                        <th class="px-8 py-5 text-[10px] font-black text-zinc-400 uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-white/5">
                    @forelse($articles as $article)
                        <tr class="group hover:bg-zinc-50 dark:hover:bg-white/[0.01] transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="h-16 w-24 rounded-2xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 shrink-0 border border-zinc-200 dark:border-white/5">
                                        @if($article->featured_image)
                                            <img src="{{ Storage::url($article->featured_image) }}"
                                                class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-zinc-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p
                                            class="text-sm font-black text-zinc-900 dark:text-white truncate group-hover:text-indigo-500 transition-colors">
                                            {{ $article->title }}</p>
                                        <p class="text-xs text-zinc-500 mt-1 font-medium">By {{ $article->author->name }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span
                                    class="px-3 py-1.5 rounded-xl bg-zinc-100 dark:bg-white/5 text-[10px] font-black text-zinc-500 uppercase tracking-widest border border-zinc-200 dark:border-white/10">
                                    {{ $article->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                @php
                                    $statusColors = [
                                        'published' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                        'draft' => 'bg-zinc-500/10 text-zinc-500 border-zinc-500/20',
                                        'submitted' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                                        'in_review' => 'bg-orange-500/10 text-orange-500 border-orange-500/20',
                                        'rejected' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                        'scheduled' => 'bg-purple-500/10 text-purple-500 border-purple-500/20',
                                    ];
                                    $color = $statusColors[$article->status] ?? $statusColors['draft'];
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border {{ $color }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                    {{ $article->status }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-4 text-zinc-400">
                                    <div class="flex items-center gap-1.5" title="Views">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-xs font-bold">{{ number_format($article->views_count ?? 0) }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5" title="Comments">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                            </path>
                                        </svg>
                                        <span class="text-xs font-bold">{{ $article->comments_count ?? 0 }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="edit({{ $article->id }})"
                                        class="p-2.5 text-zinc-400 hover:text-indigo-500 hover:bg-indigo-500/5 rounded-xl transition-all"
                                        title="Edit Story">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $article->id }})"
                                        wire:confirm="Are you sure you want to delete this story?"
                                        class="p-2.5 text-zinc-400 hover:text-red-500 hover:bg-red-500/5 rounded-xl transition-all"
                                        title="Delete Story">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center">
                                <div class="space-y-4">
                                    <div
                                        class="h-20 w-20 bg-zinc-100 dark:bg-zinc-800 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-10 h-10 text-zinc-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-black text-zinc-900 dark:text-white uppercase tracking-tight">
                                        Empty Registry</h4>
                                    <p class="text-zinc-500 max-w-xs mx-auto text-sm font-medium">Your editorial record is
                                        empty. Start by creating a new story to fill this space.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="px-8 py-6 border-t border-zinc-100 dark:border-white/5 bg-zinc-50/30 dark:bg-white/[0.01]">
                {{ $articles->links() }}
            </div>
        @endif
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
            <div class="relative w-full max-w-6xl bg-white dark:bg-zinc-950 rounded-[3rem] shadow-2xl border border-zinc-200 dark:border-white/10 overflow-hidden"
                @click.stop>
                <!-- Modal Header -->
                <div
                    class="px-10 py-8 border-b border-zinc-100 dark:border-white/5 flex items-center justify-between bg-zinc-50/50 dark:bg-white/[0.02]">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] mb-1 block">Story
                            Studio</span>
                        <h3 class="text-2xl font-black text-zinc-900 dark:text-white tracking-tight">
                            {{ $editingArticleId ? 'Refine Story' : 'New Narrative' }}
                        </h3>
                    </div>
                    <button type="button" @click="isModalOpen = false"
                        class="p-3 text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-white/5 rounded-2xl transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Form Content -->
                <form wire:submit.prevent="save" class="p-10">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                        <!-- Main Content (Left) -->
                        <div class="lg:col-span-8 space-y-8">
                            <div class="space-y-4">
                                <label
                                    class="text-[10px] font-black text-zinc-400 uppercase tracking-widest ml-4">Headline</label>
                                <input type="text" wire:model.blur="title"
                                    class="w-full bg-zinc-50 dark:bg-white/5 border-2 border-zinc-100 dark:border-white/5 rounded-3xl p-6 text-xl font-black text-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-0 transition-all shadow-inner"
                                    placeholder="Enter a compelling title...">
                                @error('title') <span
                                    class="text-red-500 text-[10px] font-black uppercase tracking-widest ml-4">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-zinc-400 uppercase tracking-widest ml-4">URL
                                    Identifier</label>
                                <input type="text" wire:model="slug"
                                    class="w-full bg-zinc-50 dark:bg-white/5 border-2 border-zinc-100 dark:border-white/5 rounded-2xl p-4 text-sm font-medium text-zinc-500 focus:border-indigo-500 focus:ring-0 transition-all shadow-inner"
                                    placeholder="auto-generated-slug">
                                @error('slug') <span
                                    class="text-red-500 text-[10px] font-black uppercase tracking-widest ml-4">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-zinc-400 uppercase tracking-widest ml-4">Brief
                                    Excerpt</label>
                                <textarea wire:model="excerpt"
                                    class="w-full bg-zinc-50 dark:bg-white/5 border-2 border-zinc-100 dark:border-white/5 rounded-3xl p-6 text-base font-medium text-zinc-700 dark:text-zinc-300 focus:border-indigo-500 focus:ring-0 transition-all shadow-inner resize-none h-32"
                                    placeholder="Summary for homepages and SEO..."></textarea>
                                @error('excerpt') <span
                                    class="text-red-500 text-[10px] font-black uppercase tracking-widest ml-4">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-4">
                                <label
                                    class="text-[10px] font-black text-zinc-400 uppercase tracking-widest ml-4">Content
                                    Canvas</label>
                                <div wire:ignore class="prose-editor">
                                    <textarea id="article-content"
                                        class="w-full bg-zinc-50 dark:bg-white/5 border-2 border-zinc-100 dark:border-white/5 rounded-3xl p-8 text-lg font-medium text-zinc-700 dark:text-zinc-300 focus:border-indigo-500 focus:ring-0 transition-all min-h-[400px] shadow-inner"
                                        wire:model="content"></textarea>
                                </div>
                                @error('content') <span
                                    class="text-red-500 text-[10px] font-black uppercase tracking-widest ml-4">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Sidebar (Right) -->
                        <div class="lg:col-span-4 space-y-10">
                            <!-- Visual Asset -->
                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-zinc-400 uppercase tracking-widest ml-4">Cover
                                    Image</label>
                                <div
                                    class="relative group aspect-video rounded-3xl bg-zinc-100 dark:bg-white/5 border-2 border-dashed border-zinc-200 dark:border-white/10 overflow-hidden flex flex-col items-center justify-center text-center p-6 cursor-pointer hover:border-indigo-500/50 transition-all">
                                    <input type="file" wire:model="featured_image"
                                        class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                    @if($featured_image)
                                        <img src="{{ $featured_image->temporaryUrl() }}"
                                            class="absolute inset-0 w-full h-full object-cover">
                                    @elseif($editingArticleId && $articles->find($editingArticleId)->featured_image)
                                        <img src="{{ Storage::url($articles->find($editingArticleId)->featured_image) }}"
                                            class="absolute inset-0 w-full h-full object-cover">
                                    @endif

                                    <div class="relative z-0 space-y-2">
                                        <svg class="w-8 h-8 text-zinc-300 mx-auto" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="text-[10px] font-black text-zinc-400 uppercase tracking-widest">Update
                                            media</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Taxonomy -->
                            <div class="space-y-6">
                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-zinc-400 uppercase tracking-widest ml-4">Category</label>
                                    <select wire:model="category_id"
                                        class="w-full bg-zinc-50 dark:bg-white/5 border-2 border-zinc-100 dark:border-white/5 rounded-2xl p-4 text-sm font-bold text-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-0 transition-all shadow-inner appearance-none">
                                        <option value="">Select Domain</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-zinc-400 uppercase tracking-widest ml-4">Status
                                        & Visibility</label>
                                    <select wire:model="status"
                                        class="w-full bg-zinc-50 dark:bg-white/5 border-2 border-zinc-100 dark:border-white/5 rounded-2xl p-4 text-sm font-bold text-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-0 transition-all shadow-inner appearance-none">
                                        <option value="draft">Draft</option>
                                        <option value="submitted">Submit for Review</option>
                                        @if(auth()->user()->can('publish article'))
                                            <option value="published">Publish Now</option>
                                            <option value="scheduled">Schedule</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <label
                                        class="relative flex flex-col items-center justify-center p-4 bg-zinc-50 dark:bg-white/5 rounded-2xl border-2 border-zinc-100 dark:border-white/5 cursor-pointer hover:bg-zinc-100 transition-all group">
                                        <input type="checkbox" wire:model="is_featured" class="hidden">
                                        <svg class="w-5 h-5 mb-2 {{ $is_featured ? 'text-indigo-500' : 'text-zinc-300' }}"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-[8px] font-black uppercase tracking-widest {{ $is_featured ? 'text-indigo-500' : 'text-zinc-500' }}">Featured</span>
                                    </label>
                                    <label
                                        class="relative flex flex-col items-center justify-center p-4 bg-zinc-50 dark:bg-white/5 rounded-2xl border-2 border-zinc-100 dark:border-white/5 cursor-pointer hover:bg-zinc-100 transition-all group">
                                        <input type="checkbox" wire:model="is_breaking" class="hidden">
                                        <svg class="w-5 h-5 mb-2 {{ $is_breaking ? 'text-red-500' : 'text-zinc-300' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span
                                            class="text-[8px] font-black uppercase tracking-widest {{ $is_breaking ? 'text-red-500' : 'text-zinc-500' }}">Breaking</span>
                                    </label>
                                </div>

                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-zinc-400 uppercase tracking-widest ml-4">Tags</label>
                                    <div
                                        class="flex flex-wrap gap-2 p-4 bg-zinc-50 dark:bg-white/5 rounded-2xl border-2 border-zinc-100 dark:border-white/5 shadow-inner min-h-[100px] content-start">
                                        @foreach($tags as $tag)
                                            <label class="relative flex items-center cursor-pointer group">
                                                <input type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}"
                                                    class="hidden peer">
                                                <span class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all
                                                        bg-zinc-100 dark:bg-white/5 text-zinc-500 border border-zinc-200 dark:border-white/10
                                                        peer-checked:bg-zinc-900 peer-checked:text-white peer-checked:border-zinc-900 dark:peer-checked:bg-white dark:peer-checked:text-zinc-900
                                                        hover:border-zinc-300 dark:hover:border-white/20">
                                                    #{{ $tag->name }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="mt-12 flex justify-end gap-4">
                        <button type="button" @click="isModalOpen = false"
                            class="px-10 py-4 text-xs font-black uppercase tracking-widest text-zinc-500 hover:bg-zinc-100 dark:hover:bg-white/5 rounded-2xl transition-all">Discard
                            Draft</button>
                        <button type="submit"
                            class="px-12 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-sm transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                            {{ $editingArticleId ? 'Commit Changes' : 'Publish Story' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>