<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>
            <div>
                <flux:label>Roles</flux:label>
                <div class="flex flex-wrap justify-start items-center gap-2">
                    @forelse (auth()->user()->getRoleNames() as $roleName)
                        <span class="px-2 py-1 rounded text-xs font-semibold bg-blue-500 text-white">
                            {{ $roleName }}
                        </span>
                    @empty
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ __("You have no roles") }}</span>
                    @endforelse
                </div>
            </div>
             <!-- Profile Image -->
            <div class="mt-4">
                <flux:input
                    :label="__('Profile Image')"
                    wire:model="profile_image"
                    type="file"
                    id="profile_image"
                    accept="image/*" />

                @if ($profile_image)
                    <div class="mt-2">
                        <p class="text-sm text-gray-800 dark:text-white">Preview:</p>
                        <img src="{{ $profile_image->temporaryUrl() }}" alt="Preview" class="mt-1 h-32 w-32 object-cover rounded">
                    </div>
                @elseif ($currentProfileImage)
                    <div class="mt-4 relative inline-block">
                        <img src="{{ Storage::url($currentProfileImage) }}"
                            alt="Profile Image"
                            class="h-32 w-32 object-cover rounded border">
                        <x-delete-image-button wire:click="deleteProfileImage" wire:confirm="Are you sure you want to delete your profile image?" />
                    </div>
                @endif

                <div wire:loading wire:target="profile_image" class="text-sm text-gray-600 mt-2">
                    Uploading...
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <x-cinema-button type="submit" :glow="true" palette="gold">
                        {{ __('Save') }}
                    </x-cinema-button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
