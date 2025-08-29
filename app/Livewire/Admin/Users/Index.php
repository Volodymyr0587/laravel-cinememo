<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

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
