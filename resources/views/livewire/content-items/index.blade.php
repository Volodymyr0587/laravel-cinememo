<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('content_items/main.content_items') }}
            @if($statusFilter || $contentTypeFilter || $genreFilter || $search)
                <flux:button
                    wire:click.prevent="clearFilters"
                    wire:key="index-clear-filters-btn"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('content_items/main.clear_filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            <flux:button
                :href="route('content-items.export')" class="order-2 sm:order-none"
                icon:trailing="arrow-down-tray"
            >
                {{ __('content_items/main.export_to_xlsx') }}
            </flux:button>
            <flux:button
                :href="route('content-items.export-pdf')" class="order-3 sm:order-none"
                icon:trailing="arrow-down-tray"
                target="_blank"
            >
               {{ __('content_items/main.export_to_pdf') }}
            </flux:button>
            <x-cinema-button href="{{ route('content-items.create') }}"
                class="order-1 sm:order-none"
                wire:navigate
                :glow="true"
                palette="gold"
            >
                {{ __('content_items/main.add_new_content') }}
            </x-cinema-button>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6">

                    <x-flash-message />

                    <!-- Filters -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <flux:input
                                wire:model.live="search"
                                :label="__('content_items/main.search')"
                                type="text"
                                :placeholder="__('content_items/main.search_placeholder')"
                            />
                        </div>
                        <div>
                            <flux:select wire:model.live="genreFilter" :label="__('content_items/main.genre')">
                                <option value="">{{ __('content_items/main.all_genres') }}</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ __($genre->name) }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div>
                            <flux:select wire:model.live="statusFilter" :label="__('content_items/main.status')">
                                <option value="">{{ __('content_items/main.all_statuses') }}</option>
                                @foreach(\App\Enums\ContentStatus::labels() as $value => $label)
                                    <option value="{{ $value }}">{{ __($label) }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div>
                            <flux:select wire:model.live="contentTypeFilter" :label="__('content_items/main.category')">
                                <option value="">{{ __('content_items/main.all_categories') }}</option>
                                @foreach($contentTypes as $contentType)
                                    <option value="{{ $contentType->id }}">{{ $contentType->name }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                    </div>

                    <!-- Content Items Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($contentItems as $contentItem)
                            <div wire:key="content-item-{{ $contentItem->id }}" class="glass-card">
                                <a href="{{ route('content-items.show', [$contentItem, 'from' => request()->route()->getName()]) }}"  wire:navigate>
                                    @php
                                        $defaultImagePath = public_path('images/default-content.png');
                                    @endphp

                                    @if($contentItem->main_image_url)
                                        <img src="{{ $contentItem->main_image_url }}" alt="{{ $contentItem->title }}"
                                            class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                                    @else
                                        @if(\Illuminate\Support\Facades\File::exists($defaultImagePath))
                                            <img src="{{ asset('images/default-content.png') }}" alt="{{ $contentItem->title }}"
                                                class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 dark:bg-zinc-400 flex items-center justify-center">
                                                <span class="text-gray-500 dark:text-gray-700">{{ __('content_items/main.no_image') }}</span>
                                            </div>
                                        @endif
                                    @endif
                                </a>

                                <div class="p-4">
                                    @if ($contentItem->is_public)
                                        <span class="px-2 py-0.5 mr-1 rounded text-xs font-bold bg-indigo-400 text-red-600">
                                            {{ __('content_items/main.public') }}
                                        </span>
                                    @endif
                                    <a href="{{ route('content-items.show', [$contentItem, 'from' => request()->route()->getName()]) }}"  wire:navigate
                                        class="font-semibold text-lg text-gray-800 dark:text-white mb-2 hover:underline">
                                        {{ $contentItem->title }}
                                    </a>

                                    @if ($contentItem->release_date)
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mt-2 mb-3">
                                        <span class="font-medium">{{ __('content_items/main.release_date') }}:</span>
                                        <span class='px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900'>
                                            {{ $contentItem->release_date->translatedFormat('d F Y') }}
                                        </span>
                                    </div>
                                    @endif


                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-2">
                                        <span class="font-medium">{{ __('content_items/main.category') }}:</span>
                                        <span
                                            wire:click="$set('contentTypeFilter', '{{ $contentItem->contentType->id }}')"
                                            class="px-2 py-1 rounded text-white font-bold hover:cursor-pointer"
                                            style="background-color: {{ $contentItem->contentType->color }}">
                                            {{ $contentItem->contentType->name }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 mb-4 text-sm">
                                        <span class="font-semibold text-gray-700 dark:text-gray-300 col-span-full">{{ __('content_items/main.genres') }}:</span>
                                        @forelse ($contentItem->genres as $genre)
                                            <span
                                                class="px-2 py-1 rounded font-bold text-xs text-white bg-blue-500 dark:bg-blue-600
                                                    hover:bg-blue-600 dark:hover:bg-blue-700 transition-colors duration-200
                                                    text-center cursor-pointer select-none shadow-sm"
                                                    wire:click="$set('genreFilter', {{ $genre->id }})"
                                                >
                                                {{ $genre->name }}
                                            </span>
                                        @empty
                                            <span class="font-semibold italic text-xs dark:text-white">
                                                {{ __("content_items/main.no_genre") }}
                                            </span>
                                        @endforelse
                                    </div>


                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-3">
                                        <span class="font-medium">{{ __("content_items/main.status") }}:</span>
                                        <span wire:click="$set('statusFilter', '{{ $contentItem->status->value }}')" @class([
                                            'px-2 py-1 rounded text-xs font-bold hover:cursor-pointer',
                                            'bg-green-500 text-white'  => $contentItem->status === \App\Enums\ContentStatus::Watched,
                                            'bg-blue-500 text-white'   => $contentItem->status === \App\Enums\ContentStatus::Watching,
                                            'bg-purple-500 text-white' => $contentItem->status === \App\Enums\ContentStatus::WillWatch,
                                            'bg-amber-500 text-black'  => $contentItem->status === \App\Enums\ContentStatus::Waiting,
                                        ])>
                                            {{ \App\Enums\ContentStatus::labels()[$contentItem->status->value] ?? ucfirst($contentItem->status->value) }}
                                        </span>
                                    </div>

                                    @if($contentItem->description)
                                        <p class="text-sm text-gray-600 dark:text-white mb-3">
                                            {{ Str::limit($contentItem->description, 100) }}
                                        </p>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <x-cinema-button href="{{ route('content-items.edit', $contentItem) }}"
                                            wire:navigate
                                            palette="purple"
                                        >{{ __("content_items/main.edit_button") }}</x-cinema-button>
                                        <x-cinema-button wire:click="delete({{ $contentItem->id }})"
                                            wire:confirm="{{ __('content_items/main.delete_confirm_message') }}"
                                            palette="red"
                                        >{{ __("content_items/main.delete_button") }}</x-cinema-button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500 text-lg">{{ __("content_items/main.no_content_found") }}</p>
                                <flux:link :href="route('content-items.create')" wire:navigate>{{ __('content_items/main.create_your_first_content') }}</flux:link>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $contentItems->links('pagination.custom-tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
