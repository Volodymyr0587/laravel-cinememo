<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Add Person to your library') }}
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
                                :label="__('Name') . ' *'"
                                type="text"
                                autocomplete="name"
                                placeholder="Leonardo DiCaprio"
                            />
                        </div>

                        <!-- Show existing people with similar names -->
                        @if(!empty($existing_people) && count($existing_people) > 0)
                            <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                <p class="text-sm text-yellow-800 font-medium mb-2">
                                    ⚠️ You already have similar people:
                                </p>
                                <ul class="space-y-1">
                                    @foreach($existing_people as $existing)
                                        <li class="text-sm text-yellow-700">
                                            • {{ $existing['display_name'] }}
                                        </li>
                                    @endforeach
                                </ul>
                                <p class="text-xs text-yellow-600 mt-2">
                                    You can still create this person if it's a different person.
                                </p>
                            </div>
                        @endif

                        <div class="mt-4">
                            <flux:input
                                wire:model="birth_date"
                                :label="__('Birth date') . ' **'"
                                type="date"
                                autocomplete="birth_date"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="birth_place"
                                :label="__('Birth place')"
                                type="text"
                                autocomplete="birth_place"
                                placeholder="Los Angeles, California, United States"
                            />
                        </div>

                         <div class="mt-4">
                            <flux:input
                                wire:model="death_date"
                                :label="__('Death date') . ' **'"
                                type="date"
                                autocomplete="death_date"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="death_place"
                                :label="__('Death place')"
                                type="text"
                                autocomplete="death_place"
                                placeholder="Los Angeles, California, United States"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="biography" :label="__('Biography')" id="biography" rows="6"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                                {{ __("Select professions") }}
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
                                        {{ __("There are no professions in your collection yet.") }}
                                    </span>
                                @endforelse
                            </div>
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
                            <p class="mt-2 font-bold text-xs italic">** - {{ __("Enter the full date (MM-DD-YYYY) or leave blank") }}</p>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <x-cinema-button type="submit" :glow="true" palette="gold">
                                {{ __("Add Person") }}
                            </x-cinema-button>
                            <x-cinema-button :href="route('people.index')" :glow="true" palette="gray" wire:navigate>
                                {{ __("Cancel") }}
                            </x-cinema-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

