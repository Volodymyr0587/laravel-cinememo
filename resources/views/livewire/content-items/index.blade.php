<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Content Items') }}
            @if($statusFilter || $contentTypeFilter || $genreFilter || $search)
                <flux:button
                    wire:click="clearFilters"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('Clear filters') }}
                </flux:button>
            @endif
        </h2>
        <div class="flex flex-col gap-y-4 sm:flex-row sm:items-center sm:gap-x-8">
            <flux:button
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
            </flux:button>
            <x-button href="{{ route('content-items.create') }}" class="order-1 sm:order-none" wire:navigate>{{ __('Add New Content Item') }}</x-button>
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
                                :label="__('Search')"
                                type="text"
                                :placeholder="__('Search content items...')"
                            />
                        </div>
                        <div>
                            <flux:select wire:model.live="statusFilter" :label="__('Status')">
                                <option value="">All Statuses</option>
                                @foreach(\App\Enums\ContentStatus::labels() as $value => $label)
                                    <option value="{{ $value }}">{{ __($label) }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div>
                            <flux:select wire:model.live="contentTypeFilter" :label="__('Content Type')">
                                <option value="">All Content Types</option>
                                @foreach($contentTypes as $contentType)
                                    <option value="{{ $contentType->id }}">{{ $contentType->name }}</option>
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
                                    @if ($contentItem->is_public)
                                        <span class="px-2 py-0.5 mr-1 rounded text-xs font-bold bg-indigo-400 text-red-600">
                                            public
                                        </span>
                                    @endif
                                    <a href="{{ route('content-items.show', $contentItem) }}"  wire:navigate
                                        class="font-semibold text-lg text-gray-800 dark:text-white mb-2 hover:underline">
                                        {{ $contentItem->title }}
                                    </a>

                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-2">
                                        <span class="font-medium">Type:</span>
                                        <span
                                            wire:click="$set('contentTypeFilter', '{{ $contentItem->contentType->id }}')"
                                            class="px-2 py-1 rounded text-white font-bold hover:cursor-pointer"
                                            style="background-color: {{ $contentItem->contentType->color }}">
                                            {{ $contentItem->contentType->name }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 mb-2 text-sm">
                                        <span class="font-semibold text-gray-700 dark:text-gray-300 col-span-full">Genres:</span>
                                        @foreach ($contentItem->genres as $genre)
                                            <span
                                                class="px-2 py-1 rounded font-bold text-xs text-white bg-blue-500 dark:bg-blue-600
                                                    hover:bg-blue-600 dark:hover:bg-blue-700 transition-colors duration-200
                                                    text-center cursor-pointer select-none shadow-sm"
                                                    wire:click="$set('genreFilter', {{ $genre->id }})"
                                                >
                                                {{ $genre->name }}
                                            </span>
                                        @endforeach
                                    </div>


                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-3">
                                        <span class="font-medium">Status:</span>
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
                                        <flux:button href="{{ route('content-items.edit', $contentItem) }}" wire:navigate>Edit</flux:button>
                                        <x-button wire:click="delete({{ $contentItem->id }})"
                                                wire:confirm="Are you sure you want to delete this content item?"
                                                color="red" type="submit"
                                                >Delete</x-button>
                                    </div>
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
