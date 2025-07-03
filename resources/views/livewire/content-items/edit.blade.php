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
                                    <option value="willwatch">Will Watch</option>
                                    <option value="watching">Watching</option>
                                    <option value="watched">Watched</option>
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

                        {{-- <div class="mt-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>

                            @if($existingImage)
                            <div class="mt-2 mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current image:</p>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ Storage::url($existingImage) }}" alt="Current image"
                                        class="h-24 w-24 object-cover rounded">
                                    <button type="button" wire:click="removeImage"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Remove Image
                                    </button>
                                </div>
                            </div>
                            @endif

                            <input wire:model="image" type="file" id="image" accept="image/*"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            @if ($image)
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">New image preview:</p>
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                    class="mt-1 h-32 w-32 object-cover rounded">
                            </div>
                            @endif

                            <div wire:loading wire:target="image" class="text-sm text-gray-600 mt-2">
                                Uploading...
                            </div>
                        </div> --}}

                        <div class="mt-4">
                            {{-- Existing Image Preview --}}
                            @if($existingImage)
                            <div class="mt-2 mb-4">
                                <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">Current image</p>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ Storage::url($existingImage) }}" alt="Current image"
                                        class="h-24 w-24 object-cover rounded">
                                    <button type="button" wire:click="removeImage"
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
</div>
