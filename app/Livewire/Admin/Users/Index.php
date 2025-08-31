<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\UserDeletionService;

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

    public function delete(int $userId, UserDeletionService $userDeletionService)
    {
        $user = User::findOrFail($userId);

        $this->authorize('delete', $user);

        $userDeletionService->deleteUser($userId);

        session()->flash('message', "User {$user->name} and all related data deleted successfully.");

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
