<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                        {{ __('people/edit.edit_person') }} - {{ $person->name }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save" enctype="multipart/form-data">

                        <div class="mt-4">
                            <flux:input
                                wire:model="name"
                                :label="__('people/edit.name') . ' *'"
                                type="text"
                                autocomplete="name"
                                placeholder="Leonardo DiCaprio"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="birth_date"
                                :label="__('people/edit.birth_date') . ' **'"
                                type="date"
                                autocomplete="birth_date"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="birth_place"
                                :label="__('people/edit.birth_place')"
                                type="text"
                                autocomplete="birth_place"
                                placeholder="Los Angeles, California, United States"
                            />
                        </div>

                         <div class="mt-4">
                            <flux:input
                                wire:model="death_date"
                                :label="__('people/edit.death_date') . ' **'"
                                type="date"
                                autocomplete="death_date"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="death_place"
                                :label="__('people/edit.death_place')"
                                type="text"
                                autocomplete="death_place"
                                placeholder="Los Angeles, California, United States"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="biography" :label="__('people/edit.biography')" id="biography" rows="6"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                                {{ __("people/edit.select_professions") }}
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
                                        {{ __("people/edit.no_professions_yet") }}.
                                    </span>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-4">
                            {{-- Existing Image Preview --}}
                            @if($person->main_image_url)
                            <div class="mt-2 mb-4">
                                <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">{{ __("people/edit.current_image") }}</p>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $person->main_image_url }}" alt="{{ __("people/edit.current_image") }}"
                                        class="h-24 w-24 object-cover rounded">
                                    <x-cinema-button type="button" :glow="true" palette="red" wire:click="confirmMainImageRemoval">
                                        {{ __("people/edit.remove_image_button") }}
                                    </x-cinema-button>
                                </div>
                            </div>
                            @endif

                            {{-- File Upload Input --}}
                            <flux:input :label="__('people/edit.image')" wire:model="new_main_image" type="file" id="new_main_image"
                                accept="image/*" />

                            {{-- Validation Error --}}
                            @error('new_main_image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            {{-- New Image Preview --}}
                            @if ($new_main_image)
                            <div class="mt-2">
                                <p class="text-sm text-gray-800 dark:text-white">{{ __("people/edit.preview") }}:</p>
                                <img src="{{ $new_main_image->temporaryUrl() }}" alt="{{ __("people/edit.preview") }}"
                                    class="mt-1 h-32 w-32 object-cover rounded">
                            </div>
                            @endif

                            @if ($person->additionalImages->isNotEmpty())
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">{{ __("people/edit.additional_images") }}</p>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach ($person->additionalImages as $image)
                                            <div class="relative">
                                                <img src="{{ Storage::url($image->path) }}" alt="{{ __("people/edit.additional_images") }}"
                                                    class="h-24 w-24 object-cover rounded border border-gray-300">
                                                <x-delete-image-button wire:click="confirmAdditionalImageRemoval({{ $image->id }})" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Additional Images Preview --}}
                            @if ($newAdditionalImages)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">{{ __("people/edit.additional_image_previews") }}:</p>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach ($newAdditionalImages as $file)
                                            <div class="w-24 h-24">
                                                <img src="{{ $file->temporaryUrl() }}" alt="Preview"
                                                    class="w-full h-full object-cover rounded border border-gray-300">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-4">
                                <flux:input
                                    :label="__('people/edit.additional_images')"
                                    wire:model="newAdditionalImages"
                                    type="file"
                                    multiple />
                            </div>

                            {{-- Uploading indicator --}}
                            <div wire:loading wire:target="image" class="text-sm text-gray-600 mt-2">
                                {{ __('people/edit.uploading') }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="my-12">
                                <hr class="h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                                <p class="mt-2 font-bold text-xs italic">* - {{ __("people/edit.required_fields") }}</p>
                                <p class="mt-2 font-bold text-xs italic">** - {{ __("people/edit.enter_full_date") }}</p>
                            </div>

                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <x-cinema-button type="submit" :glow="true" palette="gold">
                                {{ __("people/edit.update_person_button") }}
                            </x-cinema-button>
                            <x-cinema-button :href="route('people.index')" :glow="true" palette="gray" wire:navigate>
                                {{ __("people/edit.cancel_button") }}
                            </x-cinema-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div
    x-data="{ showModal: @entangle('confirmingMainImageRemoval') }"
    x-show="showModal"
    x-cloak
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md mx-auto">
        <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">{{ __("people/edit.confirm_image_deletion") }}</h2>
        <p class="mb-6 text-gray-700 dark:text-gray-300">{{ __("people/edit.are_you_sure_main") }}</p>

        <div class="flex justify-end space-x-4">
            <x-cinema-button @click="showModal = false"
                type="button" :glow="true" palette="gray">
                {{ __("people/edit.cancel_button") }}
            </x-cinema-button>
            <x-cinema-button wire:click="removeMainImage"
                type="button" :glow="true" palette="red">
                {{ __("people/edit.delete_button") }}
            </x-cinema-button>
        </div>
    </div>
</div>


<div
    x-data="{ showModal: @entangle('confirmingImageRemoval') }"
    x-show="showModal"
    x-cloak
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md mx-auto">
        <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">{{ __("people/edit.confirm_image_deletion") }}</h2>
        <p class="mb-6 text-gray-700 dark:text-gray-300">{{ __("people/edit.are_you_sure_additional") }}</p>

        <div class="flex justify-end space-x-4">
            <x-cinema-button @click="showModal = false"
                type="button" :glow="true" palette="gray">
                {{ __("people/edit.cancel_button") }}
            </x-cinema-button>
            <x-cinema-button wire:click="deleteAdditionalImageConfirmed"
                type="button" :glow="true" palette="red">
                {{ __("people/edit.delete_button") }}
            </x-cinema-button>
        </div>
    </div>
</div>
</div>

