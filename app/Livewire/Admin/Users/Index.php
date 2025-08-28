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
        $allUsers = User::paginate(10);

        return view('livewire.admin.users.index', compact('allUsers'));
    }
}
