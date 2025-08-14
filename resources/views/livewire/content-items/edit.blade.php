<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Content Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <flux:select wire:model="content_type_id" id="content_type_id"
                                    :label="__('Content Type')">
                                    <option value="">Select a content type</option>
                                    @foreach($contentTypes as $contentType)
                                    <option value="{{ $contentType->id }}">{{ $contentType->name }}</option>
                                    @endforeach
                                </flux:select>
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
                            <flux:input wire:model="title" :label="__('Title')" type="text" autocomplete="title"
                                placeholder="The Lord of the Rings: The Fellowship of the Ring" />
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="description" :label="__('Description')" id="description"
                                rows="4"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <flux:field variant="inline">
                                <flux:checkbox wire:model="is_public" />

                                <flux:label>Make Public</flux:label>

                                <flux:error name="is_public" />
                            </flux:field>
                        </div>

                        <div class="mt-4">
                            {{-- Existing Image Preview --}}
                            @if($existingImage)
                            <div class="mt-2 mb-4">
                                <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">Current image</p>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ Storage::url($existingImage) }}" alt="Current image"
                                        class="h-24 w-24 object-cover rounded">
                                    <button type="button" wire:click="confirmMainImageRemoval"
                                        class="bg-red-500 hover:bg-red-700 hover:cursor-pointer text-white font-bold py-1 px-3 rounded text-sm">
                                        {{ __('Remove Image') }}
                                    </button>
                                </div>
                            </div>
                            @endif

                            {{-- File Upload Input --}}
                            <flux:input :label="__('Image')" wire:model="image" type="file" id="image"
                                accept="image/*" />

                            {{-- Validation Error --}}
                            @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            {{-- New Image Preview --}}
                            @if ($image)
                            <div class="mt-2">
                                <p class="text-sm text-gray-800 dark:text-white">Preview:</p>
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                    class="mt-1 h-32 w-32 object-cover rounded">
                            </div>
                            @endif

                            @if ($existingImages)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">Additional images</p>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach ($contentItem->additionalImages as $image)
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

                        <div class="mt-6 flex items-center justify-between">
                            <flux:button variant="primary" type="submit" class="hover:cursor-pointer">{{ __('Update Content Item') }}</flux:button>
                            <flux:link :href="route('content-items.index')" wire:navigate>{{ __('Cancel') }}</flux:link>
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
            <button wire:click="removeImage"
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
