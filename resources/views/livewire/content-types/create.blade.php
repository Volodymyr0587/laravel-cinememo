<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Create Category') }}
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
                                :label="__('Name')"
                                type="text"
                                autofocus
                                autocomplete="name"
                                placeholder="movie"
                            />

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('Color') }}
                                </label>
                                <input
                                    type="color"
                                    wire:model="color"
                                    class="w-16 h-10 rounded border border-gray-300 dark:border-zinc-600 shadow-sm cursor-pointer
                                        bg-white dark:bg-zinc-700"
                                >
                            </div>

                        </div>

                        <div class="flex items-center justify-between">
                            <flux:button variant="primary" type="submit" >{{ __('Create Category') }}</flux:button>
                            <flux:link :href="route('content-types.index')" wire:navigate>{{ __('Cancel') }}</flux:link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
