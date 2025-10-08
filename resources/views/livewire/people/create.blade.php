<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('people/create.add_person') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save" enctype="multipart/form-data">

                        <div class="mt-4">
                            <flux:input
                                {{-- wire:model="name" --}}
                                wire:model.live.debounce.300ms="name"
                                :label="__('people/create.name') . ' *'"
                                type="text"
                                autocomplete="name"
                                placeholder="Leonardo DiCaprio"
                            />
                        </div>

                        <!-- Show existing people with similar names -->
                        @if(!empty($existing_people) && count($existing_people) > 0)
                            <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                <p class="text-sm text-yellow-800 font-medium mb-2">
                                    ⚠️ {{ __('people/create.similar_people') }}:
                                </p>
                                <ul class="space-y-1">
                                    @foreach($existing_people as $existing)
                                        <li class="text-sm text-yellow-700">
                                            • {{ $existing['display_name'] }}
                                        </li>
                                    @endforeach
                                </ul>
                                <p class="text-xs text-yellow-600 mt-2">
                                    {{ __('people/create.can_still_create') }}.
                                </p>
                            </div>
                        @endif

                        <div class="mt-4">
                            <flux:input
                                wire:model="birth_date"
                                :label="__('people/create.birth_date') . ' **'"
                                type="date"
                                autocomplete="birth_date"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="birth_place"
                                :label="__('people/create.birth_place')"
                                type="text"
                                autocomplete="birth_place"
                                placeholder="Los Angeles, California, United States"
                            />
                        </div>

                         <div class="mt-4">
                            <flux:input
                                wire:model="death_date"
                                :label="__('people/create.death_date') . ' **'"
                                type="date"
                                autocomplete="death_date"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="death_place"
                                :label="__('people/create.death_place')"
                                type="text"
                                autocomplete="death_place"
                                placeholder="Los Angeles, California, United States"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="biography" :label="__('people/create.biography')" id="biography" rows="6"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                                {{ __("people/create.select_professions") }}
                            </label>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-3">
                                @forelse($allProfessions as $profession)
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox"
                                            wire:model="professions"
                                            value="{{ $profession->id }}"
                                            class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600">
                                        <span class="text-gray-700 dark:text-white text-sm">
                                            {{ $profession->name }}
                                        </span>
                                    </label>
                                @empty
                                    <span class="font-semibold italic text-xs dark:text-white">
                                        {{ __("people/create.no_professions_yet") }}.
                                    </span>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                :label="__('people/create.image')"
                                wire:model="main_image"
                                type="file"
                                id="main_image"
                                accept="image/*" />

                            @if ($main_image)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-800 dark:text-white">{{ __("people/create.preview") }}:</p>
                                    <img src="{{ $main_image->temporaryUrl() }}" alt="{{ __("people/create.preview") }}" class="mt-1 h-32 w-32 object-cover rounded">
                                </div>
                            @endif

                            <div wire:loading wire:target="image" class="text-sm text-gray-600 mt-2">
                                {{ __("people/create.uploading") }}...
                            </div>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                :label="__('people/create.additional_images')"
                                wire:model="additional_images"
                                type="file"
                                multiple />
                        </div>

                         @if ($additional_images)
                            <div class="mt-4">
                                <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">{{ __('people/create.additional_image_previews') }}</p>
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($additional_images as $file)
                                        <div class="w-24 h-24">
                                            <img src="{{ $file->temporaryUrl() }}" alt="{{ __("people/create.preview") }}"
                                                class="w-full h-full object-cover rounded border border-gray-300">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="my-12">
                            <hr class="h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                            <p class="mt-2 font-bold text-xs italic">* - {{ __("people/create.required_fields") }}</p>
                            <p class="mt-2 font-bold text-xs italic">** - {{ __("people/create.enter_full_date") }}</p>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <x-cinema-button type="submit" :glow="true" palette="gold">
                                {{ __("people/create.add_person_button") }}
                            </x-cinema-button>
                            <x-cinema-button :href="route('people.index')" :glow="true" palette="gray" wire:navigate>
                                {{ __("people/create.cancel_button") }}
                            </x-cinema-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

