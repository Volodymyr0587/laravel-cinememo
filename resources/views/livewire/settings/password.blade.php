<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('settings/password.update_password')" :subheading="__('settings/password.ensure_password_secure')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                wire:model="current_password"
                :label="__('settings/password.current_password')"
                type="password"
                required
                autocomplete="current-password"
            />
            <flux:input
                wire:model="password"
                :label="__('settings/password.new_password')"
                type="password"
                required
                autocomplete="new-password"
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('settings/password.confirm_password')"
                type="password"
                required
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <x-cinema-button type="submit" :glow="true" palette="gold">
                        {{ __('settings/password.save_button') }}
                    </x-cinema-button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('settings/password.saved_message') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
