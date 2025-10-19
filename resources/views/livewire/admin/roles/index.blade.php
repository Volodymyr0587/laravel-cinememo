<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('roles/main.roles') }}
            @if($search)
                <flux:button
                    wire:click.prevent="clearFilters"
                    wire:key="index-roles-clear-filters-btn"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('roles/main.clear_filters') }}
                </flux:button>
            @endif
        </h2>
        <x-cinema-button href="{{ route('admin.roles.create') }}"
                class="order-1 sm:order-none"
                wire:navigate
                :glow="true"
                palette="gold"
            >
                {{ __('roles/main.add_new_role') }}
        </x-cinema-button>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">

                    <x-flash-message />

                    <div class="mb-4">
                        <flux:input
                            wire:model.live="search"
                            :label="__('roles/main.search')"
                            type="text"
                            :placeholder="__('roles/main.search_role')"
                        />
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('roles/main.name') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('roles/main.permissions') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('roles/main.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($roles as $role)
                                    <tr wire:key="role-{{ $role->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            <span class="px-2 py-1 rounded text-xs font-bold">
                                                {{ $role->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="grid grid-cols-3 gap-x-1 gap-y-1">
                                                @forelse ($role->permissions->pluck('name') as $permissionName)
                                                    <span class="px-2 py-1 rounded text-xs font-bold bg-gray-200 text-gray-900 dark:bg-white dark:text-gray-900">
                                                        {{ $permissionName }}
                                                    </span>
                                                @empty
                                                    {{ __("roles/main.no_permissions") }}
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap space-x-2 text-sm font-medium">
                                            @can('update', $role)
                                            <x-cinema-button href="{{ route('admin.roles.edit', $role) }}"
                                                wire:navigate
                                                :glow="true"
                                                palette="purple"
                                            >{{ __("roles/main.edit_button") }}</x-cinema-button>
                                            @endcan

                                            @can('delete', $role)
                                            <x-cinema-button wire:click="confirmDelete({{ $role->id }})"
                                                :glow="true"
                                                palette="red"
                                            >{{ __("roles/main.delete_button") }}</x-cinema-button>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            {{ __("roles/main.no_roles_found") }}.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div x-data="{ open: @entangle('confirmingDelete') }" x-show="open" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg p-6 w-full max-w-md mx-auto">
                            <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">{{ __("roles/main.confirm_deletion") }}</h2>
                            <p class="mb-6 text-gray-700 dark:text-gray-300">
                               {{ __("roles/main.are_you_sure_main", ['name' => $roleToDelete?->name])}}
                            </p>

                            <div class="flex justify-end space-x-4">
                                <x-cinema-button @click="open = false" palette="gray" :glow="true">
                                {{ __("roles/main.cancel_button") }}
                                </x-cinema-button>
                                <x-cinema-button wire:click="deleteRole" palette="red" :glow="true">
                                    {{ __("roles/main.delete_button") }}
                                </x-cinema-button>
                            </div>
                        </div>
                    </div>


                    <div class="mt-4">
                        {{ $roles->links('pagination.custom-tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


