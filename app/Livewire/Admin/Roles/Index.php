<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDelete = false;
    public ?Role $roleToDelete = null;

    public function confirmDelete($roleId)
    {
        $this->roleToDelete = Role::find($roleId); // find role by ID
        if (!$this->roleToDelete) {
            session()->flash('message', 'Role not found.');
            return;
        }
        $this->confirmingDelete = true;
    }

    public function deleteRole()
    {
        if ($this->roleToDelete) {
            $this->roleToDelete->delete();
            $this->confirmingDelete = false;
            $this->roleToDelete = null;

            session()->flash('message', 'Role deleted successfully.');
        }
    }


    public function render()
    {
        $query = Role::query();

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        $roles = $query->latest()->paginate(10);

        return view('livewire.admin.roles.index', compact('roles'));
    }

}
