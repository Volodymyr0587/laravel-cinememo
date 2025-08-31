<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use App\Services\UserDeletionService;
use Illuminate\Support\Facades\Storage;

class DeleteUserForm extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout, UserDeletionService $userDeletionService): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        // store user ID before logout because Auth::user() will be gone after
        $userId = Auth::id();

        // logout first so session is cleared before actual deletion
        $logout();

        // use centralized service
        $userDeletionService->deleteUser($userId, 'User requested account deletion.');

        $this->redirect('/', navigate: true);
    }
}
