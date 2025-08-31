<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Notifications\UserDeletedNotification;

class UserDeletionService
{
    public function deleteUser(int $userId, string $reason = 'Violation of rules or user request.'): void
    {
        $user = User::findOrFail($userId);

        DB::transaction(function () use ($user, $reason) {
            // notify user before deleting
            $user->notify(new UserDeletedNotification($reason));

            // remove roles and permissions first (Spatie)
            $user->syncRoles([]);
            $user->syncPermissions([]);

            // delete related content items
            if ($path = $user->profile_image) {
                Storage::disk('public')->delete($path);
            }

            $user->contentItems()->each(function ($item) {
                $item->removeAllImages();
            });

            $user->actors()->each(function ($actor) {
                $actor->removeAllImages();
            });

            // TODO: delete other relationships if exist
            // e.g. $user->appointments()->delete();

            // finally delete user
            $user->delete();
        });
    }
}
