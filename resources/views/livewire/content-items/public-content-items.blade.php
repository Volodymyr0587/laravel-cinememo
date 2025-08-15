<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Public Content Items') }}
            @if($contentTypeFilter || $search)
                <flux:button
                    wire:click="clearFilters"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('Clear filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            <x-button href="{{ route('content-items.create') }}" class="order-1 sm:order-none" wire:navigate>{{ __('Add New Content Item') }}</x-button>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">

                    <!-- Filters -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <flux:input
                                wire:model.live="search"
                                :label="__('Search')"
                                type="text"
                                :placeholder="__('Search content items...')"
                            />
                        </div>
                        <div>
                            <flux:select
                                wire:model.live="contentTypeFilter"
                                :label="__('Content Type')"
                            >
                                <option value="">{{ __('All Types') }}</option>
                                @foreach($contentTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                    </div>

                    <!-- Content Items Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($contentItems as $contentItem)
                            <div class="bg-white dark:bg-zinc-800 dark:text-white rounded-lg shadow-md overflow-hidden">
                                <a href="{{ route('content-items.show', $contentItem) }}"  wire:navigate>
                                    @php
                                        $defaultImagePath = public_path('images/default-content.png');
                                    @endphp

                                    @if($contentItem->image_url)
                                        <img src="{{ $contentItem->image_url }}" alt="{{ $contentItem->title }}"
                                            class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                                    @else
                                        @if(\Illuminate\Support\Facades\File::exists($defaultImagePath))
                                            <img src="{{ asset('images/default-content.png') }}" alt="{{ $contentItem->title }}"
                                                class="h-auto max-w-full transition duration-300 ease-in-out hover:scale-110">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 dark:bg-zinc-400 flex items-center justify-center">
                                                <span class="text-gray-500 dark:text-gray-700">No Image</span>
                                            </div>
                                        @endif
                                    @endif

                                </a>

                                <div class="p-4">
                                    <a href="{{ route('content-items.show', $contentItem) }}"  wire:navigate
                                        class="font-semibold text-lg text-gray-800 dark:text-white mb-2 hover:underline">
                                        {{ $contentItem->title }}
                                    </a>

                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-2">
                                        <span class="font-medium">Type:</span>
                                        <span
                                            class="px-2 py-1 rounded text-white font-bold"
                                            style="background-color: {{ $contentItem->contentType->color }}">
                                            {{ $contentItem->contentType->name }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-2">
                                        <span class="font-medium">User:</span>
                                        <span
                                            class="px-2 py-1 rounded font-bold"
                                            >
                                            {{ $contentItem->contentType->user->name }}
                                        </span>
                                    </div>

                                    @if($contentItem->description)
                                        <p class="text-sm text-gray-600 dark:text-white mb-3">
                                            {{ Str::limit($contentItem->description, 100) }}
                                        </p>
                                    @endif

                                    @can('like', $contentItem)
                                    <livewire:content-items.like-button :contentItem="$contentItem" />
                                    @endcan
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500 text-lg">No content items found.</p>
                                <flux:link :href="route('content-items.create')" wire:navigate>{{ __('Create Your First Content Item') }}</flux:link>
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

