<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Create extends Component
{
    public $name;
    public $permissions = [];

    protected $rules = [
        'name' => 'required|string|unique:roles,name',
        'permissions' => 'array',
    ];

    public function save()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate();

        $role = Role::create(['name' => $this->name]);
        $role->syncPermissions($this->permissions);

        session()->flash('message', "Role {$role->name} created successfully.");
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        $allPermissions = Permission::all();
        return view('livewire.admin.roles.create', compact('allPermissions'));
    }
}
