<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
            <div class="p-6">

                {{-- Back Button --}}
                <div class="mb-4">
                    @php
                        $from = request()->query('from');
                    @endphp

                    @if ($from === 'public-content.index')
                        <flux:link href="{{ route('public-content.index') }}" wire:navigate>
                            ← {{ __('Back to public content') }}
                        </flux:link>
                    @else
                        <flux:link href="{{ route('content-items.index') }}" wire:navigate>
                            ← {{ __('Back to collection') }}
                        </flux:link>
                    @endif
                </div>

                {{-- Title --}}
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
                    {{ $contentItem->title }}
                </h2>

                @if ($contentItem->release_date)
                <div class="flex items-center gap-x-2 text-sm text-gray-600 dark:text-white mt-2 mb-3">
                    <span class="font-medium">Release date:</span>
                    <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                        {{ Carbon\Carbon::parse($contentItem->release_date)->format('Y-M-d') }}
                    </span>
                </div>
                @endif

                {{-- Image --}}
                @php
                    $defaultImagePath = public_path('images/default-content.png');
                @endphp

                @if($contentItem->main_image_url)
                    <div class="w-full max-h-96 flex items-center justify-center bg-gray-100 dark:bg-zinc-700 rounded mb-6 p-2">
                        <img src="{{ $contentItem->main_image_url }}" alt="{{ $contentItem->title }}"
                            class="object-contain max-h-96 max-w-full">
                    </div>
                @else
                    @if(\Illuminate\Support\Facades\File::exists($defaultImagePath))
                        <div class="w-full max-h-96 flex items-center justify-center bg-gray-100 dark:bg-zinc-700 rounded mb-6 p-2">
                            <img src="{{ asset('images/default-content.png') }}" alt="{{ $contentItem->title }}"
                                class="object-contain max-h-96 max-w-full">
                        </div>
                    @else
                        <div class="w-full h-64 bg-gray-200 dark:bg-zinc-600 flex items-center justify-center rounded mb-6">
                            <span class="text-gray-500 dark:text-gray-300">No Image</span>
                        </div>
                    @endif
                @endif


                {{-- Meta Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('Category') }}</p>
                        <span class="inline-block px-2 py-1 rounded text-xs font-medium"
                            style="background-color: {{ $contentItem->contentType->color }}">
                            {{ $contentItem->contentType->name }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('Status') }}</p>
                        <span @class([
                            'inline-block px-2 py-1 rounded text-xs font-medium',
                            'bg-green-500 text-white'  => $contentItem->status === \App\Enums\ContentStatus::Watched,
                            'bg-blue-500 text-white'   => $contentItem->status === \App\Enums\ContentStatus::Watching,
                            'bg-purple-500 text-white' => $contentItem->status === \App\Enums\ContentStatus::WillWatch,
                            'bg-amber-500 text-black'  => $contentItem->status === \App\Enums\ContentStatus::Waiting,
                        ])>
                            {{ \App\Enums\ContentStatus::labels()[$contentItem->status->value] ?? ucfirst($contentItem->status->value) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('Genres') }}</p>
                        <div class="flex flex-wrap gap-2 mt-0.5">
                            @forelse ($contentItem->genres as $genre)
                                <span
                                    class="px-2 py-1 rounded font-medium text-xs text-white bg-blue-500 dark:bg-blue-600
                                        transition-colors duration-200 text-center shadow-sm"
                                    >
                                    {{ $genre->name }}
                                </span>
                            @empty
                                <span class="font-semibold italic text-xs dark:text-white">
                                    {{ __("No genre") }}
                                </span>
                            @endforelse
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('Actors') }}</p>
                        @forelse ($contentItem->actors as $actor)

                            @can('viewActors', $contentItem)
                                {{-- Show link --}}
                                <a x-data="{ hover: false }" href="{{ route('actors.show', $actor) }}" wire:navigate
                                    class="inline-block text-sm font-medium text-cyan-400 hover:underline"
                                    >
                                    <span @mouseenter="hover = true" @mouseleave="hover = false"
                                        class="relative">
                                        {{ $actor->name }}
                                        <div x-show="hover"
                                            x-transition
                                            class="absolute z-50 top-full left-0 mt-2 w-32 h-32 bg-white dark:bg-zinc-800 shadow-lg rounded-lg overflow-hidden border">
                                            @if($actor->main_image_url)
                                            <img src="{{ $actor->main_image_url }}"
                                                alt="{{ $actor->name }}"
                                                class="w-full h-full object-cover">
                                            @else
                                            <img src="{{ asset('images/default-actor.png') }}"
                                                alt="{{ $actor->name }}"
                                                class="w-full h-full object-cover"
                                            >
                                            @endif
                                        </div>
                                    </span>
                                </a>
                            @else
                                {{-- Plain text if public --}}
                                <span class="inline-block text-sm font-medium text-gray-500 dark:text-gray-400">
                                    {{ $actor->name }}
                                </span>
                            @endcan

                            @if(!$loop->last) | @endif
                        @empty
                            <span class="font-semibold italic text-xs dark:text-white">
                                {{ __("No actors") }}
                            </span>
                        @endforelse
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('Added by') }}</p>
                        <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-cyan-400 text-white">
                            {{ $contentItem->user->name }}
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

                {{-- Additional images Slider Modal --}}
               @if ($contentItem->additionalImages->isNotEmpty())
                <div
                    x-data="{
                        imageModal: false,
                        currentImageIndex: 0,
                        images: @js($contentItem->additional_image_urls),
                        open(index) {
                            this.currentImageIndex = index;
                            this.imageModal = true;
                        },
                        next() {
                            this.currentImageIndex = (this.currentImageIndex + 1) % this.images.length;
                        },
                        prev() {
                            this.currentImageIndex = (this.currentImageIndex - 1 + this.images.length) % this.images.length;
                        }
                    }"
                    @keydown.escape.window="imageModal = false"
                    @keydown.arrow-right.window="next()"
                    @keydown.arrow-left.window="prev()"
                    class="my-4"
                >
                    <p class="text-sm text-gray-700 dark:text-white font-semibold mb-2">Additional Images</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <template x-for="(img, index) in images" :key="index">
                            <div
                                class="relative overflow-hidden rounded shadow hover:shadow-lg transition duration-200 cursor-pointer"
                                @click="open(index)"
                            >
                                <img
                                    :src="img"
                                    alt="Additional Image"
                                    class="w-full h-40 object-cover hover:scale-105 transition-transform duration-200 rounded"
                                >
                            </div>
                        </template>
                    </div>

                    <!-- Modal -->
                    <div
                        x-show="imageModal"
                        style="display: none"
                        x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80 p-4"
                    >
                        <!-- Close Button -->
                        <button
                            @click="imageModal = false"
                            class="fixed top-4 right-4 z-50 text-white bg-red-600 hover:bg-red-700 hover:cursor-pointer rounded-full w-12 h-12 text-3xl flex items-center justify-center shadow-lg focus:outline-none"
                            aria-label="Close"
                        >
                            &times;
                        </button>

                        <!-- Navigation Arrows -->
                        <button
                            @click="prev"
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-4xl font-bold px-2 py-1 z-40 hover:text-gray-300 hover:cursor-pointer"
                            aria-label="Previous"
                        >
                            &#10094;
                        </button>
                        <button
                            @click="next"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-4xl font-bold px-2 py-1 z-40 hover:text-gray-300 hover:cursor-pointer"
                            aria-label="Next"
                        >
                            &#10095;
                        </button>

                        <!-- Image Display -->
                        <div class="max-w-full max-h-full overflow-auto">
                            <img
                                :src="images[currentImageIndex]"
                                alt="Full Image"
                                class="max-w-full max-h-screen object-contain rounded-lg shadow-lg"
                            >
                        </div>
                    </div>
                </div>
                @endif
                {{-- End of Additional images Slider Modal --}}

                @if ($contentItem->is_public)
                    <livewire:content-items.comments-section :contentItem="$contentItem" />
                @endif

                {{-- Action Buttons --}}
                @can('update', $contentItem)
                <div class="flex justify-between items-center mt-6">
                    <flux:button href="{{ route('content-items.edit', $contentItem) }}" wire:navigate>
                        {{ __('Edit') }}
                    </flux:button>

                    <button type="submit" wire:click="delete({{ $contentItem->id }})"
                            wire:confirm="Are you sure you want to delete this content item?"
                            class="px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-800 text-sm font-medium hover:cursor-pointer">
                        {{ __('Delete') }}
                    </button>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>

<script>

</script>
