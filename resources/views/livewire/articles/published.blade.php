<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('articles/published.articles') }}
            @if($publishedAuthorFilter || $search || $publishedTagFilter)
                <flux:button
                    wire:click.prevent="clearFilters"
                    wire:key="published-articles-clear-filters-btn"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('articles/published.clear_filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            {{-- <flux:button
                :href="route('content-items.export')" class="order-2 sm:order-none"
                icon:trailing="arrow-down-tray"
            >
                {{ __('Export to XLSX') }}
            </flux:button>
            <flux:button
                :href="route('content-items.export-pdf')" class="order-3 sm:order-none"
                icon:trailing="arrow-down-tray"
                target="_blank"
            >
               {{ __('Export to PDF') }}
            </flux:button> --}}
            {{-- @hasanyrole(['super_admin', 'writer'])
            <x-button href="{{ route('writer.articles.create') }}" class="order-1 sm:order-none" wire:navigate>{{ __('Add New Article') }}</x-button>
            @endhasanyrole --}}
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">

                    <x-flash-message />

                    <!-- Filters -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <flux:input
                                wire:model.live="search"
                                :label="__('articles/published.search')"
                                type="text"
                                :placeholder="__('articles/published.search_placeholder')"
                            />
                        </div>
                        {{-- <div>
                            <flux:select wire:model.live="genreFilter" :label="__('Genre')">
                                <option value="">All Genres</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ __($genre->name) }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div>
                            <flux:select wire:model.live="statusFilter" :label="__('Status')">
                                <option value="">All Statuses</option>
                                @foreach(\App\Enums\ContentStatus::labels() as $value => $label)
                                    <option value="{{ $value }}">{{ __($label) }}</option>
                                @endforeach
                            </flux:select>
                        </div> --}}
                        {{-- <div>
                            <flux:select wire:model.live="contentItemFilter" :label="__('Content')">
                                <option value="">All Content</option>
                                @foreach($contentItems as $contentItem)
                                    <option value="{{ $contentItem->id }}">{{ $contentItem->title }}</option>
                                @endforeach
                            </flux:select>
                        </div> --}}
                        <div>
                            <flux:select wire:model.live="publishedAuthorFilter" :label="__('articles/published.authors')">
                                <option value="">{{ __('articles/published.all_authors') }}</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div>
                            <flux:select wire:model.live="publishedTagFilter" :label="__('articles/published.tags')">
                                <option value="">{{ __('articles/published.all_tags') }}</option>
                               @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ ucfirst($tag->name) }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                    </div>

                    <!-- Articles Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($articles as $article)
                            <div wire:key="published-article-{{ $article->id }}" class="bg-white dark:bg-zinc-800 dark:text-white rounded-lg shadow-md overflow-hidden">
                                <a href="{{ route('articles.show', $article) }}"  wire:navigate>
                                    @php
                                        $defaultImagePath = public_path('images/default-article.png');
                                    @endphp

                                    @if($article->main_image_url)
                                        <img src="{{ $article->main_image_url }}" alt="{{ $article->title }}"
                                            class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                                    @else
                                        @if(\Illuminate\Support\Facades\File::exists($defaultImagePath))
                                            <img src="{{ asset('images/default-article.png') }}" alt="{{ $article->title }}"
                                                class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 dark:bg-zinc-400 flex items-center justify-center">
                                                <span class="text-gray-500 dark:text-gray-700">{{ __('articles/published.no_image') }}</span>
                                            </div>
                                        @endif
                                    @endif
                                </a>

                                <div class="p-4">
                                    <a href="{{ route('articles.show', $article) }}"  wire:navigate
                                        class="font-semibold text-lg text-gray-800 dark:text-white mb-2 hover:underline">
                                        {{ $article->title }}
                                    </a>


                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __("articles/published.written_by") }}:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $article->user->name }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __("articles/published.publication_date") }}:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $article->updated_at->format('Y-M-d') }}
                                        </span>
                                    </div>

                                    <livewire:likes.like-button
                                        :likeable="$article"
                                        :key="'like-button-content-' . $article->id"
                                    />

                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500 text-lg">{{ __("articles/published.no_articles_found") }}.</p>
                                @hasanyrole(['super_admin', 'writer'])
                                    <flux:link :href="route('writer.articles.create')" wire:navigate>{{ __('articles/published.add_first_article') }}</flux:link>
                                @endhasanyrole
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $articles->links('pagination.custom-tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
