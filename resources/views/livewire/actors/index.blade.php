<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('actors/main.actors') }}
            @if($contentItemFilter || $search)
                <flux:button
                    wire:click="clearFilters"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('actors/main.clear_filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            {{-- <flux:button
                :href="route('content-items.export')" class="order-2 sm:order-none"
                icon:trailing="arrow-down-tray"
            >
                {{ __('Export to XLSX') }}
            </flux:button>
            <flux:button
                :href="route('content-items.export-pdf')" class="order-3 sm:order-none"
                icon:trailing="arrow-down-tray"
                target="_blank"
            >
               {{ __('Export to PDF') }}
            </flux:button> --}}
            <x-button href="{{ route('actors.create') }}" class="order-1 sm:order-none" wire:navigate>{{ __('actors/main.add_new_actor') }}</x-button>
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
                                :label="__('actors/main.search')"
                                type="text"
                                :placeholder="__('actors/main.search_actor')"
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
                        <div>
                            <flux:select wire:model.live="contentItemFilter" :label="__('actors/main.content')">
                                <option value="">{{ __("actors/main.all_content") }}</option>
                                @foreach($contentItems as $contentItem)
                                    <option value="{{ $contentItem->id }}">{{ $contentItem->title }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                    </div>

                    <!-- Actors Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($actors as $actor)
                            <div class="bg-white dark:bg-zinc-800 dark:text-white rounded-lg shadow-md overflow-hidden">
                                <a href="{{ route('actors.show', $actor) }}"  wire:navigate>
                                    @php
                                        $defaultImagePath = public_path('images/default-actor.png');
                                    @endphp

                                    @if($actor->main_image_url)
                                        <img src="{{ $actor->main_image_url }}" alt="{{ $actor->name }}"
                                            class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                                    @else
                                        @if(\Illuminate\Support\Facades\File::exists($defaultImagePath))
                                            <img src="{{ asset('images/default-actor.png') }}" alt="{{ $actor->name }}"
                                                class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 dark:bg-zinc-400 flex items-center justify-center">
                                                <span class="text-gray-500 dark:text-gray-700">{{ __("actors/main.no_mage") }}</span>
                                            </div>
                                        @endif
                                    @endif
                                </a>

                                <div class="p-4">
                                    <a href="{{ route('actors.show', $actor) }}"  wire:navigate
                                        class="font-semibold text-lg text-gray-800 dark:text-white mb-2 hover:underline">
                                        {{ $actor->name }}
                                    </a>

                                    @if ($actor->birth_date)
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __("actors/main.birth_date") }}:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $actor->birth_date->format('M-d-Y') }}
                                        </span>
                                    </div>
                                    @endif

                                    @if ($actor->birth_place)
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __("actors/main.birth_place") }}:</span>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $actor->birth_place }}" target="_blank"
                                            class="px-2 py-1 rounded text-xs font-bold
                                                bg-gray-900 text-white
                                                dark:bg-white dark:text-gray-900
                                                hover:bg-gray-700 dark:hover:bg-gray-200
                                                hover:shadow-lg hover:scale-105
                                                transition duration-300 ease-out transform">
                                            {{ $actor->birth_place }}
                                        </a>
                                    </div>
                                    @endif

                                    @if ($actor->death_date)
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __("actors/main.death_date") }}:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $actor->death_date->format('M-d-Y') }}
                                        </span>
                                    </div>
                                    @endif

                                    @if ($actor->formatted_age)
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __("actors/main.age") }}:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $actor->formatted_age }}
                                        </span>
                                    </div>
                                    @endif

                                    @if ($actor->death_place)
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __("actors/main.death_place") }}:</span>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $actor->death_place }}" target="_blank"
                                            class="px-2 py-1 rounded text-xs font-bold
                                                bg-gray-900 text-white
                                                dark:bg-white dark:text-gray-900
                                                hover:bg-gray-700 dark:hover:bg-gray-200
                                                hover:shadow-lg hover:scale-105
                                                transition duration-300 ease-out transform">
                                            {{ $actor->death_place }}
                                        </a>
                                    </div>
                                    @endif


                                    <div class="grid grid-cols-1 gap-y-2 mb-4 text-sm">
                                        <span class="font-semibold text-gray-700 dark:text-gray-300 col-span-full">{{ __("actors/main.known_for") }}:</span>
                                        @forelse ($actor->contentItems as $contentItem)
                                            <span
                                                class="px-2 py-1 rounded font-bold text-xs text-white bg-blue-500 dark:bg-blue-600
                                                    hover:bg-blue-600 dark:hover:bg-blue-700 transition-colors duration-200
                                                    text-center cursor-pointer select-none shadow-sm"
                                                    wire:click="$set('contentItemFilter', {{ $contentItem->id }})"
                                                >
                                                {{ $contentItem->title }}
                                            </span>
                                        @empty
                                            <span class="font-semibold italic text-xs dark:text-white">
                                                {{ __("actors/main.no_works") }}
                                            </span>
                                        @endforelse
                                    </div>

{{--
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-3">
                                        <span class="font-medium">Status:</span>
                                        <span wire:click="$set('statusFilter', '{{ $actor->status->value }}')" @class([
                                            'px-2 py-1 rounded text-xs font-bold hover:cursor-pointer',
                                            'bg-green-500 text-white'  => $actor->status === \App\Enums\ContentStatus::Watched,
                                            'bg-blue-500 text-white'   => $actor->status === \App\Enums\ContentStatus::Watching,
                                            'bg-purple-500 text-white' => $actor->status === \App\Enums\ContentStatus::WillWatch,
                                            'bg-amber-500 text-black'  => $actor->status === \App\Enums\ContentStatus::Waiting,
                                        ])>
                                            {{ \App\Enums\ContentStatus::labels()[$actor->status->value] ?? ucfirst($actor->status->value) }}
                                        </span>
                                    </div> --}}

                                    @if($actor->biography)
                                        <p class="text-sm text-gray-600 dark:text-white mb-3">
                                            {{ Str::limit($actor->biography, 100) }}
                                        </p>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <flux:button href="{{ route('actors.edit', $actor) }}" wire:navigate>{{ __("actors/main.edit") }}</flux:button>
                                        <x-button wire:click="delete({{ $actor->id }})"
                                                wire:confirm="{{ __('actors/main.delete_confirm_message') }}"
                                                color="red" type="submit"
                                                >{{ __("actors/main.delete") }}</x-button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500 text-lg">{{ __("actors/main.no_actors_found") }}.</p>
                                <flux:link :href="route('actors.create')" wire:navigate>{{ __("actors/main.add_first_actor") }}</flux:link>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $actors->links('pagination.custom-tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
