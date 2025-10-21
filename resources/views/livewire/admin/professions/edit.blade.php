<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __("professions/edit.edit_profession") }} <span class="text-2xl">"{{ $profession->name }}"</span>
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form wire:submit="save">
                <div class="mb-4">
                    <flux:input
                        wire:model="name"
                        :label="__('professions/edit.name')"
                        type="text"
                        autofocus
                        autocomplete="name"
                        placeholder="Director"
                    />
                </div>

                <div class="my-4">
                    <flux:textarea wire:model="description" :label="__('professions/edit.description')" id="description" rows="4"></flux:textarea>
                </div>

                    <div class="flex items-center justify-between">
                    <x-cinema-button type="submit" :glow="true" palette="gold">
                        {{ __("professions/edit.update_button") }}
                    </x-cinema-button>
                    <x-cinema-button :href="route('admin.professions.index')" :glow="true" palette="gray" wire:navigate>
                        {{ __("professions/edit.cancel_button") }}
                    </x-cinema-button>
                </div>
            </form>
        </div>
    </div>
</div>
