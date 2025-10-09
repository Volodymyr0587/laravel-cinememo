<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8"">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('content_items/edit.edit_content_item') }} - {{ $contentItem->title }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <flux:select wire:model="content_type_id" id="content_type_id"
                                    :label="__('content_items/edit.category') . ' *'">
                                    <option value="">{{ __('content_items/edit.select_category_dropdown') }}</option>
                                    @foreach($contentTypes as $contentType)
                                    <option value="{{ $contentType->id }}">{{ $contentType->name }}</option>
                                    @endforeach
                                </flux:select>
                            </div>

                            <div>
                                <flux:select wire:model="status" id="status" :label="__('content_items/edit.status')">
                                    @foreach(\App\Enums\ContentStatus::labels() as $value => $label)
                                        <option value="{{ $value }}">{{ __($label) }}</option>
                                    @endforeach
                                </flux:select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <flux:input wire:model="title" :label="__('content_items/edit.title') . ' *'" type="text" autocomplete="title"
                                placeholder="The Lord of the Rings: The Fellowship of the Ring" />
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="release_date"
                                :label="__('content_items/edit.release_date') . ' **'"
                                type="date"
                                autocomplete="release_date"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="description" :label="__('content_items/edit.description')" id="description"
                                rows="4"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <flux:input wire:model="video_url" :label="__('content_items/edit.youtube_video_url')" id="video_url"
                                placeholder="https://youtu.be/xxxx or https://www.youtube.com/watch?v=xxxx"/>
                        </div>

                        <flux:label class="mt-4">{{ __('content_items/edit.duration') }}</flux:label>
                        <div class="flex flex-col lg:flex-row gap-4">
                            <div class="flex-1 max-w-3xs">
                                <flux:input wire:model="hours" :label="__('content_items/edit.hours')" type="number" min="0" />
                            </div>

                            <div class="flex-1 max-w-3xs">
                                <flux:input wire:model="minutes" :label="__('content_items/edit.minutes')" type="number" min="0" max="59" />
                            </div>

                            <div class="flex-1 max-w-3xs">
                                <flux:input wire:model="seconds" :label="__('content_items/edit.seconds')" type="number" min="0" max="59" />
                            </div>
                        </div>

                        <!-- People Selection Section -->
                        <div>
                            <flux:label class="mt-4">{{ __("content_items/edit.people_and_professions") }}</flux:label>
                            @foreach($professions as $profession)
                                @if($profession->people->isNotEmpty())
                                    <div>
                                        <div class="flex items-center my-6">
                                            <div class="flex-grow h-px bg-gradient-to-r from-transparent via-gray-400 to-transparent dark:via-gray-600"></div>

                                            <span class="px-4 text-sm font-semibold text-gray-800 dark:text-gray-100">
                                                {{ Str::plural($profession->name) }}
                                            </span>

                                            <div class="flex-grow h-px bg-gradient-to-r from-transparent via-gray-400 to-transparent dark:via-gray-600"></div>
                                        </div>

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
                                {{ __("content_items/edit.genres") }}
                            </label>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                @foreach($allGenres as $genre)
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox"
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
                            <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">{{ __("content_items/edit.visibility") }}</p>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox"
                                    wire:model="is_public"
                                    class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600">
                                <div class="grid grid-cols-1">
                                    <span class="text-gray-700 dark:text-white text-sm">{{ __("content_items/edit.make_public") }}</span>
                                    <span class="text-xs italic">({{ __("content_items/edit.other_users_view_leave_comments") }})</span>
                                </div>
                            </label>
                        </div>

                        <div class="mt-4">
                            {{-- Existing Image Preview --}}
                            @if($contentItem->main_image_url)
                            <div class="mt-2 mb-4">
                                <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">{{ __("content_items/edit.current_image") }}</p>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $contentItem->main_image_url }}" alt="Current image"
                                        class="h-24 w-24 object-cover rounded">
                                    <x-cinema-button type="button" :glow="true" palette="red" wire:click="confirmMainImageRemoval">
                                        {{ __("content_items/edit.remove_image_button") }}
                                    </x-cinema-button>
                                </div>
                            </div>
                            @endif

                            {{-- File Upload Input --}}
                            <flux:input :label="__('content_items/edit.image')" wire:model="new_main_image" type="file" id="new_main_image"
                                accept="image/*" />

                            {{-- Validation Error --}}
                            @error('new_main_image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            {{-- New Image Preview --}}
                            @if ($new_main_image)
                            <div class="mt-2">
                                <p class="text-sm text-gray-800 dark:text-white">{{ __("content_items/edit.preview") }}:</p>
                                <img src="{{ $new_main_image->temporaryUrl() }}" alt="{{ __('content_items/edit.preview') }}"
                                    class="mt-1 h-32 w-32 object-cover rounded">
                            </div>
                            @endif

                            @if ($contentItem->additionalImages->isNotEmpty())
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">{{ __("content_items/edit.additional_images") }}</p>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach ($contentItem->additionalImages as $image)
                                            <div class="relative">
                                                <img src="{{ Storage::url($image->path) }}" alt="{{ __('content_items/edit.additional_images') }}"
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
                                    <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">{{ __("content_items/edit.additional_image_previews") }}:</p>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach ($newAdditionalImages as $file)
                                            <div class="w-24 h-24">
                                                <img src="{{ $file->temporaryUrl() }}" alt="{{ __('content_items/edit.preview') }}"
                                                    class="w-full h-full object-cover rounded border border-gray-300">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-4">
                                <flux:input
                                    :label="__('content_items/edit.additional_images')"
                                    wire:model="newAdditionalImages"
                                    type="file"
                                    multiple />
                            </div>

                            {{-- Uploading indicator --}}
                            <div wire:loading wire:target="image" class="text-sm text-gray-600 mt-2">
                                {{ __("content_items/edit.uploading") }}...
                            </div>
                        </div>

                        <div class="my-12">
                            <hr class="h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                            <p class="mt-2 font-bold text-xs italic">* - {{ __("content_items/edit.required_fields") }}</p>
                            <p class="mt-2 font-bold text-xs italic">** - {{ __("content_items/edit.enter_full_date") }}</p>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <x-cinema-button type="submit" :glow="true" palette="gold" >
                                {{ __('content_items/edit.update_content_button') }}
                            </x-cinema-button>
                            <x-cinema-button :href="route('content-items.index')" :glow="true" palette="gray" wire:navigate>
                                {{ __("content_items/edit.cancel_button") }}
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
        <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">{{ __("content_items/edit.confirm_image_deletion") }}</h2>
        <p class="mb-6 text-gray-700 dark:text-gray-300">{{ __("content_items/edit.are_you_sure_main") }}</p>

        <div class="flex justify-end space-x-4">
            <x-cinema-button @click="showModal = false"
                type="button" :glow="true" palette="gray">
                {{ __("content_items/edit.cancel_button") }}
            </x-cinema-button>
            <x-cinema-button wire:click="removeMainImage"
                type="button" :glow="true" palette="red">
                {{ __("content_items/edit.delete_button") }}
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
        <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">{{ __("content_items/edit.confirm_image_deletion") }}</h2>
        <p class="mb-6 text-gray-700 dark:text-gray-300">{{ __("content_items/edit.are_you_sure_additional") }}</p>

        <div class="flex justify-end space-x-4">
            <x-cinema-button @click="showModal = false"
                type="button" :glow="true" palette="gray">
                {{ __("content_items/edit.cancel_button") }}
            </x-cinema-button>
            <x-cinema-button wire:click="deleteAdditionalImageConfirmed"
                type="button" :glow="true" palette="red">
                {{ __("content_items/edit.delete_button") }}
            </x-cinema-button>
        </div>
    </div>
</div>


</div>
