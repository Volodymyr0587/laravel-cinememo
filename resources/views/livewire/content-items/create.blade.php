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
                                {{-- <label for="content_type_id" class="block text-sm font-medium text-gray-700">Content Type</label> --}}
                                <flux:select wire:model="content_type_id" id="content_type_id" :label="__('Content Type')">
                                    <option value="">Select a content type</option>
                                    @foreach($contentTypes as $contentType)
                                        <option value="{{ $contentType->id }}">{{ $contentType->name }}</option>
                                    @endforeach
                                </flux:select>
                                {{-- @error('content_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror --}}
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
                            <flux:input
                                wire:model="title"
                                :label="__('Title')"
                                type="text"
                                autocomplete="title"
                                placeholder="The Lord of the Rings: The Fellowship of the Ring"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="description" :label="__('Description')" id="description" rows="4"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                :label="__('Image')"
                                wire:model="image"
                                type="file"
                                id="image"
                                accept="image/*" />

                            @if ($image)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-800 dark:text-white">Preview:</p>
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="mt-1 h-32 w-32 object-cover rounded">
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
