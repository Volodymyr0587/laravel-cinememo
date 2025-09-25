<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Create Content Item') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <flux:select wire:model="content_type_id" id="content_type_id" :label="__('Category') . ' *'">
                                    <option value="">Select a category</option>
                                    @foreach($contentTypes as $contentType)
                                        <option value="{{ $contentType->id }}">{{ $contentType->name }}</option>
                                    @endforeach
                                </flux:select>
                                {{-- @error('content_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror --}}
                            </div>

                            <div>

                                <flux:select wire:model="status" id="status" :label="__('Status')">
                                    @foreach(\App\Enums\ContentStatus::labels() as $value => $label)
                                        <option value="{{ $value }}">{{ __($label) }}</option>
                                    @endforeach
                                </flux:select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="title"
                                :label="__('Title') . ' *'"
                                type="text"
                                autocomplete="title"
                                placeholder="The Lord of the Rings: The Fellowship of the Ring"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="release_date"
                                :label="__('Release date')"
                                type="date"
                                autocomplete="release_date"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="description" :label="__('Description')" id="description" rows="4"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <flux:input wire:model="video_url" :label="__('YouTube video url')" id="video_url"
                                placeholder="https://youtu.be/xxxx or https://www.youtube.com/watch?v=xxxx"/>
                        </div>

                        <flux:label class="mt-4">Duration</flux:label>
                        <div class="flex flex-col lg:flex-row gap-4">
                            <div class="flex-1 max-w-3xs">
                                <flux:input wire:model="hours" :label="__('Hours')" type="number" min="0" />
                            </div>

                            <div class="flex-1 max-w-3xs">
                                <flux:input wire:model="minutes" :label="__('Minutes')" type="number" min="0" max="59" />
                            </div>

                            <div class="flex-1 max-w-3xs">
                                <flux:input wire:model="seconds" :label="__('Seconds')" type="number" min="0" max="59" />
                            </div>
                        </div>

                        {{-- Actors --}}
                        {{-- <div class="mt-4">
                            <label for="actors" class="block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                                {{ __("Actors") }}
                            </label>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                               @forelse($allUserActors as $actor)
                                    <label x-data="{ hover: false }" class="relative flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox"
                                            id="actor_{{ $actor->id }}"
                                            wire:model="actors"
                                            value="{{ $actor->id }}"
                                            class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600">

                                        <span @mouseenter="hover = true" @mouseleave="hover = false"
                                            class="text-gray-700 dark:text-white text-sm relative">
                                            {{ $actor->name }}
                                            <div x-show="hover"
                                                x-transition
                                                class="absolute z-50 top-full left-0 mt-2 w-32 h-32 bg-white dark:bg-zinc-800 shadow-lg rounded-lg overflow-hidden border hidden sm:block">
                                                @if($actor->main_image_url)
                                                <img src="{{ $actor->main_image_url }}"
                                                    alt="{{ $actor->name }}"
                                                    class="w-full h-full object-cover">
                                                @else
                                                <img src="{{ asset('images/default-actor.png') }}"
                                                    alt="{{ $actor->name }}"
                                                    class="w-full h-full object-cover"
                                                >
                                                @endif
                                            </div>
                                        </span>
                                    </label>
                                @empty
                                    <span class="font-semibold italic text-xs dark:text-white">
                                        {{ __("There are no actors in your collection yet.") }}
                                    </span>
                                @endforelse
                            </div>
                            <hr class="my-12 h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                        </div> --}}
                        {{-- End Actors --}}

                        <div>
                            <flux:label class="mt-4">{{ __("People & Professions") }}</flux:label>
                            @foreach($professions as $profession)
                                @if($profession->people->isNotEmpty())
                                    <div class="mb-6">
                                        <h3 class="text-md font-bold text-gray-900 dark:text-white mb-3">
                                            {{ Str::plural($profession->name) }}
                                        </h3>

                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                            @foreach($profession->people as $person)
                                                <label x-data="{ hover: false }" class="relative flex items-center space-x-2 cursor-pointer">
                                                    <input type="checkbox"
                                                        id="person_{{ $person->id }}_profession_{{ $profession->id }}"
                                                        wire:model="selectedPeople.{{ $person->id }}_{{ $profession->id }}"
                                                        class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white
                                                            checked:bg-lime-600 checked:border-lime-600">

                                                    <span @mouseenter="hover = true" @mouseleave="hover = false"
                                                        class="text-gray-700 dark:text-white text-sm relative">
                                                        {{ $person->name }}

                                                        <div x-show="hover"
                                                            x-transition
                                                            class="absolute z-50 top-full left-0 mt-2 w-32 h-32 bg-white dark:bg-zinc-800 shadow-lg rounded-lg overflow-hidden border sm:block">
                                                            @if($person->main_image_url)
                                                                <img src="{{ $person->main_image_url }}"
                                                                    alt="{{ $person->name }}"
                                                                    class="w-full h-full object-cover">
                                                            @else
                                                                <img src="{{ asset('images/default-person.png') }}"
                                                                    alt="{{ $person->name }}"
                                                                    class="w-full h-full object-cover">
                                                            @endif
                                                        </div>
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <hr class="my-12 h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                        </div>

                        <div class="mt-4">
                            <label for="genres" class="block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                                {{ __("Genres") }}
                            </label>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                @foreach($allGenres as $genre)
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox"
                                            id="genre_{{ $genre->id }}"
                                            wire:model="genres"
                                            value="{{ $genre->id }}"
                                             class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600">
                                        <span class="text-gray-700 dark:text-white text-sm">{{ $genre->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <hr class="my-12 h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                        </div>

                        <div class="mt-4">
                            <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">{{ __("Visibility") }}</p>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox"
                                    wire:model="is_public"
                                    class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600">
                                <div class="grid grid-cols-1">
                                    <span class="text-gray-700 dark:text-white text-sm">{{ __("Make Public") }}</span>
                                    <span class="text-xs italic">(Other users will be able to view this content and leave comments)</span>
                                </div>
                            </label>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                :label="__('Image')"
                                wire:model="main_image"
                                type="file"
                                id="main_image"
                                accept="image/*" />

                            @if ($main_image)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-800 dark:text-white">Preview:</p>
                                    <img src="{{ $main_image->temporaryUrl() }}" alt="Preview" class="mt-1 h-32 w-32 object-cover rounded">
                                </div>
                            @endif

                            <div wire:loading wire:target="image" class="text-sm text-gray-600 mt-2">
                                Uploading...
                            </div>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                :label="__('Additional images')"
                                wire:model="additional_images"
                                type="file"
                                multiple />
                        </div>

                         @if ($additional_images)
                            <div class="mt-4">
                                <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">Additional Image Previews:</p>
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($additional_images as $file)
                                        <div class="w-24 h-24">
                                            <img src="{{ $file->temporaryUrl() }}" alt="Preview"
                                                class="w-full h-full object-cover rounded border border-gray-300">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="my-12">
                            <hr class="h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                            <p class="mt-2 font-bold text-xs italic">* - {{ __("Required fields") }}</p>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <flux:button variant="primary" type="submit" >{{ __('Create Content Item') }}</flux:button>
                            <flux:link :href="route('content-items.index')" wire:navigate>{{ __('Cancel') }}</flux:link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
