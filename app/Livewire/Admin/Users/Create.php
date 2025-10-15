<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $allRoles;

    public $roles = [];

    public function mount()
    {
        $this->allRoles = Role::all();
    }

    public function save()
    {
        $this->authorize('create', User::class);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'roles' => ['nullable', 'exists:roles,name']
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $user->assignRole($this->roles);

        return redirect()->route('admin.users.index')
                        ->with('success','User created successfully');
    }
    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
