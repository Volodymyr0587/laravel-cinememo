<?php

namespace App\Livewire\ContentItems;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ContentItem;
use Livewire\Attributes\On;

class LikeButton extends Component
{
    public ContentItem $contentItem;
    public $likesCount;
    public $isLiked = false;

    public function mount()
    {
        $this->loadLikeData();
    }

    private function loadLikeData()
    {
        // Завжди перезавантажуємо свіжі дані з бази
        $this->contentItem->loadCount('likes');
        $this->likesCount = $this->contentItem->likes_count;

        $user = Auth::user();
        $this->isLiked = $user ? $this->contentItem->isLikedBy($user) : false;
    }

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

        // Оновлюємо дані після зміни
        $this->loadLikeData();

        // Повідомляємо батьківський компонент про зміну
        $this->dispatch('like-updated', contentItemId: $this->contentItem->id);
    }

    // Слухач для оновлення з батьківського компонента
    #[On('refresh-likes')]
    public function refreshLikes()
    {
        $this->loadLikeData();
    }

    // Слухач для оновлення конкретного елемента
    #[On('refresh-like-{contentItem.id}')]
    public function refreshSpecificLike()
    {
        $this->loadLikeData();
    }

    public function render()
    {
        return view('livewire.content-items.like-button', [
            'likesCount' => $this->likesCount,
            'isLiked' => $this->isLiked
        ]);
    }
}
