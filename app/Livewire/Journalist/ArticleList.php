<?php

namespace App\Livewire\Journalist;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Notifications\ArticleStatusNotification;
use App\Notifications\EditorialNotification;
use App\Notifications\SystemAlertNotification;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ArticleList extends Component
{
    use WithPagination, WithFileUploads;

    public $title = '';
    public $slug = '';
    public $content = '';
    public $excerpt = '';
    public $category_id = '';
    public $status = 'draft';
    public $is_featured = false;
    public $is_breaking = false;
    public $featured_image;
    public $selectedTags = [];
    public $published_at; // For scheduling
    
    #[Locked]
    public $editingArticleId = null;
    public $isModalOpen = false;
    public $searchTerm = '';
    public $remark = ''; // For editorial feedback
    public $editor_id = ''; // Assigned editor

    protected $rules = [
        'title' => 'required|min:5',
        'slug' => 'required|unique:articles,slug',
        'content' => 'required|min:20',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:draft,submitted,in_review,approved,published,scheduled,rejected,archived',
        'featured_image' => 'nullable|image|max:2048',
        'published_at' => 'nullable|date',
    ];

    public function updatedTitle($value)
    {
        if (!$this->editingArticleId) {
            $this->slug = Str::slug($value);
        }
    }

    public function create()
    {
        if (!auth()->user()->can('create article')) {
            session()->flash('error', 'You do not have permission to create stories.');
            return;
        }
        Log::info('ArticleManager: Opening create modal.');
        $this->reset(['title', 'slug', 'content', 'excerpt', 'category_id', 'status', 'is_featured', 'is_breaking', 'featured_image', 'selectedTags', 'editingArticleId', 'remark', 'published_at']);
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $article = Article::with(['tags', 'editorialRemarks.user'])->findOrFail($id);
        
        $canEdit = auth()->user()->can('edit any article') || 
                  (auth()->user()->can('edit own article') && $article->user_id === auth()->id());

        if (!$canEdit) {
            session()->flash('error', 'You do not have permission to edit this story.');
            return;
        }
        $this->editingArticleId = $id;
        $this->title = $article->title;
        $this->slug = $article->slug;
        $this->content = $article->content;
        $this->excerpt = $article->excerpt;
        $this->category_id = $article->category_id;
        $this->status = $article->status;
        $this->is_featured = $article->is_featured;
        $this->is_breaking = $article->is_breaking;
        $this->published_at = $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '';
        $this->selectedTags = $article->tags->pluck('id')->toArray();
        $this->editor_id = $article->editor_id;
        $this->remark = '';
        $this->isModalOpen = true;
    }

    public function save()
    {
        if ($this->editingArticleId) {
            $article = Article::find($this->editingArticleId);
            $canUpdate = auth()->user()->can('edit any article') || 
                        (auth()->user()->can('edit own article') && $article->user_id === auth()->id());
            
            if (!$canUpdate) {
                session()->flash('error', 'You do not have permission to update this story.');
                return;
            }
        } else {
            if (!auth()->user()->can('create article')) {
                session()->flash('error', 'You do not have permission to create stories.');
                return;
            }
        }

        Log::info('ArticleManager: Attempting to save article.', [
            'id' => $this->editingArticleId,
            'title' => $this->title,
            'status' => $this->status
        ]);
        $rules = $this->rules;
        if ($this->editingArticleId) {
            $rules['slug'] = 'required|unique:articles,slug,' . $this->editingArticleId;
        }

        $this->validate($rules);

        $data = [
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'is_breaking' => $this->is_breaking,
            'editor_id' => $this->editor_id ?: null,
        ];

        if (!$this->editingArticleId) {
            $data['user_id'] = auth()->id();
        }

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('articles', 'public');
        }

        if ($this->status === 'published' && !$this->published_at) {
            $data['published_at'] = now();
        } elseif ($this->status === 'scheduled') {
            $data['published_at'] = $this->published_at;
        } else {
            $data['published_at'] = $this->published_at ?: null;
        }

        if ($this->editingArticleId) {
            $article = Article::find($this->editingArticleId);
            $wasBreaking = $article->is_breaking;
            $article->update($data);
            
            // Check for Breaking News Toggle
            if (!$wasBreaking && $article->is_breaking) {
                // Notify Editors
                $editors = User::role(['Editor', 'Admin'])->get();
                \Illuminate\Support\Facades\Notification::send($editors, new EditorialNotification('breaking_toggled', $article, auth()->user()));

                // Notify Readers (Breaking News Alert)
                $readers = User::role('Reader')->get();
                \Illuminate\Support\Facades\Notification::send($readers, new ReaderAlertNotification('breaking_news', [
                    'title' => $article->title,
                    'url' => route('article.show', $article->slug)
                ]));
            }

            // Check for Editor Assignment
            if ($this->editor_id && $article->wasChanged('editor_id')) {
                $editor = User::find($this->editor_id);
                if ($editor) {
                    $editor->notify(new EditorialNotification('assigned', $article, auth()->user()));
                }
            }

            // Check for Resubmission
            if (in_array($article->getOriginal('status'), ['rejected', 'revision']) && $article->status === 'submitted') {
                $article->update(['resubmitted_at' => now()]);
                
                if ($article->editor) {
                    $article->editor->notify(new EditorialNotification('resubmitted', $article, auth()->user()));
                } else {
                    $editors = User::role(['Editor', 'Admin'])->get();
                    \Illuminate\Support\Facades\Notification::send($editors, new EditorialNotification('resubmitted', $article, auth()->user()));
                }
            }

            $article->tags()->sync($this->selectedTags);
            session()->flash('message', 'Article updated successfully.');
        } else {
            $article = Article::create($data);
            
            // If new article is marked as breaking
            if ($article->is_breaking) {
                $readers = User::role('Reader')->get();
                \Illuminate\Support\Facades\Notification::send($readers, new ReaderAlertNotification('breaking_news', [
                    'title' => $article->title,
                    'url' => route('article.show', $article->slug)
                ]));
            }

            $article->tags()->attach($this->selectedTags);
            Log::info("ArticleManager: Article created successfully. ID: {$article->id}");
            session()->flash('message', 'Article created successfully.');
        }

        $this->isModalOpen = false;

        // Notify Admin if it's the journalist's first article
        if (!$this->editingArticleId) {
            $count = auth()->user()->articles()->count();
            if ($count === 1) {
                $admins = User::role('Admin')->get();
                \Illuminate\Support\Facades\Notification::send($admins, new SystemAlertNotification('first_article', [
                    'journalist_name' => auth()->user()->name,
                    'article_title' => $article->title,
                    'url' => route('article.show', $article->slug)
                ]));
            }
        }
    }

    public function submitForReview()
    {
        $this->status = 'submitted';
        $this->save();
        
        $article = Article::find($this->editingArticleId);
        $editors = User::role(['Editor', 'Admin'])->get();
        \Illuminate\Support\Facades\Notification::send($editors, new EditorialNotification('submitted', $article, auth()->user()));

        session()->flash('message', 'Article submitted for review.');
    }

    public function approve()
    {
        if (!auth()->user()->can('publish article') && !auth()->user()->can('approve article')) {
            session()->flash('error', 'You do not have permission to approve stories.');
            return;
        }
        $this->status = 'published';
        $this->save();

        $article = Article::find($this->editingArticleId);
        $article->author->notify(new ArticleStatusNotification($article, 'approved'));
        $article->author->notify(new ArticleStatusNotification($article, 'published'));

        session()->flash('message', 'Article approved and published.');
    }

    public function reject()
    {
        if (!auth()->user()->can('publish article') && !auth()->user()->can('reject article')) {
            session()->flash('error', 'You do not have permission to reject stories.');
            return;
        }
        $this->validate([
            'remark' => 'required|min:5'
        ]);

        $article = Article::findOrFail($this->editingArticleId);
        $article->update(['status' => 'rejected']);
        
        $article->editorialRemarks()->create([
            'user_id' => auth()->id(),
            'remark' => $this->remark
        ]);

        $article->author->notify(new ArticleStatusNotification($article, 'rejected', $this->remark));

        $this->isModalOpen = false;
        session()->flash('message', 'Article rejected with feedback.');
    }

    public function delete($id)
    {
        if (!auth()->user()->can('delete article')) {
            session()->flash('error', 'You do not have permission to delete stories.');
            return;
        }
        Log::info("ArticleManager: Deleting article ID: {$id}");
        $article = Article::find($id);
        
        if ($article) {
            $article->delete();
            session()->flash('message', 'Article and all associated data removed successfully.');
        }
    }

    public function render()
    {
        $editorialRemarks = [];
        if ($this->editingArticleId) {
            $editorialRemarks = \App\Models\EditorialRemark::with('user')
                ->where('article_id', $this->editingArticleId)
                ->latest()
                ->get();
        }

        $articlesQuery = Article::with(['author', 'category'])
            ->where('title', 'like', '%' . $this->searchTerm . '%');

        if (!auth()->user()->can('edit any article')) {
            $articlesQuery->where('user_id', auth()->id());
        }

        $articles = $articlesQuery->latest()->paginate(10);

        return view('livewire.journalist.article-list', [
            'articles' => $articles,
            'categories' => Category::where('is_active', true)->get(),
            'tags' => Tag::all(),
            'remarks' => $editorialRemarks,
            'editors' => User::role(['Editor', 'Admin'])->get(),
        ]);
    }
}
