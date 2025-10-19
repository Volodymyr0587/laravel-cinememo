<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('articles/main.articles') }}: {{ __('articles/main.manage_articles') }}
            @if($authorFilter || $search)
                <flux:button
                    wire:click.prevent="clearFilters"
                    class="ml-2 hover:cursor-pointer"
                    wire:key="articles-clear-filters-btn"
                >
                    {{ __('articles/main.clear_filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            @hasanyrole(['super_admin', 'admin'])
            <x-cinema-button href="{{ route('admin.articles.deleted') }}" :glow="true" palette="orange" wire:navigate>
                {{ __('articles/main.view_deleted_articles') }}
            </x-cinema-button>
            @endhasanyrole

            @hasanyrole(['super_admin', 'writer'])
            <x-cinema-button href="{{ route('writer.articles.create') }}" :glow="true" palette="gold" wire:navigate>
                {{ __('articles/main.add_new_article') }}
            </x-cinema-button>
            @endhasanyrole
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6">

                    <x-flash-message />

                    <!-- Filters -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <flux:input
                                wire:model.live="search"
                                :label="__('articles/main.search')"
                                type="text"
                                :placeholder="__('articles/main.search_placeholder')"
                            />
                        </div>
                        <div>
                            <flux:select wire:model.live="authorFilter" :label="__('articles/main.authors')">
                                <option value="">{{ __('articles/main.all_authors') }}</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                    </div>

                    <!-- Articles Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($articles as $article)
                            <div wire:key="article-{{ $article->id }}" class="glass-card">
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
                                                <span class="text-gray-500 dark:text-gray-700">{{ __('articles/main.no_image') }}</span>
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
                                        <span class="font-medium">{{ __("articles/main.written_by") }}:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $article->user->name }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm mt-2 mb-3">
                                        <span class="font-medium text-gray-600 dark:text-white">{{ __("articles/main.visibility") }}:</span>
                                        <span
                                        @class([
                                            'px-2 py-1 rounded text-xs font-bold hover:cursor-pointer',
                                            'bg-green-500 text-white'  => $article->is_published == true,
                                            'bg-gray-500 text-white'   => $article->is_published == false,
                                        ])>
                                            {{ $article->is_published ? __("articles/main.published") : __("articles/main.under_review") }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __("articles/main.created_at") }}:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $article->created_at }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __("articles/main.updated_at") }}:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $article->updated_at }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __("articles/main.published_at") }}:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $article->published_at ?? __("articles/main.not_yet") }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        @can('update', $article)
                                        <x-cinema-button href="{{ route('writer.articles.edit', $article) }}"
                                            wire:navigate
                                            palette="purple"
                                        >{{ __("articles/main.edit_button") }}</x-cinema-button>
                                        @endcan

                                        @can('delete', $article)
                                        <x-cinema-button wire:click="delete({{ $article->id }})"
                                            wire:confirm="{{ __('articles/main.delete_confirm_message') }}"
                                            palette="red"
                                        >{{ __("articles/main.delete_button") }}</x-cinema-button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500 text-lg">{{ __("articles/main.no_articles_found") }}</p>
                                <flux:link :href="route('writer.articles.create')" wire:navigate>{{ __('articles/main.add_first_article') }}</flux:link>
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
