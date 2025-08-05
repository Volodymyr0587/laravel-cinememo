<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
            <div class="p-6">

                {{-- Back Button --}}
                <div class="mb-4">
                    <flux:link :href="route('content-items.index')" wire:navigate>
                        ← {{ __('Back to list') }}
                    </flux:link>
                </div>

                {{-- Title --}}
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
                    {{ $contentItem->title }}
                </h2>

                {{-- Image --}}
                @if($contentItem->image_url)
                    <div class="w-full max-h-96 flex items-center justify-center bg-gray-100 dark:bg-zinc-700 rounded mb-6 p-2">
                        <img src="{{ $contentItem->image_url }}" alt="{{ $contentItem->title }}"
                            class="object-contain max-h-96 max-w-full">
                    </div>
                @else
                    <div class="w-full h-64 bg-gray-200 dark:bg-zinc-600 flex items-center justify-center rounded mb-6">
                        <span class="text-gray-500 dark:text-gray-300">No Image</span>
                    </div>
                @endif

                {{-- Meta Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('Content Type') }}</p>
                        <p class="text-base text-gray-800 dark:text-white font-medium">{{ $contentItem->contentType->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('Status') }}</p>
                        <span @class([
                            'inline-block px-2 py-1 rounded text-xs font-medium',
                            'bg-green-100 text-green-800' => $contentItem->status === \App\Enums\ContentStatus::Watched,
                            'bg-yellow-100 text-yellow-800' => $contentItem->status === \App\Enums\ContentStatus::Watching,
                            'bg-blue-100 text-blue-800' => $contentItem->status === \App\Enums\ContentStatus::WillWatch,
                        ])>
                            {{ \App\Enums\ContentStatus::labels()[$contentItem->status->value] ?? ucfirst($contentItem->status->value) }}
                        </span>
                    </div>
                </div>

                {{-- Description --}}
                @if($contentItem->description)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('Description') }}</p>
                        <p class="text-base text-gray-800 dark:text-white">{{ $contentItem->description }}</p>
                    </div>
                @endif

                @if ($contentItem->additionalImages->isNotEmpty())
                    <div
                        x-data="{ imageModal: false, imageSrc: '' }"
                        class="mt-4"
                    >
                        <p class="text-sm text-gray-700 dark:text-white font-semibold mb-2">Additional Images</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach ($contentItem->additionalImages as $img)
                                <div
                                    class="relative overflow-hidden rounded shadow hover:shadow-lg transition duration-200 cursor-pointer"
                                    @click="imageModal = true; imageSrc = '{{ Storage::url($img->path) }}'"
                                >
                                    <img
                                        src="{{ Storage::url($img->path) }}"
                                        alt="Additional Image"
                                        class="w-full h-40 object-cover hover:scale-105 transition-transform duration-200 rounded"
                                    >
                                </div>
                            @endforeach
                        </div>

                        <!-- Modal -->
                        <div
                            x-show="imageModal"
                            x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80 p-4"
                            @keydown.escape.window="imageModal = false"
                        >
                            <!-- Close Button (Pinned to screen corner) -->
                            <button
                                @click="imageModal = false"
                                class="fixed top-4 right-4 z-50 text-white bg-red-600 hover:bg-red-700 rounded-full w-12 h-12 text-3xl flex items-center justify-center shadow-lg focus:outline-none"
                                aria-label="Close"
                            >
                                &times;
                            </button>

                            <!-- Image container -->
                            <div class="max-w-full max-h-full overflow-auto">
                                <img
                                    :src="imageSrc"
                                    alt="Full Image"
                                    class="max-w-full max-h-screen object-contain rounded-lg shadow-lg"
                                >
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex justify-between items-center mt-6">
                    <flux:button href="{{ route('content-items.edit', $contentItem) }}" wire:navigate>
                        {{ __('Edit') }}
                    </flux:button>

                    <button type="submit" wire:click="delete({{ $contentItem->id }})"
                            wire:confirm="Are you sure you want to delete this content item?"
                            class="px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-800 text-sm font-medium">
                        {{ __('Delete') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

</script>
