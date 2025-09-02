<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Articles') }}
            {{-- @if($contentItemFilter || $search)
                <flux:button
                    wire:click="clearFilters"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('Clear filters') }}
                </flux:button>
            @endif --}}
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
            <x-button href="{{ route('writer.articles.create') }}" class="order-1 sm:order-none" wire:navigate>{{ __('Add New Article') }}</x-button>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">

                    <x-flash-message />

                    <!-- Filters -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <flux:input
                                wire:model.live="search"
                                :label="__('Search')"
                                type="text"
                                :placeholder="__('Search article...')"
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
                    </div>

                    <!-- Articles Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($articles as $article)
                            <div class="bg-white dark:bg-zinc-800 dark:text-white rounded-lg shadow-md overflow-hidden">
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
                                                <span class="text-gray-500 dark:text-gray-700">No Image</span>
                                            </div>
                                        @endif
                                    @endif
                                </a>

                                <div class="p-4">
                                    <a href="{{ route('articles.show', $article) }}"  wire:navigate
                                        class="font-semibold text-lg text-gray-800 dark:text-white mb-2 hover:underline">
                                        {{ $article->title }}
                                    </a>

                                    @if ($article->birth_date)
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">Birth date:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $article->formatted_birth_date }}
                                        </span>
                                    </div>
                                    @endif

                                    @if ($article->birth_place)
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">Birth place:</span>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $article->birth_place }}" target="_blank"
                                            class="px-2 py-1 rounded text-xs font-bold
                                                bg-gray-900 text-white
                                                dark:bg-white dark:text-gray-900
                                                hover:bg-gray-700 dark:hover:bg-gray-200
                                                hover:shadow-lg hover:scale-105
                                                transition duration-300 ease-out transform">
                                            {{ $article->birth_place }}
                                        </a>
                                    </div>
                                    @endif

                                    @if ($article->death_date)
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">Death date:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $article->formatted_death_date }}
                                        </span>
                                    </div>
                                    @endif


                                    {{-- <div class="grid grid-cols-1 gap-y-2 mb-4 text-sm">
                                        <span class="font-semibold text-gray-700 dark:text-gray-300 col-span-full">{{ __("Known for") }}:</span>
                                        @forelse ($article->contentItems as $contentItem)
                                            <span
                                                class="px-2 py-1 rounded font-bold text-xs text-white bg-blue-500 dark:bg-blue-600
                                                    hover:bg-blue-600 dark:hover:bg-blue-700 transition-colors duration-200
                                                    text-center cursor-pointer select-none shadow-sm"
                                                    wire:click="$set('contentItemFilter', {{ $contentItem->id }})"
                                                >
                                                {{ $contentItem->title }}
                                            </span>
                                        @empty
                                            <span class="font-semibold italic text-xs dark:text-white">
                                                {{ __("No works") }}
                                            </span>
                                        @endforelse
                                    </div> --}}

{{--
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-3">
                                        <span class="font-medium">Status:</span>
                                        <span wire:click="$set('statusFilter', '{{ $article->status->value }}')" @class([
                                            'px-2 py-1 rounded text-xs font-bold hover:cursor-pointer',
                                            'bg-green-500 text-white'  => $article->status === \App\Enums\ContentStatus::Watched,
                                            'bg-blue-500 text-white'   => $article->status === \App\Enums\ContentStatus::Watching,
                                            'bg-purple-500 text-white' => $article->status === \App\Enums\ContentStatus::WillWatch,
                                            'bg-amber-500 text-black'  => $article->status === \App\Enums\ContentStatus::Waiting,
                                        ])>
                                            {{ \App\Enums\ContentStatus::labels()[$article->status->value] ?? ucfirst($article->status->value) }}
                                        </span>
                                    </div> --}}

                                    {{-- @if($article->biography)
                                        <p class="text-sm text-gray-600 dark:text-white mb-3">
                                            {{ Str::limit($article->biography, 100) }}
                                        </p>
                                    @endif --}}

                                    <div class="flex justify-between items-center">
                                        <flux:button href="{{ route('writer.articles.edit', $article) }}" wire:navigate>Edit</flux:button>
                                        <x-button wire:click="delete({{ $article->id }})"
                                                wire:confirm="Are you sure you want to delete this article? This action is irreversible."
                                                color="red" type="submit"
                                                >Delete</x-button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500 text-lg">No articles found.</p>
                                <flux:link :href="route('writer.articles.create')" wire:navigate>{{ __('Add First Article') }}</flux:link>
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
