<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Edit Actor or Actress') }} - {{ $actor->name }}
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
                                :label="__('Name') . ' *'"
                                type="text"
                                autocomplete="name"
                                placeholder="Leonardo DiCaprio"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:input
                                wire:model="birth_date"
                                :label="__('Birth date')"
                                type="date"
                                autocomplete="birth_date"
                                placeholder="Select a birth date"
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
                                :label="__('Death date')"
                                type="date"
                                autocomplete="death_date"
                                placeholder="Select a death date"
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
                            {{-- Existing Image Preview --}}
                            @if($actor->main_image_url)
                            <div class="mt-2 mb-4">
                                <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">Current image</p>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $actor->main_image_url }}" alt="Current image"
                                        class="h-24 w-24 object-cover rounded">
                                    <button type="button" wire:click="confirmMainImageRemoval"
                                        class="bg-red-500 hover:bg-red-700 hover:cursor-pointer text-white font-bold py-1 px-3 rounded text-sm">
                                        {{ __('Remove Image') }}
                                    </button>
                                </div>
                            </div>
                            @endif

                            {{-- File Upload Input --}}
                            <flux:input :label="__('Image')" wire:model="new_main_image" type="file" id="new_main_image"
                                accept="image/*" />

                            {{-- Validation Error --}}
                            @error('new_main_image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            {{-- New Image Preview --}}
                            @if ($new_main_image)
                            <div class="mt-2">
                                <p class="text-sm text-gray-800 dark:text-white">Preview:</p>
                                <img src="{{ $new_main_image->temporaryUrl() }}" alt="Preview"
                                    class="mt-1 h-32 w-32 object-cover rounded">
                            </div>
                            @endif

                            @if ($actor->additionalImages->isNotEmpty())
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">Additional images</p>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach ($actor->additionalImages as $image)
                                            <div class="relative">
                                                <img src="{{ Storage::url($image->path) }}" alt="Additional Image"
                                                    class="h-24 w-24 object-cover rounded border border-gray-300">
                                                <button type="button"
                                                        wire:click="confirmAdditionalImageRemoval({{ $image->id }})"
                                                        class="absolute top-1 right-1 bg-red-500 hover:bg-red-700 text-white rounded-full p-1 text-xs">
                                                    ✕
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Additional Images Preview --}}
                            @if ($newAdditionalImages)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">Additional Image Previews:</p>
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
                                    :label="__('Additional images')"
                                    wire:model="newAdditionalImages"
                                    type="file"
                                    multiple />
                            </div>

                            {{-- Uploading indicator --}}
                            <div wire:loading wire:target="image" class="text-sm text-gray-600 mt-2">
                                {{ __('Uploading...') }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="content_type_id" class="block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                                {{ __("Select actor-related content") }}
                            </label>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-3">
                                @forelse($contentItems as $contentItem)
                                    <label x-data="{ hover: false }" class="relative flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox"
                                            id="content_item_{{ $contentItem->id }}"
                                            wire:model="content_items"
                                            value="{{ $contentItem->id }}"
                                            class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600">

                                        <span @mouseenter="hover = true" @mouseleave="hover = false"
                                            class="text-gray-700 dark:text-white text-sm relative">
                                            {{ $contentItem->title }}
                                            <div x-show="hover"
                                                x-transition
                                                class="absolute z-50 top-full left-0 mt-2 w-32 h-44 bg-white dark:bg-zinc-800 shadow-lg rounded-lg overflow-hidden border hidden sm:block">
                                                @if($contentItem->main_image_url)
                                                    <img src="{{ $contentItem->main_image_url }}"
                                                        alt="{{ $contentItem->title }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <img src="{{ asset('images/default-content.png') }}"
                                                        alt="{{ $contentItem->title }}"
                                                        class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                        </span>
                                    </label>
                                @empty
                                    <span class="font-semibold italic text-xs dark:text-white">
                                        {{ __("There are no content items in your collection yet.") }}
                                    </span>
                                @endforelse
                            </div>
                            <div class="my-12">
                                <hr class="h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                                <p class="mt-2 font-bold text-xs italic">* - {{ __("Required fields") }}</p>
                            </div>

                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <flux:button variant="primary" type="submit" >{{ __('Update Actor') }}</flux:button>
                            <flux:link :href="route('actors.index')" wire:navigate>{{ __('Cancel') }}</flux:link>
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
        <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Confirm Deletion</h2>
        <p class="mb-6 text-gray-700 dark:text-gray-300">Are you sure you want to delete the main image? This action cannot be undone.</p>

        <div class="flex justify-end space-x-4">
            <button @click="showModal = false"
                    type="button"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300">
                Cancel
            </button>
            <button wire:click="removeMainImage"
                    type="button"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Delete
            </button>
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
        <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Confirm Deletion</h2>
        <p class="mb-6 text-gray-700 dark:text-gray-300">Are you sure you want to delete this image? This action cannot be undone.</p>

        <div class="flex justify-end space-x-4">
            <button @click="showModal = false"
                    type="button"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300">
                Cancel
            </button>
            <button wire:click="deleteAdditionalImageConfirmed"
                    type="button"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Delete
            </button>
        </div>
    </div>
</div>
</div>

