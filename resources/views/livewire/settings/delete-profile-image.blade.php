@if(Auth::user()->profile_image)
<section>
    <div class="mt-2 flex items-center gap-2">
        <img src="{{ Storage::url(Auth::user()->profile_image) }}" alt="Profile"
             class="mt-1 h-32 w-32 object-cover rounded">

        <flux:modal.trigger name="confirm-profile-image-deletion">
            <flux:button
                variant="danger"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-profile-image-deletion')"
                class="hover:cursor-pointer"
            >
                {{ __('Delete') }}
            </flux:button>
        </flux:modal.trigger>
    </div>

    <flux:modal name="confirm-profile-image-deletion" focusable class="max-w-lg">
        <form wire:submit.prevent="deleteProfileImage" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Delete Profile Image') }}</flux:heading>

                <flux:subheading>
                    {{ __('Are you sure you want to delete your profile image? This action cannot be undone.') }}
                </flux:subheading>
            </div>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit" class="hover:cursor-pointer">{{ __('Delete22') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
@endif

