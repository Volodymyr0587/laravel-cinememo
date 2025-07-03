<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Content Items') }}
        </h2>
        <flux:link :href="route('content-items.create')" wire:navigate>{{ __('Add New Content Item') }}</flux:link>
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
                                <option value="willwatch">Will Watch</option>
                                <option value="watching">Watching</option>
                                <option value="watched">Watched</option>
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
                                @if($contentItem->image_url)
                                    <img src="{{ $contentItem->image_url }}" alt="{{ $contentItem->title }}"
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 dark:bg-zinc-400 flex items-center justify-center">
                                        <span class="text-gray-500 dark:text-gray-700">No Image</span>
                                    </div>
                                @endif

                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-2">{{ $contentItem->title }}</h3>

                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-2">
                                        <span class="font-medium">Type:</span>
                                        <span>{{ $contentItem->contentType->name }}</span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-white mb-3">
                                        <span class="font-medium">Status:</span>
                                        <span @class([
                                            'px-2 py-1 rounded text-xs',
                                            'bg-green-100 text-green-800' => $contentItem->status === \App\Enums\ContentStatus::Watched,
                                            'bg-yellow-100 text-yellow-800' => $contentItem->status === \App\Enums\ContentStatus::Watching,
                                            'bg-blue-100 text-blue-800' => $contentItem->status === \App\Enums\ContentStatus::WillWatch,
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
                                        {{-- <a href="{{ route('content-items.edit', $contentItem) }}" wire:navigate
                                           class="px-4 py-2 rounded-md bg-amber-300 text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a> --}}
                                        <flux:button href="{{ route('content-items.edit', $contentItem) }}" wire:navigate>Edit</flux:button>
                                        <button wire:click="delete({{ $contentItem->id }})"
                                                wire:confirm="Are you sure you want to delete this content item?"
                                                class="px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-900 text-sm font-medium hover:cursor-pointer">Delete</button>
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
