<?php

namespace App\Livewire\Shared;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentSection extends Component
{
    public Article $article;
    public $body = '';

    protected $listeners = ['commentAdded' => '$refresh', 'commentDeleted' => '$refresh'];

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function postComment()
    {
        if (!Auth::check()) {
            $this->dispatch('notify', message: 'Please register to post a comment.', type: 'warning');
            return;
        }

        $this->validate([
            'body' => 'required|string|max:2000',
        ]);

        $this->article->comments()->create([
            'user_id' => Auth::id(),
            'body' => $this->body,
        ]);

        $this->body = '';
        $this->dispatch('notify', message: 'Comment posted successfully!');
    }

    public function render()
    {
        $comments = $this->article->comments()
            ->whereNull('parent_id')
            ->with(['user', 'reactions', 'replies.user', 'replies.reactions', 'replies.replies'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.frontend.comment-section', [
            'comments' => $comments,
        ]);
    }
}
