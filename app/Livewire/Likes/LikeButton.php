<?php

namespace App\Livewire\Likes;

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
        // Always reload fresh data from the database
        $this->likeable->loadCount('likes');
        $this->likesCount = $this->likeable->likes_count;

        $user = Auth::user();
        $this->isLiked = $user ? $this->likeable->isLikedBy($user) : false;
    }

    public function toggleLike()
    {
        $this->authorize('like', $this->likeable);

        $user = Auth::user();

        if ($this->likeable->isLikedBy($user)) {
            $this->likeable->likes()->where('user_id', $user->id)->delete();
        } else {
            $this->likeable->likes()->create(['user_id' => $user->id]);
        }

        // Update data after changes
        $this->loadLikeData();

        // Notifying the parent component of the change
        $this->dispatch('like-updated', $this->likeable->id);
    }

    // Listener for updates from the parent component
    #[On('refresh-likes')]
    public function refreshLikes()
    {
        $this->loadLikeData();
    }

    // Listener for updating a specific element
    #[On('refresh-like-{likeable.id}')]
    public function refreshSpecificLike()
    {
        $this->loadLikeData();
    }

    public function render()
    {
        return view('livewire.likes.like-button', [
            'likesCount' => $this->likesCount,
            'isLiked' => $this->isLiked
        ]);
    }
}
