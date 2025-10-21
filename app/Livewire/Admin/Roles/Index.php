<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    public $search = '';
    public $confirmingDelete = false;
    public ?Role $roleToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        // Authorize viewing all roles (RolePolicy@viewAny)
        $this->authorize('viewAny', Role::class);
    }

    // reset pagination when changing filters
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->resetPage();
    }


    public function confirmDelete($roleId)
    {
        $role = Role::find($roleId);

        if (!$role) {
            session()->flash('message', 'Role not found.');
            return;
        }
        // Authorize deletion (RolePolicy@delete)
        $this->authorize('delete', $role);

        $this->roleToDelete = $role;
        $this->confirmingDelete = true;
    }

    public function deleteRole()
    {
        if ($this->roleToDelete) {
            // Authorize again before actual deletion
            $this->authorize('delete', $this->roleToDelete);

            $this->roleToDelete->delete();

            $roleName = $this->roleToDelete->name;
            $this->confirmingDelete = false;
            $this->roleToDelete = null;

            session()->flash('message', __("roles/main.delete_role_message", ['name' => $roleName]));
        }
    }


    public function render()
    {
        $query = Role::query();

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        $roles = $query->latest()->paginate(3)->withQueryString();

        return view('livewire.admin.roles.index', compact('roles'));
    }

}
