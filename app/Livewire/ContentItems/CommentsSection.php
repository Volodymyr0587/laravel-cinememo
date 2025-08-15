<?php

namespace App\Livewire\ContentItems;

use App\Models\Comment;
use Livewire\Component;
use App\Models\ContentItem;
use Illuminate\Support\Facades\Auth;

class CommentsSection extends Component
{
    public ContentItem $contentItem;
    public string $body = '';

    protected $rules = [
        'body' => 'required|string|min:3|max:500'
    ];

    public function postComment()
    {
        $this->validate();

        if (! $this->contentItem->is_public) {
            return;
        }

        $this->contentItem->comments()->create([
            'user_id' => Auth::id(),
            'body' => $this->body
        ]);

        $this->reset('body');
        $this->contentItem->refresh();
    }

    public function mount(ContentItem $contentItem)
    {
        $this->contentItem = $contentItem;
    }

    public function deleteComment(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        $this->contentItem->refresh();
    }
    public function render()
    {
        return view('livewire.content-items.comments-section', [
            'comments' => $this->contentItem->comments()->with('user')->latest()->get()
        ]);
    }
}
