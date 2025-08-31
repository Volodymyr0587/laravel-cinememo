<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Edit User') }} - {{ $user->name }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <flux:input
                                    :label="__('Name')"
                                    type="text"
                                    disabled
                                    value="{{ $user->name }}"
                                />
                            </div>
                            <div>
                                <flux:input
                                    :label="__('Email')"
                                    type="email"
                                    disabled
                                    value="{{ $user->email }}"
                                />
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                                {{ __("Roles") }}
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                @foreach($allRoles as $role)
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input
                                            type="checkbox"
                                            wire:model="roles"
                                            value="{{ $role->name }}"
                                            class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600"
                                        >
                                        <span class="text-gray-700 dark:text-white text-sm">{{ ucfirst($role->name) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <flux:button variant="primary" type="submit" class="hover:cursor-pointer">
                                {{ __('Update User') }}
                            </flux:button>
                            <flux:link :href="route('admin.users.index')" wire:navigate>
                                {{ __('Cancel') }}
                            </flux:link>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
            <div class="overflow-hidden border border-red-500 dark:border-red-400 bg-white dark:bg-zinc-800 shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-600 dark:text-red-400">
                        {{ __('Danger Zone') }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                        {{ __('Once you delete this user, all of their data will be permanently removed. This action cannot be undone.') }}
                    </p>
                    <div class="mt-4">
                        @can('delete_users')
                        <flux:button
                            size="sm"
                            variant="danger"
                            wire:click="delete({{ $user->id }})"
                            wire:confirm="Are you sure you want to delete this user? This action cannot be undone."
                            class="hover:cursor-pointer"
                        >
                            Delete
                        </flux:button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <!-- End Danger Zone -->
    </div>
</div>
