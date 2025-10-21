<div>

    <div class="mt-2 flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
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
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>

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
                        <div wire:key="published-article-{{ $article->id }}" class="glass-card">
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
