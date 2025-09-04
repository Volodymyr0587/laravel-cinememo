<?php

namespace App\Livewire\ContentItems;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class LikeButton extends Component
{
    public Model $likeable; // generic
    public $likesCount;
    public $isLiked = false;
    public $canLike = false;

    public function mount()
    {
        $this->loadLikeData();

        $user = Auth::user();
        $this->canLike = $user ? $user->can('like', $this->likeable) : false;
    }

    private function loadLikeData()
    {
        // Завжди перезавантажуємо свіжі дані з бази
        $this->likeable->loadCount('likes');
        $this->likesCount = $this->likeable->likes_count;

        $user = Auth::user();
        $this->isLiked = $user ? $this->likeable->isLikedBy($user) : false;
    }

    public function toggleLike()
    {
        // Перевірка політики
        $this->authorize('like', $this->likeable);

        $user = Auth::user();

        if ($this->likeable->isLikedBy($user)) {
            $this->likeable->likes()->where('user_id', $user->id)->delete();
        } else {
            $this->likeable->likes()->create(['user_id' => $user->id]);
        }

        // Оновлюємо дані після зміни
        $this->loadLikeData();

        // Повідомляємо батьківський компонент про зміну
        $this->dispatch('like-updated', $this->likeable->id);
    }

    // Слухач для оновлення з батьківського компонента
    #[On('refresh-likes')]
    public function refreshLikes()
    {
        $this->loadLikeData();
    }

    // Слухач для оновлення конкретного елемента
    #[On('refresh-like-{likeable.id}')]
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
