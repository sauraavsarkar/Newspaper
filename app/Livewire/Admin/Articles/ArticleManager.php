<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ArticleManager extends Component
{
    use WithPagination, WithFileUploads;

    public $title = '';
    public $slug = '';
    public $content = '';
    public $excerpt = '';
    public $category_id = '';
    public $status = 'draft';
    public $is_featured = false;
    public $featured_image;
    public $selectedTags = [];
    
    public $editingArticleId = null;
    public $isModalOpen = false;
    public $searchTerm = '';

    protected $rules = [
        'title' => 'required|min:5',
        'slug' => 'required|unique:articles,slug',
        'content' => 'required|min:20',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:draft,published,scheduled,archived',
        'featured_image' => 'nullable|image|max:2048',
    ];

    public function updatedTitle($value)
    {
        if (!$this->editingArticleId) {
            $this->slug = Str::slug($value);
        }
    }

    public function create()
    {
        $this->reset(['title', 'slug', 'content', 'excerpt', 'category_id', 'status', 'is_featured', 'featured_image', 'selectedTags', 'editingArticleId']);
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $article = Article::with('tags')->findOrFail($id);
        $this->editingArticleId = $id;
        $this->title = $article->title;
        $this->slug = $article->slug;
        $this->content = $article->content;
        $this->excerpt = $article->excerpt;
        $this->category_id = $article->category_id;
        $this->status = $article->status;
        $this->is_featured = $article->is_featured;
        $this->selectedTags = $article->tags->pluck('id')->toArray();
        $this->isModalOpen = true;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->editingArticleId) {
            $rules['slug'] = 'required|unique:articles,slug,' . $this->editingArticleId;
            $rules['featured_image'] = 'nullable|image|max:2048';
        }

        $this->validate($rules);

        $data = [
            'user_id' => auth()->id(),
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
        ];

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('articles', 'public');
        }

        if ($this->status === 'published' && !$this->editingArticleId) {
            $data['published_at'] = now();
        }

        if ($this->editingArticleId) {
            $article = Article::find($this->editingArticleId);
            $article->update($data);
            $article->tags()->sync($this->selectedTags);
            session()->flash('message', 'Article updated successfully.');
        } else {
            $article = Article::create($data);
            $article->tags()->attach($this->selectedTags);
            session()->flash('message', 'Article created successfully.');
        }

        $this->isModalOpen = false;
    }

    public function delete($id)
    {
        Article::find($id)->delete();
        session()->flash('message', 'Article deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.articles.article-manager', [
            'articles' => Article::with(['author', 'category'])
                ->where('title', 'like', '%' . $this->searchTerm . '%')
                ->latest()
                ->paginate(10),
            'categories' => Category::where('is_active', true)->get(),
            'tags' => Tag::all(),
        ]);
    }
}
