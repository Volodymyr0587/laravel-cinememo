<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('users/main.users') }}
            @if($roleFilter || $search)
                <flux:button
                    wire:click="clearFilters"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('users/main.clear_filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            <x-cinema-button href="{{ route('admin.users.create') }}"
                class="order-1 sm:order-none"
                wire:navigate
                :glow="true"
                palette="gold"
            >
                {{ __('users/main.add_new_user') }}
            </x-cinema-button>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">

                    <x-flash-message />

                    <!-- Filters -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <flux:input
                                wire:model.live="search"
                                :label="__('users/main.search')"
                                type="text"
                                :placeholder="__('users/main.search_user')"
                            />
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                            <thead class="">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('users/main.name') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('users/main.email') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('users/main.roles') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('users/main.date_of_registration') }}</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('users/main.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                                @forelse($allUsers as $user)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $user->id }}</td>
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $user->email }}</td>
                                        <td class="px-4 py-2 text-sm">
                                            @forelse ($user->getRoleNames() as $roleName)
                                                <span wire:click="$set('roleFilter', '{{ $roleName }}')" class="px-2 py-1 mr-1 rounded text-xs font-bold bg-blue-500 text-white hover:cursor-pointer">
                                                    {{ $roleName }}
                                                </span>
                                            @empty
                                                {{ __('users/main.no_roles') }}
                                            @endforelse

                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $user->created_at }}</td>
                                        <td class="px-4 py-2 text-right space-x-2">

                                            @can('view_users')
                                            <x-cinema-button href="{{ route('admin.users.show', $user) }}"
                                                class=""
                                                wire:navigate
                                                :glow="true"
                                                palette="green"
                                            >
                                                {{ __("users/main.details_button") }}
                                            </x-cinema-button>
                                            @endcan

                                            @can('update', $user)
                                                <x-cinema-button href="{{ route('admin.users.edit', $user) }}"
                                                    class=""
                                                    wire:navigate
                                                    :glow="true"
                                                    palette="purple"
                                                >
                                                    {{ __("users/main.edit_button") }}
                                                </x-cinema-button>
                                            @else
                                                <x-cinema-button
                                                    palette="gray" disabled
                                                >
                                                    {{ __("users/main.edit_button") }}
                                                </x-cinema-button>
                                            @endcan

                                            @can('delete', $user)
                                                <x-cinema-button wire:click="delete({{ $user->id }})"
                                                    wire:confirm="{{ __('users/main.are_you_sure', ['name' => $user->name]) }}"
                                                    :glow="true"
                                                    palette="red"
                                                >
                                                    {{ __("users/main.delete_button") }}
                                                </x-cinema-button>
                                            @else
                                                <x-cinema-button
                                                    palette="gray" disabled
                                                >
                                                    {{ __("users/main.delete_button") }}
                                                </x-cinema-button>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-300">
                                            {{ __("users/main.no_users_found") }}
                                            <flux:link :href="route('admin.users.create')" wire:navigate class="ml-2">{{ __('users/main.add_first_user') }}</flux:link>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $allUsers->links('pagination.custom-tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
