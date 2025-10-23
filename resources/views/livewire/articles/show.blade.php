<div class="pb-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-4">
                <flux:link href="{{ route('articles.index') }}" wire:navigate>
                    ← {{ __('articles/show.back_to_all') }}
                </flux:link>
            </div>

                <!-- Blog Article -->
            <div class="">
                <div class="">
                    <!-- Avatar Media -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex w-full sm:items-center gap-x-5 sm:gap-x-3">
                            <div>
                                @if ($article->user->profile_image)
                                    <flux:avatar
                                        name="{{ $article->user->name }}"
                                        src="{{ Storage::url($article->user->profile_image) }}"
                                    />
                                @else
                                    <flux:avatar name="{{ $article->user->name }}" />
                                @endif
                            </div>

                            <div class="grow">
                                <div class="flex justify-between items-center gap-x-2">
                                    <div class="flex flex-col">
                                        <div class="mb-1 text-gray-500 dark:text-neutral-400">{{ $article->user->name }}</div>
                                        <ul class="text-xs text-gray-500 dark:text-neutral-500">
                                            <li
                                                class="inline-block relative pe-6 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-2 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full dark:text-neutral-400 dark:before:bg-neutral-600">
                                                {{ $article->published_at ? $article->published_at->format('Y-M-d H:m:i') : __("articles/show.under_review") }}
                                            </li>
                                            <li
                                                class="inline-block relative pe-6 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-2 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full dark:text-neutral-400 dark:before:bg-neutral-600">
                                                {{ trans_choice("articles/show.minute", $article->reading_time, ['count' => $article->reading_time]) }} {{ __("articles/show.to_read") }}
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Button Group -->
                                    <div>
                                        <button type="button"
                                            class="py-1.5 px-2.5 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                            </svg>
                                            Tweet
                                        </button>
                                    </div>
                                    <!-- End Button Group -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Avatar Media -->

                    <!-- Content -->
                    <div class="space-y-5 md:space-y-8">
                        <div class="space-y-3">
                            <h2 class="text-2xl font-bold md:text-3xl dark:text-white">{{ $article->title }}</h2>

                            <div>
                                @forelse ($article->tags as $tag)
                                    @php
                                        $colors = collect(['#1E09FF', '#9A09FF', '#7D27F5', '#BD2119', '#11118F', '#CC1BB0', '#6B59C7', '#49042F', '#042E49', '#2F4904']);
                                        $color = $colors->random();
                                    @endphp
                                    <span class="m-1 inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-bold text-white" style="background-color: {{ $color }}"
                                        href="#">
                                        {{ ucfirst($tag->name) }}
                                    </span>
                                @empty
                                    <span class="text-sm">{{ __("articles/show.no_tags") }}</span>
                                @endforelse
                            </div>

                            <p class="text-lg text-gray-800 dark:text-neutral-200">{{ $article->introduction }}</p>
                        </div>

                        <div class="w-full max-h-96 flex items-center justify-center rounded mb-6 p-2">
                            @php
                                $defaultImagePath = public_path('images/default-article.png');
                            @endphp

                            @if($article->main_image_url)
                                <img src="{{ $article->main_image_url }}" alt="{{ $article->title }}"
                                    class="h-auto max-w-full">
                            @else
                                @if(\Illuminate\Support\Facades\File::exists($defaultImagePath))
                                    <img src="{{ asset('images/default-article.png') }}" alt="{{ $article->title }}"
                                        class="w-full object-cover rounded-xl">
                                @else
                                    <div class="w-full h-48 glass-card flex items-center justify-center">
                                        <span class="text-gray-500 dark:text-gray-300">{{ __("articles/show.no_image") }}</span>
                                    </div>
                                @endif
                            @endif

                        </div>
                        <div class="mt-3 text-sm text-center text-gray-500 dark:text-neutral-500">
                            {{ $article->title }}
                        </div>

                        <p class="text-lg text-gray-800 dark:text-neutral-200">{{ $article->main }}</p>

                        {{-- Additional images Slider Modal --}}
                        @if ($article->additionalImages->isNotEmpty())
                            <div
                                x-data="{
                                    imageModal: false,
                                    currentImageIndex: 0,
                                    images: @js($article->additional_image_urls),
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
                                <p class="text-sm text-gray-700 dark:text-white font-semibold mb-2">{{ __("articles/show.additional_images") }}</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                    <template x-for="(img, index) in images" :key="index">
                                        <div
                                            class="relative overflow-hidden rounded shadow hover:shadow-lg transition duration-200 cursor-pointer"
                                            @click="open(index)"
                                        >
                                            <img
                                                :src="img"
                                                alt="{{ __("articles/show.additional_images") }}"
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


                        @if ($article->conclusion)
                            <div class="space-y-3">
                            <h3 class="text-2xl font-semibold dark:text-white">{{ __("articles/show.conclusion") }}</h3>

                            <p class="text-lg text-gray-800 dark:text-neutral-200">{{ $article->conclusion }}</p>
                        </div>
                        @endif
                    </div>
                    <!-- End Content -->
                </div>
            </div>
            <!-- End Blog Article -->

            <!-- Like button -->
            <div class="mt-4 bottom-6 inset-x-0 text-center">
                <!-- Like Button -->
                <div class="inline-block">
                    <livewire:likes.like-button
                        :likeable="$article"
                        :key="'like-button-content-' . $article->id"
                    />
                </div>
                <!-- End Like Button -->
            </div>
            <!-- End Like button -->
            @if ($article->is_published)
                <livewire:comments.comments-section :commentable="$article" />
            @endif
    </div>
</div>


