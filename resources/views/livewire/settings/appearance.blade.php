<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('settings/appearance.appearance')" :subheading=" __('settings/appearance.update_appearance_settings')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('settings/appearance.light') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('settings/appearance.dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('settings/appearance.system') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>
