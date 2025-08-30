<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Notifications\UserDeletedNotification;

class Show extends Component
{
    public User $user;

    public function mount(User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $this->user = $user;
    }

    public function delete(int $userId)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($userId);

        // notify user before deleting
        $user->notify(new UserDeletedNotification('Violation of rules or user request.'));

        // remove roles first (Spatie)
        $user->syncRoles([]);

        // delete related content items
        if ($path = $user->profile_image) {
            Storage::disk('public')->delete($path);
        }

        $user->contentItems()->each(function ($item) {
            $item->removeAllImages();
        });

        $user->actors()->each(function ($actor) {
            $actor->removeAllImages();
        });

        // finally delete user
        $user->delete();

        session()->flash('message', 'User and all related data deleted successfully.');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.users.show');
    }
}
