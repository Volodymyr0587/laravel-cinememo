<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->authorize('view', $user);

        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.admin.users.show');
    }
}
