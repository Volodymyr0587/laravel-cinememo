<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
            <div class="p-6">

                {{-- Back Button --}}
                <div class="mb-4">
                    <flux:link href="{{ route('articles.index') }}" wire:navigate>
                        ← {{ __('Back to all articles') }}
                    </flux:link>
                </div>

                <!-- Blog Article -->
<div class="max-w-3xl px-4 pt-6 lg:pt-10 pb-12 sm:px-6 lg:px-8 mx-auto">
    <div class="max-w-2xl">
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
                        <div>
                            <ul class="text-xs text-gray-500 dark:text-neutral-500">
                                <li
                                    class="inline-block relative pe-6 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-2 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full dark:text-neutral-400 dark:before:bg-neutral-600">
                                    {{ $article->published_at ? $article->published_at->format('Y-M-d H:m:i') : 'under review' }}
                                </li>
                                <li
                                    class="inline-block relative pe-6 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-2 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full dark:text-neutral-400 dark:before:bg-neutral-600">
                                    8 min read
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

                <p class="text-lg text-gray-800 dark:text-neutral-200">{{ $article->introduction }}</p>
            </div>

            <figure>
                @php
                    $defaultImagePath = public_path('images/default-article.png');
                @endphp

                @if($article->main_image_url)
                    <img src="{{ $article->main_image_url }}" alt="{{ $article->title }}"
                        class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                @else
                    @if(\Illuminate\Support\Facades\File::exists($defaultImagePath))
                        <img src="{{ asset('images/default-article.png') }}" alt="{{ $article->title }}"
                            class="w-full object-cover rounded-xl transition duration-300 ease-in-out hover:scale-110">
                    @else
                        <div class="w-full h-48 bg-gray-200 dark:bg-zinc-400 flex items-center justify-center">
                            <span class="text-gray-500 dark:text-gray-700">No Image</span>
                        </div>
                    @endif
                @endif
                <figcaption class="mt-3 text-sm text-center text-gray-500 dark:text-neutral-500">
                    {{ $article->title }}
                </figcaption>
            </figure>

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


            @if ($article->conclusion)
                <div class="space-y-3">
                <h3 class="text-2xl font-semibold dark:text-white">{{ __("Conclusion") }}</h3>

                <p class="text-lg text-gray-800 dark:text-neutral-200">{{ $article->conclusion }}</p>
            </div>
            @endif



            <div>
                <a class="m-1 inline-flex items-center gap-1.5 py-2 px-3 rounded-full text-sm bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                    href="#">
                    Plan
                </a>
                <a class="m-1 inline-flex items-center gap-1.5 py-2 px-3 rounded-full text-sm bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                    href="#">
                    Web development
                </a>
                <a class="m-1 inline-flex items-center gap-1.5 py-2 px-3 rounded-full text-sm bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                    href="#">
                    Free
                </a>
                <a class="m-1 inline-flex items-center gap-1.5 py-2 px-3 rounded-full text-sm bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 dark:bg-neutral-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                    href="#">
                    Team
                </a>
            </div>
        </div>
        <!-- End Content -->
    </div>
</div>
<!-- End Blog Article -->

<!-- Sticky Share Group -->
<div class="sticky bottom-6 inset-x-0 text-center">
    <div class="inline-block bg-white shadow-md rounded-full py-3 px-4 dark:bg-neutral-800">
        <div class="flex items-center gap-x-1.5">
            <!-- Button -->
            <div class="hs-tooltip inline-block">
                <button type="button"
                    class="hs-tooltip-toggle flex items-center gap-x-2 text-sm text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                    </svg>
                    875
                    <span
                        class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-black"
                        role="tooltip">
                        Like
                    </span>
                </button>
            </div>
            <!-- Button -->

            <div class="block h-3 border-e border-gray-300 mx-3 dark:border-neutral-600"></div>

            <!-- Button -->
            <div class="hs-tooltip inline-block">
                <button type="button"
                    class="hs-tooltip-toggle flex items-center gap-x-2 text-sm text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z" />
                    </svg>
                    16
                    <span
                        class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-black"
                        role="tooltip">
                        Comment
                    </span>
                </button>
            </div>
            <!-- Button -->

            <div class="block h-3 border-e border-gray-300 mx-3 dark:border-neutral-600"></div>

            <!-- Button -->
            <div class="hs-dropdown relative inline-flex">
                <button id="hs-blog-article-share-dropdown" type="button"
                    class="flex items-center gap-x-2 text-sm text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                        <polyline points="16 6 12 2 8 6" />
                        <line x1="12" x2="12" y1="2" y2="15" />
                    </svg>
                    Share
                </button>
                <div class="hs-dropdown-menu w-56 transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden mb-1 z-10 bg-gray-900 shadow-md rounded-xl p-2 dark:bg-neutral-950"
                    role="menu" aria-orientation="vertical" aria-labelledby="hs-blog-article-share-dropdown">
                    <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-400 hover:bg-white/10 focus:outline-hidden focus:bg-white/10 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:focus:bg-neutral-900"
                        href="#">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                        </svg>
                        Copy link
                    </a>
                    <div class="border-t border-gray-600 my-2 dark:border-neutral-800"></div>
                    <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-400 hover:bg-white/10 focus:outline-hidden focus:bg-white/10 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:focus:bg-neutral-900"
                        href="#">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                        </svg>
                        Share on Twitter
                    </a>
                    <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-400 hover:bg-white/10 focus:outline-hidden focus:bg-white/10 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:focus:bg-neutral-900"
                        href="#">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                        </svg>
                        Share on Facebook
                    </a>
                    <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-400 hover:bg-white/10 focus:outline-hidden focus:bg-white/10 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:focus:bg-neutral-900"
                        href="#">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z" />
                        </svg>
                        Share on LinkedIn
                    </a>
                </div>
            </div>
            <!-- Button -->
        </div>
    </div>
</div>
<!-- End Sticky Share Group -->

            </div>
        </div>
    </div>
</div>


