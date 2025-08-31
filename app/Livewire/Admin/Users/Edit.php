<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Services\UserDeletionService;


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
        return view('livewire.admin.users.edit');
    }
}
