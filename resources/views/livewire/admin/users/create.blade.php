<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('users/create.create_user') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save">
                        <div class="grid grid-cols-1 gap-6">
                            <flux:input
                                wire:model="name"
                                :label="__('users/create.name')"
                                type="text"
                                required
                                autofocus
                                autocomplete="name"
                                :placeholder="__('users/create.fullname')"
                            />

                            <!-- Email Address -->
                            <flux:input
                                wire:model="email"
                                :label="__('users/create.email')"
                                type="email"
                                required
                                autocomplete="email"
                                placeholder="email@example.com"
                            />

                            <!-- Password -->
                            <flux:input
                                wire:model="password"
                                :label="__('users/create.password')"
                                type="password"
                                required
                                autocomplete="new-password"
                                :placeholder="__('users/create.password')"
                                viewable
                            />

                            <!-- Confirm Password -->
                            <flux:input
                                wire:model="password_confirmation"
                                :label="__('users/create.confirm_password')"
                                type="password"
                                required
                                autocomplete="new-password"
                                :placeholder="__('users/create.confirm_password')"
                                viewable
                            />
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                                {{ __("users/create.roles") }}
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                @foreach($allRoles as $role)
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input
                                            type="checkbox"
                                            wire:model="roles"
                                            value="{{ $role->name }}"
                                            class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600"
                                            @if($role->name === 'super_admin' && !auth()->user()->hasRole('super_admin')) disabled @endif
                                        >
                                        <div class="text-gray-700 dark:text-white text-sm flex flex-col">
                                            <span>{{ ucfirst($role->name) }}</span>
                                            @if($role->name === 'super_admin' && !auth()->user()->hasRole('super_admin'))
                                                <span class="text-xs text-gray-500">({{ __('users/create.only_super_admin') }})</span>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <x-cinema-button type="submit" :glow="true" palette="gold">
                                {{ __('users/create.create_button') }}
                            </x-cinema-button>
                            <x-cinema-button :href="route('admin.users.index')" :glow="true" palette="gray" wire:navigate>
                                {{ __('users/create.cancel_button') }}
                            </x-cinema-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

