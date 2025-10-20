<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('content_items/public-content.public_content') }}
            @if($publicContentTypeFilter || $search)
                <flux:button
                    wire:click.prevent="clearFilters"
                    wire:key="public-clear-filters-btn"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('content_items/public-content.clear_filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            <x-cinema-button href="{{ route('content-items.create') }}"
                class="order-1 sm:order-none"
                wire:navigate
                :glow="true"
                palette="gold"
            >
                {{ __('content_items/public-content.add_new_content') }}
            </x-cinema-button>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <!-- Filters -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <flux:input
                            wire:model.live="search"
                            :label="__('content_items/public-content.search')"
                            type="text"
                            :placeholder="__('content_items/public-content.search_placeholder')"
                        />
                    </div>
                    <div>
                        <flux:select
                            wire:model.live="publicContentTypeFilter"
                            :label="__('content_items/public-content.category')"
                        >
                            <option value="">{{ __('content_items/public-content.all_categories') }}</option>
                            @foreach($contentTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>

                <!-- Content Items Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($contentItems as $contentItem)
                        <div wire:key="public-content-item-{{ $contentItem->id }}" class="glass-card">
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
                                            <span class="text-gray-500 dark:text-gray-700">{{ __('content_items/public-content.no_image') }}</span>
                                        </div>
                                    @endif
                                @endif

                            </a>

                            <div class="p-4">
                                <a href="{{ route('content-items.show', [$contentItem, 'from' => request()->route()->getName()]) }}"  wire:navigate
                                    class="font-semibold text-lg text-gray-800 dark:text-white mb-2 hover:underline">
                                    {{ $contentItem->title }}
                                </a>

                                <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-2">
                                    <span class="font-medium">{{ __('content_items/public-content.category') }}:</span>
                                    <span wire:click="$set('publicContentTypeFilter', '{{ $contentItem->contentType->id }}')"
                                        class="px-2 py-1 rounded text-white font-bold hover:cursor-pointer"
                                        style="background-color: {{ $contentItem->contentType->color }}">
                                        {{ $contentItem->contentType->name }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-2">
                                    <span class="font-medium">{{ __('content_items/public-content.added_by') }}:</span>
                                    <span
                                        class="px-2 py-1 rounded font-bold"
                                        >
                                        {{ $contentItem->user->name }}
                                    </span>
                                </div>

                                @if($contentItem->description)
                                    <p class="text-sm text-gray-600 dark:text-white mb-3">
                                        {{ Str::limit($contentItem->description, 100) }}
                                    </p>
                                @endif

                                <livewire:likes.like-button
                                    :likeable="$contentItem"
                                    :key="'like-button-content-' . $contentItem->id"
                                />

                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500 text-lg">{{ __('content_items/public-content.no_content_found') }}</p>
                            <flux:link :href="route('content-items.create')" wire:navigate>{{ __('content_items/public-content.create_your_first_content') }}</flux:link>
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

