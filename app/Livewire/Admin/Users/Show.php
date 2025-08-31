<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Notifications\UserDeletedNotification;

class Show extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->authorize('view', $user);

        $this->user = $user;
    }

    public function delete(int $userId)
    {
        $user = User::findOrFail($userId);

        $this->authorize('delete', $user);

        DB::transaction(function () use ($user) {
            // notify user before deleting
            $user->notify(new UserDeletedNotification('Violation of rules or user request.'));

            // remove roles and permissions first (Spatie)
            $user->syncRoles([]);
            $user->syncPermissions([]);

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

            // TODO: delete other relationships if exist
            // e.g. $user->appointments()->delete();

            // finally delete user
            $user->delete();
        });

        session()->flash('message', 'User and all related data deleted successfully.');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.users.show');
    }
}
