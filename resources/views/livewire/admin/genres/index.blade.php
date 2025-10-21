<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('genres/main.genres') }}
            @if($search)
                <flux:button
                    wire:click="clearFilters"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('genres/main.clear_filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            <x-cinema-button href="{{ route('admin.genres.create') }}"
                class="order-1 sm:order-none"
                wire:navigate
                :glow="true"
                palette="gold"
            >
                {{ __('genres/main.add_new_genre') }}
            </x-cinema-button>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <x-flash-message />

                    <!-- Filters -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <flux:input
                                wire:model.live="search"
                                :label="__('genres/main.search')"
                                type="text"
                                :placeholder="__('genres/main.search_placeholder')"
                            />
                        </div>
                    </div>

                    <!-- Genres Table -->
                    <div>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('genres/main.name') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('genres/main.description') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('genres/main.updated_at') }}</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('genres/main.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                                @forelse($allGenres as $genre)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $genre->id }}</td>
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-white">{{ $genre->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ Str::limit($genre->description, 40) }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $genre->created_at }}</td>
                                        <td class="px-4 py-2 text-right space-x-2">

                                        <x-cinema-button href="{{ route('admin.genres.show', $genre) }}"
                                                class=""
                                                wire:navigate
                                                :glow="true"
                                                palette="green"
                                            >
                                            {{ __("genres/main.details_button") }}
                                        </x-cinema-button>

                                        <x-cinema-button href="{{ route('admin.genres.edit', $genre) }}"
                                            class=""
                                            wire:navigate
                                            :glow="true"
                                            palette="purple"
                                        >
                                            {{ __("genres/main.edit_button") }}
                                        </x-cinema-button>

                                        <x-cinema-button wire:click="delete({{ $genre->id }})"
                                            wire:confirm="{{ __('genres/main.are_you_sure', ['name' => $genre->name]) }}"
                                            :glow="true"
                                            palette="red"
                                        >
                                            {{ __("genres/main.delete_button") }}
                                        </x-cinema-button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-300">
                                             {{ __("genres/main.no_genres_found") }}
                                            <flux:link :href="route('admin.genres.create')" wire:navigate class="ml-2">{{ __('genres/main.add_first_genre') }}</flux:link>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $allGenres->links('pagination.custom-tailwind') }}
                    </div>


        </div>
    </div>
</div>
