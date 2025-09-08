{{-- <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white">{{ __('Roles') }}</h2>

        <input type="text" wire:model.debounce.300ms="search" placeholder="Search roles..."
               class="px-3 py-2 rounded border dark:bg-zinc-700 dark:text-white">

        <a href="{{ route('admin.roles.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            {{ __('Create Role') }}
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
            <thead class="bg-gray-50 dark:bg-zinc-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-white uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-white uppercase tracking-wider">Permissions</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-white uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
            @foreach($roles as $role)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $role->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ $role->permissions->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $roles->links() }}
        </div>
    </div>
</div> --}}

<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Roles') }}

            @if($search)
                <flux:button
                    wire:click.prevent="clearFilters"
                    wire:key="index-roles-clear-filters-btn"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('Clear filters') }}
                </flux:button>
            @endif
        </h2>
        <x-button href="{{ route('admin.roles.create') }}" wire:navigate>{{ __('Add New Role') }}</x-button>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">

                    <x-flash-message />

                    <div class="mb-4">
                        <flux:input
                            wire:model.live="search"
                            :label="__('Search')"
                            type="text"
                            :placeholder="__('Search role...')"
                        />
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($roles as $role)
                                    <tr wire:key="role-{{ $role->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            <span class="px-2 py-1 rounded text-xs font-bold" style="background-color: {{ $role->color }}">
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
                                                    {{ __("No permissions") }}
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.roles.edit', $role) }}"
                                               class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                            <button wire:click="confirmDelete({{ $role->id }})"
                                                    class="text-red-600 hover:text-red-900 hover:cursor-pointer">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            {{ __("No roles found") }}.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div x-data="{ open: @entangle('confirmingDelete') }" x-show="open" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg p-6 w-full max-w-md mx-auto">
                            <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Confirm Deletion</h2>
                            <p class="mb-6 text-gray-700 dark:text-gray-300">
                                Are you sure you want to delete role '{{ $roleToDelete?->name }}'? This action cannot be undone.
                            </p>

                            <div class="flex justify-end space-x-4">
                                <button @click="open = false" type="button"
                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                                <button wire:click="deleteRole" type="button"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Delete
                                </button>
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


