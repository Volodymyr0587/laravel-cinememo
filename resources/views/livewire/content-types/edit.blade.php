<div>
    <div class="mt-2 flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('content_types/edit.update_category') }} <span>"{{ $contentType->name }}"</span>
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg">
                <form wire:submit="save">
                    <div class="mb-4">
                        <flux:input
                            wire:model="name"
                            :label="__('content_types/edit.name')"
                            type="text"
                            autofocus
                            autocomplete="name"
                            placeholder="movie"
                        />
                    </div>

                    <div class="my-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('content_types/create.color') }}
                        </label>
                        <input
                            type="color"
                            wire:model="color"
                            value="{{ $contentType->color }}"
                            class="w-16 h-10 rounded border border-gray-300 dark:border-zinc-600 shadow-sm cursor-pointer
                                bg-white dark:bg-zinc-700"
                        >
                    </div>

                        <div class="flex items-center justify-between">
                        <x-cinema-button type="submit" :glow="true" palette="gold">
                            {{ __('content_types/edit.update_category') }}
                        </x-cinema-button>
                        <x-cinema-button :href="route('content-types.index')" :glow="true" palette="gray" wire:navigate>
                            {{ __('content_types/edit.cancel') }}
                        </x-cinema-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
