<?php

namespace App\Livewire\ContentItems;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ContentItem;

class LikeButton extends Component
{
    public ContentItem $contentItem;

    public function toggleLike()
    {
        // Перевірка політики
        $this->authorize('like', $this->contentItem);

        $user = Auth::user();

        if ($this->contentItem->isLikedBy($user)) {
            $this->contentItem->likes()->where('user_id', $user->id)->delete();
        } else {
            $this->contentItem->likes()->create(['user_id' => $user->id]);
        }

        // Оновлюємо likes_count без додаткових запитів
        $this->contentItem->loadCount('likes');
    }

    public function render()
    {
        $user = Auth::user();
        $likesCount = $this->contentItem->likes_count ?? $this->contentItem->likes()->count();
        $isLiked = $user ? $this->contentItem->isLikedBy($user) : false;

        return view('livewire.content-items.like-button', compact('likesCount', 'isLiked'));
    }
}
