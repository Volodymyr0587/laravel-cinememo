<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('people/main.people') }}
            @if($contentItemFilter || $search)
                <flux:button
                    wire:click="clearFilters"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('people/main.clear_filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            <x-cinema-button href="{{ route('people.create') }}"
                class="order-1 sm:order-none"
                wire:navigate
                :glow="true"
                palette="gold"
            >
                {{ __('people/main.add_new_person') }}
            </x-cinema-button>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">

                <x-flash-message />

                <!-- Filters -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <flux:input
                            wire:model.live="search"
                            :label="__('people/main.search')"
                            type="text"
                            :placeholder="__('people/main.search_person')"
                        />
                    </div>
                    <div>
                        <flux:select wire:model.live="contentItemFilter" :label="__('people/main.content')">
                            <option value="">{{ __("people/main.all_content") }}</option>
                            @foreach($contentItems as $contentItem)
                                <option value="{{ $contentItem->id }}">{{ $contentItem->title }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>

                <!-- People Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($people as $person)
                        <div class="glass-card">
                            <a href="{{ route('people.show', $person) }}"  wire:navigate>
                                @php
                                    $defaultImagePath = public_path('images/default-person.png');
                                @endphp

                                @if($person->main_image_url)
                                    <img src="{{ $person->main_image_url }}" alt="{{ $person->name }}"
                                        class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                                @else
                                    @if(\Illuminate\Support\Facades\File::exists($defaultImagePath))
                                        <img src="{{ asset('images/default-person.png') }}" alt="{{ $person->name }}"
                                            class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 dark:bg-zinc-400 flex items-center justify-center">
                                            <span class="text-gray-500 dark:text-gray-700">{{ __("people/main.no_mage") }}</span>
                                        </div>
                                    @endif
                                @endif
                            </a>

                            <div class="p-4">
                                <a href="{{ route('people.show', $person) }}"  wire:navigate
                                    class="font-semibold text-lg text-gray-800 dark:text-white mb-2 hover:underline">
                                    {{ $person->name }}
                                </a>

                                @if ($person->birth_date)
                                <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                    <span class="font-medium">{{ __("people/main.birth_date") }}:</span>
                                    <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                        {{ $person->birth_date->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                                @endif

                                @if ($person->birth_place)
                                <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                    <span class="font-medium">{{ __("people/main.birth_place") }}:</span>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $person->birth_place }}" target="_blank"
                                        class="px-2 py-1 rounded text-xs font-bold
                                            bg-gray-900 text-white
                                            dark:bg-white dark:text-gray-900
                                            hover:bg-gray-700 dark:hover:bg-gray-200
                                            hover:shadow-lg hover:scale-105
                                            transition duration-300 ease-out transform">
                                        {{ $person->birth_place }}
                                    </a>
                                </div>
                                @endif

                                @if ($person->death_date)
                                <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                    <span class="font-medium">{{ __("people/main.death_date") }}:</span>
                                    <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                        {{ $person->death_date->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                                @endif

                                @if ($person->formatted_age)
                                <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                    <span class="font-medium">{{ __("people/main.age") }}:</span>
                                    <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                        {{ $person->formatted_age }}
                                    </span>
                                </div>
                                @endif

                                @if ($person->death_place)
                                <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                    <span class="font-medium">{{ __("people/main.death_place") }}:</span>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $person->death_place }}" target="_blank"
                                        class="px-2 py-1 rounded text-xs font-bold
                                            bg-gray-900 text-white
                                            dark:bg-white dark:text-gray-900
                                            hover:bg-gray-700 dark:hover:bg-gray-200
                                            hover:shadow-lg hover:scale-105
                                            transition duration-300 ease-out transform">
                                        {{ $person->death_place }}
                                    </a>
                                </div>
                                @endif

                                @if($person->biography)
                                    <p class="text-sm text-gray-600 dark:text-white mb-3">
                                        {{ Str::limit($person->biography, 100) }}
                                    </p>
                                @endif

                                <div class="flex justify-between items-center mt-4">
                                    <x-cinema-button href="{{ route('people.edit', $person) }}"
                                        wire:navigate
                                        palette="purple"
                                    >{{ __("people/main.edit") }}</x-cinema-button>
                                    <x-cinema-button wire:click="delete({{ $person->id }})"
                                        wire:confirm="{{ __('people/main.delete_confirm_message') }}"
                                        class="hover:cursor-pointer"
                                        palette="red"
                                    >{{ __("people/main.delete") }}</x-cinema-button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500 text-lg">{{ __("people/main.no_people_found") }}.</p>
                            <flux:link :href="route('people.create')" wire:navigate>{{ __("people/main.add_first_person") }}</flux:link>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $people->links('pagination.custom-tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>
