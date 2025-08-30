<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;


class Edit extends Component
{
    public User $user;
    public array $roles = [];
    public $allRoles;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->roles = $user->roles->pluck('name')->toArray();
        $this->allRoles = Role::all();
    }

    public function save()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        $this->user->syncRoles($this->roles);

        session()->flash('message'. 'User updated successfully');

        return redirect()->route('admin.users.index');
    }

    public function delete()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // remove roles first (Spatie)
        $this->user->syncRoles([]);

        // delete related content items
        if ($path = $this->user->profile_image) {
            Storage::disk('public')->delete($path);
        }

        $this->user->contentItems()->each(function ($item) {
            $item->removeAllImages();
        });

        $this->user->actors()->each(function ($actor) {
            $actor->removeAllImages();
        });

        // finally delete user
        $this->user->delete();

        session()->flash('message', 'User and all related data deleted successfully.');
        return redirect()->route('admin.users.index');
    }


    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
