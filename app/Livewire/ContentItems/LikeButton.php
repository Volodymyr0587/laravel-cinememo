<?php

namespace App\Livewire\ContentItems;

use Livewire\Component;
use App\Models\ContentItem;
use Illuminate\Support\Facades\Auth;

class LikeButton extends Component
{
    public ContentItem $contentItem;

    public function toggleLike()
    {
        $this->authorize('like', $this->contentItem);

        if ($this->contentItem->isLikedBy(Auth::user())) {
            $this->contentItem->likes()->where('user_id', Auth::id())->delete();
        } else {
            $this->contentItem->likes()->create(['user_id' => Auth::id()]);
        }

        $this->contentItem->refresh();
    }
    public function render()
    {
        return view('livewire.content-items.like-button', [
            'likesCount' => $this->contentItem->likes()->count(),
            'isLiked' => $this->contentItem->isLikedBy(Auth::user()),
        ]);
    }
}
