<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{
    public Role $role;
    public $name;
    public $permissions = [];
    public $confirmingDelete = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|unique:roles,name,' . $this->role->id,
            'permissions' => 'array',
        ];
    }

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->name = $role->name;
        $this->permissions = $role->permissions()->pluck('name')->toArray();
    }

    public function update()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate();

        $this->role->update(['name' => $this->name]);
        $this->role->syncPermissions($this->permissions);

        session()->flash('message', 'Role updated successfully.');
        return redirect()->route('admin.roles.index');
    }

    public function confirmDelete()
    {
        $this->confirmingDelete = true;
    }

    public function deleteRole()
    {
        $this->role->delete();

        session()->flash('message', 'Role deleted successfully.');
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        $allPermissions = Permission::all();
        return view('livewire.admin.roles.edit', compact('allPermissions'));
    }
}

