<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Create User') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save">
                        <div class="grid grid-cols-1 gap-6">
                            <flux:input
                                wire:model="name"
                                :label="__('register.form.name')"
                                type="text"
                                required
                                autofocus
                                autocomplete="name"
                                :placeholder="__('register.form.fullname')"
                            />

                            <!-- Email Address -->
                            <flux:input
                                wire:model="email"
                                :label="__('register.form.email')"
                                type="email"
                                required
                                autocomplete="email"
                                placeholder="email@example.com"
                            />

                            <!-- Password -->
                            <flux:input
                                wire:model="password"
                                :label="__('register.form.password')"
                                type="password"
                                required
                                autocomplete="new-password"
                                :placeholder="__('register.form.password')"
                                viewable
                            />

                            <!-- Confirm Password -->
                            <flux:input
                                wire:model="password_confirmation"
                                :label="__('register.form.confirm_password')"
                                type="password"
                                required
                                autocomplete="new-password"
                                :placeholder="__('register.form.confirm_password')"
                                viewable
                            />
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
                            <div class="flex items-center justify-end">
                                <flux:button type="submit" variant="primary" class="w-full hover:cursor-pointer">
                                    {{ __('Create user') }}
                                </flux:button>
                            </div>
                            <flux:link :href="route('admin.users.index')" wire:navigate>
                                {{ __('Cancel') }}
                            </flux:link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

