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
        $this->authorize('update', $role);

        $this->role = $role;
        $this->name = $role->name;
        $this->permissions = $role->permissions()->pluck('name')->toArray();
    }

    public function update()
    {
        $this->authorize('update', $this->role);

        $this->validate();

        $this->role->update(['name' => $this->name]);

        $this->role->syncPermissions($this->permissions);

        session()->flash('message', __("roles/main.update_role_message", ['name' => $this->role->name]));

        return redirect()->route('admin.roles.index');
    }

    public function confirmDelete()
    {
        $this->authorize('delete', $this->role);

        $this->confirmingDelete = true;
    }

    public function deleteRole()
    {
        $this->authorize('delete', $this->role);

        $this->role->delete();

        session()->flash('message', __("roles/main.delete_role_message", ['name' => $this->role->name]));

        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        $this->authorize('view', $this->role);

        $allPermissions = Permission::all();

        return view('livewire.admin.roles.edit', compact('allPermissions'));
    }
}

