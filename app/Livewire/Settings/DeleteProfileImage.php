<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeleteProfileImage extends Component
{
    public function deleteProfileImage(): void
    {
        $user = Auth::user();


        if ($user->profile_image) {
            // Get the file path
            $filePath = $user->profile_image;

            // Try to delete from storage
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            // Alternative: Use the full system path
            $fullPath = storage_path('app/public/' . $filePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Update database
            $user->update(['profile_image' => null]);

            // Dispatch event
            $this->dispatch('profile-image-deleted');

            // Success message
            session()->flash('message', 'Profile image deleted successfully.');
        }

        $this->dispatch('profile-image-deleted');
    }


    public function render()
    {
        return view('livewire.settings.delete-profile-image');
    }
}
