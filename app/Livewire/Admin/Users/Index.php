<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Notifications\UserDeletedNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';

    public function clearFilters(): void
    {
        $this->search = '';
        $this->roleFilter = '';
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
        $query = User::latest(); // add with('roles') after install spatie/laravel-permission

        if ($this->search) {
            $query
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        if ($this->roleFilter) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', $this->roleFilter);
            });
        }

        $allUsers = $query->paginate(10)->withQueryString();

        return view('livewire.admin.users.index', compact('allUsers'));
    }
}
