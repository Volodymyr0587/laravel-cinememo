<?php

namespace App\Livewire\Comments;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CommentsSection extends Component
{
    public Model $commentable;
    public string $body = '';
    public int $count = 0;

    protected $rules = [
        'body' => 'required|string|min:3|max:500'
    ];

    public function mount(Model $commentable)
    {
        $this->commentable = $commentable;
        $this->count = $commentable->comments()->count();
    }

    #[\Livewire\Attributes\On('comment-updated')]
    public function refreshCount($commentableId)
    {
        if ($this->commentable->id === (int) $commentableId) {
            $this->count = $this->commentable->comments()->count();
        }
    }

    public function postComment()
    {
        $this->validate();

        // only public content items are commentable
        if ($this->commentable instanceof \App\Models\ContentItem && ! $this->commentable->is_public) {
            return;
        }

        // only published articles are commentable
        if ($this->commentable instanceof \App\Models\Article && ! $this->commentable->is_published) {
            return;
        }

        $this->commentable->comments()->create([
            'user_id' => Auth::id(),
            'body' => $this->body
        ]);

        $this->reset('body');
        $this->commentable->refresh();

         // ✅ tell parent to refresh count
        $this->dispatch('comment-updated', $this->commentable->id);
    }



    public function deleteComment(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        $this->commentable->refresh();

         // ✅ tell parent to refresh count
        $this->dispatch('comment-updated', $this->commentable->id);
    }

    public function render()
    {
        return view('livewire.comments.comments-section', [
            'comments' => $this->commentable->comments()->with('user')->latest()->get()
        ]);
    }
}
