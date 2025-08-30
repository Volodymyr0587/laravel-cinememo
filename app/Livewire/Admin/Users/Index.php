<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
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
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($userId);

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
        $query = User::latest(); // add with('roles') after install spatie/laravel-permission

        if ($this->search) {
            $query
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        $allUsers = $query->paginate(10)->withQueryString();

        return view('livewire.admin.users.index', compact('allUsers'));
    }
}
