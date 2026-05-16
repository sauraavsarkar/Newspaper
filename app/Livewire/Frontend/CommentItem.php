<?php

namespace App\Livewire\Frontend;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentItem extends Component
{
    public Comment $comment;
    public $isReplying = false;
    public $replyBody = '';
    public $isEditing = false;
    public $editBody = '';
    public $reactionCounts = [];
    public $userReaction = null;

    public function mount(Comment $comment)
    {
        $this->comment = $comment;
        $this->loadReactions();
    }

    public function loadReactions()
    {
        $reactions = $this->comment->reactions()->get();
        
        $counts = ['like' => 0, 'love' => 0];
        $userId = Auth::id();
        $this->userReaction = null;

        foreach ($reactions as $reaction) {
            if (isset($counts[$reaction->type])) {
                $counts[$reaction->type]++;
            }

            if ($userId && $reaction->user_id === $userId) {
                $this->userReaction = $reaction->type;
            }
        }

        $this->reactionCounts = $counts;
    }

    public function react($type)
    {
        if (!Auth::check() || !in_array($type, ['like', 'love'])) {
            return;
        }

        $userId = Auth::id();

        if ($this->userReaction === $type) {
            $this->comment->reactions()->where('user_id', $userId)->delete();
            $this->userReaction = null;
        } else {
            $this->comment->reactions()->updateOrCreate(
                ['user_id' => $userId],
                ['type' => $type]
            );
            $this->userReaction = $type;
        }

        $this->loadReactions();
    }

    public function toggleReply()
    {
        if (!Auth::check()) {
            $this->dispatch('notify', message: 'Please register to reply.', type: 'warning');
            return;
        }
        $this->isReplying = !$this->isReplying;
        $this->replyBody = '';
        $this->isEditing = false;
    }

    public function postReply()
    {
        if (!Auth::check()) {
            return;
        }

        $this->validate([
            'replyBody' => 'required|string|max:2000',
        ]);

        $this->comment->replies()->create([
            'article_id' => $this->comment->article_id,
            'user_id' => Auth::id(),
            'body' => $this->replyBody,
        ]);

        $this->isReplying = false;
        $this->replyBody = '';
        $this->dispatch('notify', message: 'Reply posted successfully!');
        
        $this->dispatch('commentAdded')->to('frontend.comment-section');
    }

    public function toggleEdit()
    {
        if (!Auth::check() || Auth::id() !== $this->comment->user_id) {
            return;
        }

        if ($this->comment->created_at->diffInMinutes(now()) > 15) {
            $this->dispatch('notify', message: 'You can only edit comments within 15 minutes of posting.', type: 'error');
            return;
        }

        $this->isEditing = !$this->isEditing;
        $this->editBody = $this->comment->body;
        $this->isReplying = false;
    }

    public function updateComment()
    {
        if (!Auth::check() || Auth::id() !== $this->comment->user_id) {
            return;
        }

        if ($this->comment->created_at->diffInMinutes(now()) > 15) {
            $this->isEditing = false;
            $this->dispatch('notify', message: 'You can only edit comments within 15 minutes of posting.', type: 'error');
            return;
        }

        $this->validate([
            'editBody' => 'required|string|max:2000',
        ]);

        $this->comment->update([
            'body' => $this->editBody,
        ]);

        $this->isEditing = false;
        $this->dispatch('notify', message: 'Comment updated successfully!');
    }

    public function deleteComment()
    {
        if (!Auth::check() || Auth::id() !== $this->comment->user_id) {
            return;
        }

        $this->comment->delete();
        $this->dispatch('notify', message: 'Comment deleted successfully!');
        $this->dispatch('commentDeleted')->to('frontend.comment-section');
    }

    public function reportComment()
    {
        if (!Auth::check()) {
            $this->dispatch('notify', message: 'Please register to report comments.', type: 'warning');
            return;
        }

        $this->comment->reports()->firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        $this->dispatch('notify', message: 'Comment reported. Thank you.', type: 'info');
    }

    public function render()
    {
        return view('livewire.frontend.comment-item');
    }
}
