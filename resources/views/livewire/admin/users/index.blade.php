<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Users') }}
            @if($roleFilter || $search)
                <flux:button
                    wire:click="clearFilters"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('Clear filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            <x-button href="{{ route('admin.users.create') }}" class="order-1 sm:order-none" wire:navigate>{{ __('Add New User') }}</x-button>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">

                    <x-flash-message />

                    <!-- Filters -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <flux:input
                                wire:model.live="search"
                                :label="__('Search')"
                                type="text"
                                :placeholder="__('Search user...')"
                            />
                        </div>
                        {{-- <div>
                            <flux:select wire:model.live="genreFilter" :label="__('Genre')">
                                <option value="">All Genres</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ __($genre->name) }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div>
                            <flux:select wire:model.live="statusFilter" :label="__('Status')">
                                <option value="">All Statuses</option>
                                @foreach(\App\Enums\ContentStatus::labels() as $value => $label)
                                    <option value="{{ $value }}">{{ __($label) }}</option>
                                @endforeach
                            </flux:select>
                        </div> --}}
                        {{-- <div>
                            <flux:select wire:model.live="contentItemFilter" :label="__('Content')">
                                <option value="">All Content</option>
                                @foreach($contentItems as $contentItem)
                                    <option value="{{ $contentItem->id }}">{{ $contentItem->title }}</option>
                                @endforeach
                            </flux:select>
                        </div> --}}
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                            <thead class="bg-gray-50 dark:bg-zinc-800">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Roles</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date of registration</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
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
                                                No roles
                                            @endforelse

                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $user->created_at }}</td>
                                        <td class="px-4 py-2 text-right space-x-2">
                                            @can('view_users')
                                            <flux:button
                                                size="sm"
                                                variant="primary"
                                                color="lime"
                                                href="{{ route('admin.users.show', $user) }}"
                                                wire:navigate
                                                class="hover:cursor-pointer"
                                            >
                                                {{ __("Details") }}
                                            </flux:button>
                                            @endcan
                                            @can('edit_users')
                                            <flux:button
                                                size="sm"
                                                variant="primary"
                                                color="indigo"
                                                href="{{ route('admin.users.edit', $user) }}"
                                                wire:navigate
                                                class="hover:cursor-pointer"
                                            >
                                                Edit
                                            </flux:button>
                                            @endcan
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
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-300">
                                            No users found.
                                            <flux:link :href="route('admin.users.create')" wire:navigate class="ml-2">{{ __('Add First User') }}</flux:link>
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
