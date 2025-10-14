<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Edit Role') }}: {{ $role->name }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="update">
                        <div class="mb-4">
                            <flux:input
                                wire:model="name"
                                :label="__('Name')"
                                type="text"
                                autofocus
                                autocomplete="name"
                                placeholder="editor"
                            />
                        </div>

                        <div class="mb-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                            @foreach($allPermissions as $perm)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" wire:model="permissions" value="{{ $perm->name }}"
                                        class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600">
                                    <span class="text-gray-700 dark:text-white text-sm">{{ $perm->name }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between">
                            <x-cinema-button type="submit" :glow="true" palette="gold" >
                                {{ __('Update Role') }}
                            </x-cinema-button>
                            <x-cinema-button :href="route('admin.roles.index')" :glow="true" palette="gray" wire:navigate>
                                {{ __("Cancel") }}
                            </x-cinema-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
