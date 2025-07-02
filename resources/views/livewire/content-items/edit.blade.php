<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Content Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form wire:submit="save" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="content_type_id" class="block text-sm font-medium text-gray-700">Content Type</label>
                                <select wire:model="content_type_id" id="content_type_id"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select a content type</option>
                                    @foreach($contentTypes as $contentType)
                                        <option value="{{ $contentType->id }}">{{ $contentType->name }}</option>
                                    @endforeach
                                </select>
                                @error('content_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select wire:model="status" id="status"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="willwatch">Will Watch</option>
                                    <option value="watching">Watching</option>
                                    <option value="watched">Watched</option>
                                </select>
                                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input wire:model="title" type="text" id="title"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model="description" id="description" rows="4"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>

                            @if($existingImage)
                                <div class="mt-2 mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Current image:</p>
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ Storage::url($existingImage) }}" alt="Current image" class="h-24 w-24 object-cover rounded">
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
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="mt-1 h-32 w-32 object-cover rounded">
                                </div>
                            @endif

                            <div wire:loading wire:target="image" class="text-sm text-gray-600 mt-2">
                                Uploading...
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Content Item
                            </button>
                            <a href="{{ route('content-items.index') }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
