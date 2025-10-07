<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Edit Article') }} - {{ $article->title }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save" enctype="multipart/form-data">

                        <div class="mt-4">
                            <flux:input
                                wire:model="title"
                                :label="__('Title') . ' *'"
                                type="text"
                                autocomplete="title"
                                placeholder="Leonardo DiCaprio admits deep regret over passing on major Hollywood movie"
                            />
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="introduction" :label="__('Introduction') . ' *'" id="introduction" rows="10"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="main" :label="__('Main') . ' *'" id="main" rows="10"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="conclusion" :label="__('Conclusion')" id="conclusion" rows="10"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                id="tags"
                                wire:model="tags"
                                :label="__('Tags (comma separated)')"
                                type="text"
                                placeholder="e.g. drama, comedy, thriller, tv news, awards, casting, etc."
                            />
                        </div>

                        @hasanyrole(['super_admin', 'admin'])
                            <div class="mt-4">
                                <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">{{ __("Publish article") }}</p>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox"
                                        wire:model="is_published"
                                        class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600">
                                    <div class="grid grid-cols-1">
                                        <span class="text-gray-700 dark:text-white text-sm">{{ __("Make Public") }}</span>
                                        <span class="text-xs italic">(Other users will be able to view this content and leave comments)</span>
                                    </div>
                                </label>
                            </div>
                        @endhasanyrole

                        <div class="mt-4">
                            {{-- Existing Image Preview --}}
                            @if($article->main_image_url)
                            <div class="mt-2 mb-4">
                                <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">Current image</p>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $article->main_image_url }}" alt="Current image"
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

                            @if ($article->additionalImages->isNotEmpty())
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 dark:text-white font-bold mb-2">Additional images</p>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach ($article->additionalImages as $image)
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
                            <div class="my-12">
                                <hr class="h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                                <p class="mt-2 font-bold text-xs italic">* - {{ __("Required fields") }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <flux:button variant="primary" type="submit" >{{ __('Update Article') }}</flux:button>
                            <flux:link :href="route('writer.articles.index')" wire:navigate>{{ __('Cancel') }}</flux:link>
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

