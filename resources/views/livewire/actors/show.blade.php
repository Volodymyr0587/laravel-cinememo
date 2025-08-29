<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
            <div class="p-6">

                {{-- Back Button --}}
                <div class="mb-4">
                    <flux:link href="{{ route('actors.index') }}" wire:navigate>
                        ← {{ __('Back to all actors') }}
                    </flux:link>
                </div>

                {{-- Name --}}
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
                    {{ $actor->name }}
                </h2>

                @if ($actor->birth_date)
                <div class="flex items-center gap-x-2 text-sm text-gray-600 dark:text-white mt-2 mb-3">
                    <span class="font-medium">Birth date:</span>
                    <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                        {{ $actor->formatted_birth_date }}
                    </span>
                </div>
                @endif

                @if ($actor->birth_place)
                <div class="flex items-center gap-x-2 text-sm text-gray-600 dark:text-white mt-2 mb-3">
                    <span class="font-medium">Birth place:</span>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $actor->birth_place }}" target="_blank"
                        class="px-2 py-1 rounded text-xs font-bold
                            bg-gray-900 text-white
                            dark:bg-white dark:text-gray-900
                            hover:bg-gray-700 dark:hover:bg-gray-200
                            hover:shadow-lg hover:scale-105
                            transition duration-300 ease-out transform">
                        {{ $actor->birth_place }}
                    </a>
                </div>
                @endif

                @if ($actor->death_date)
                <div class="flex items-center gap-x-2 text-sm text-gray-600 dark:text-white mt-2 mb-3">
                    <span class="font-medium">Death date:</span>
                    <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                        {{ $actor->formatted_death_date }}
                    </span>
                </div>
                @endif

                {{-- Image --}}
                @php
                    $defaultImagePath = public_path('images/default-actor.png');
                @endphp

                @if($actor->main_image_url)
                    <div class="w-full max-h-96 flex items-center justify-center bg-gray-100 dark:bg-zinc-700 rounded mb-6 p-2">
                        <img src="{{ $actor->main_image_url }}" alt="{{ $actor->name }}"
                            class="object-contain max-h-96 max-w-full">
                    </div>
                @else
                    @if(\Illuminate\Support\Facades\File::exists($defaultImagePath))
                        <div class="w-full max-h-96 flex items-center justify-center bg-gray-100 dark:bg-zinc-700 rounded mb-6 p-2">
                            <img src="{{ asset('images/default-actor.png') }}" alt="{{ $actor->name }}"
                                class="object-contain max-h-96 max-w-full">
                        </div>
                    @else
                        <div class="w-full h-64 bg-gray-200 dark:bg-zinc-600 flex items-center justify-center rounded mb-6">
                            <span class="text-gray-500 dark:text-gray-300">No Image</span>
                        </div>
                    @endif
                @endif


                {{-- Meta Info --}}
                <div class="gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __("Known for") }}:</p>
                        <div class="flex flex-wrap gap-2 mt-0.5">
                            @forelse ($actor->contentItems as $contentItem)
                                <a x-data="{ hover: false }" href="{{ route('content-items.show', $contentItem) }}" wire:navigate
                                    class="inline-block text-sm font-medium text-cyan-400 hover:underline"
                                    >
                                    <span @mouseenter="hover = true" @mouseleave="hover = false"
                                        class="relative">
                                        {{ $contentItem->title }}
                                        <div x-show="hover"
                                            x-transition
                                            class="absolute z-50 top-full left-0 mt-2 w-32 h-32 bg-white dark:bg-zinc-800 shadow-lg rounded-lg overflow-hidden border">
                                            @if($contentItem->main_image_url)
                                            <img src="{{ $contentItem->main_image_url }}"
                                                alt="{{ $contentItem->title }}"
                                                class="w-full h-full object-cover">
                                            @else
                                            <img src="{{ asset('images/default-content.png') }}"
                                                alt="{{ $contentItem->title }}"
                                                class="w-full h-full object-cover"
                                            >
                                            @endif
                                        </div>
                                    </span>
                                </a>@if(!$loop->last) | @endif
                            @empty
                                <span class="font-semibold italic text-xs dark:text-white">
                                    {{ __("No works") }}
                                </span>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Biography --}}
                @if($actor->biography)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('Biography') }}</p>
                        <p class="text-base text-gray-800 dark:text-white">{{ $actor->biography }}</p>
                    </div>
                @endif

                {{-- Additional images Slider Modal --}}
               @if ($actor->additionalImages->isNotEmpty())
                <div
                    x-data="{
                        imageModal: false,
                        currentImageIndex: 0,
                        images: @js($actor->additional_image_urls),
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

                {{-- Action Buttons --}}
                @can('update', $actor)
                <div class="flex justify-between items-center mt-6">
                    <flux:button href="{{ route('actors.edit', $actor) }}" wire:navigate>
                        {{ __('Edit') }}
                    </flux:button>

                    <button type="submit" wire:click="delete"
                            wire:confirm="Are you sure you want to delete this actor? This action is irreversible."
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
