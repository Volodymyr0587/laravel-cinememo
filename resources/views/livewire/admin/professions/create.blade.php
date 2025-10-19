<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __("professions/create.add_new_profession") }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save">
                        <div class="mb-4">
                            <flux:input
                                wire:model="name"
                                :label="__('professions/create.name')"
                                type="text"
                                autofocus
                                autocomplete="name"
                                placeholder="Director"
                            />

                            <div class="mt-4">
                                <flux:textarea wire:model="description" :label="__('professions/create.description')" id="description" rows="4"></flux:textarea>
                            </div>

                        </div>

                        <div class="flex items-center justify-between">
                            <x-cinema-button type="submit" :glow="true" palette="gold">
                                {{ __('professions/create.create_button') }}
                            </x-cinema-button>
                            <x-cinema-button :href="route('admin.professions.index')" :glow="true" palette="gray" wire:navigate>
                                {{ __('professions/create.cancel_button') }}
                            </x-cinema-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
