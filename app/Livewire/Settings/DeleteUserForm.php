<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeleteUserForm extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        if ($path = Auth::user()->profile_image) {
            Storage::disk('public')->delete($path);
        }

        Auth::user()->contentItems()->each(function ($item) {
            $item->removeAllImages();
        });

        Auth::user()->actors()->each(function ($actor) {
            $actor->removeAllImages();
        });

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}
