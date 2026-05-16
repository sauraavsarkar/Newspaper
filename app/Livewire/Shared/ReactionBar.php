<?php

namespace App\Livewire\Shared;

use App\Models\Article;
use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReactionBar extends Component
{
    public Article $article;
    public $userReaction = null;
    public $reactionCounts = [];
    public $reactionUsers = [];

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->loadReactions();
    }

    public function loadReactions()
    {
        $reactions = $this->article->reactions()->with('user:id,name')->get();
        
        $counts = [
            'like' => 0, 'love' => 0, 'wow' => 0, 'sad' => 0, 'angry' => 0, 'fire' => 0
        ];
        $users = [
            'like' => [], 'love' => [], 'wow' => [], 'sad' => [], 'angry' => [], 'fire' => []
        ];

        $fingerprint = $this->getFingerprintProperty();
        $userId = Auth::id();
        $this->userReaction = null;

        foreach ($reactions as $reaction) {
            if (isset($counts[$reaction->type])) {
                $counts[$reaction->type]++;
            }
            
            if ($reaction->user && isset($users[$reaction->type])) {
                if (count($users[$reaction->type]) < 5) {
                    $users[$reaction->type][] = $reaction->user->name;
                }
            }

            if ($userId && $reaction->user_id === $userId) {
                $this->userReaction = $reaction->type;
            } elseif (!$userId && $reaction->fingerprint === $fingerprint) {
                $this->userReaction = $reaction->type;
            }
        }

        $this->reactionCounts = $counts;
        $this->reactionUsers = $users;
    }

    public function getFingerprintProperty()
    {
        return md5(request()->ip() . request()->userAgent());
    }

    public function react($type)
    {
        $validTypes = ['like', 'love', 'wow', 'sad', 'angry', 'fire'];
        if (!in_array($type, $validTypes)) {
            return;
        }

        $userId = Auth::id();
        $fingerprint = $this->getFingerprintProperty();

        if (!$userId) {
            if (!in_array($type, ['like', 'love'])) {
                // Cannot use non-basic reactions
                return;
            }

            if ($this->userReaction) {
                // Guests cannot change reaction, only notify
                $this->dispatch('notify', message: 'Register to change your reaction anytime.');
                return;
            }

            $this->article->reactions()->create([
                'fingerprint' => $fingerprint,
                'type' => $type,
            ]);

            $this->userReaction = $type;
            $this->loadReactions();
            return;
        }

        // Registered user
        if ($this->userReaction === $type) {
            $this->article->reactions()->where('user_id', $userId)->delete();
            $this->userReaction = null;
        } else {
            $this->article->reactions()->updateOrCreate(
                ['user_id' => $userId],
                ['type' => $type, 'fingerprint' => null]
            );
            $this->userReaction = $type;
        }

        $this->loadReactions();
    }

    public function render()
    {
        return view('livewire.shared.reaction-bar');
    }
}
