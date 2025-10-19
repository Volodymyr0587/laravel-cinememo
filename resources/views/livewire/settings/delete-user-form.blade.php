<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('settings/delete-user-form.delete_account') }}</flux:heading>
        <flux:subheading>{{ __('settings/delete-user-form.delete_account_and_resources') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <x-cinema-button :glow="true" palette="red" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('settings/delete-user-form.delete_account_button') }}
        </x-cinema-button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form wire:submit="deleteUser" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('settings/delete-user-form.are_you_sure') }}</flux:heading>

                <flux:subheading>
                    {{ __('settings/delete-user-form.once_your_account_is_deleted') }}
                </flux:subheading>
            </div>

            <flux:input wire:model="password" :label="__('settings/delete-user-form.password')" type="password" />

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('settings/delete-user-form.cancel_button') }}</flux:button>
                </flux:modal.close>
                <x-cinema-button :glow="true" palette="red" type="submit">
                    {{ __('settings/delete-user-form.delete_button') }}
                </x-cinema-button>
            </div>
        </form>
    </flux:modal>
</section>
