<div>
     <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <x-dashboard.card title="Total Content Items">
                <div class="flex items-center gap-x-2 text-2xl font-bold"><flux:icon.film /> {{ $contentItemsCount }}</div>
                @if ($lastUpdatedContentItem)
                    <div class="text-gray-500 dark:text-gray-400">
                         Last updated: {{ $lastUpdatedContentItem->updated_at->diffForHumans() }} ({{ $lastUpdatedContentItem->title }})
                    </div>
                @endif
            </x-dashboard.card>
            <x-dashboard.card title="Total Content Types">
                <div class="flex items-center gap-x-2 text-2xl font-bold"><flux:icon.list-bullet />{{ $contentTypesCount }}</div>
                @if ($lastUpdatedContentType)
                    <div class="text-gray-500 dark:text-gray-400">
                        Last updated: {{ $lastUpdatedContentType->updated_at->diffForHumans() }} ({{ $lastUpdatedContentType->name }})
                    </div>
                @endif
            </x-dashboard.card>
            <x-dashboard.card title="Number of Trashed Content Items">
                <div class="flex items-center gap-x-2 text-2xl font-bold"><flux:icon.trash />{{ $trashedContentItemsCount }}</div>
                @if ($trashedContentItemsCount)
                    <div class="text-gray-500 dark:text-gray-400">
                        In trash {{ $trashedContentItemsCount }}  content items
                    </div>
                @endif
            </x-dashboard.card>
            {{-- <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div> --}}
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
    @forelse ($contentItems as $item)
        <a href="{{ route('content-items.show', $item) }}" wire:navigate
           class="group relative block aspect-[3/4] overflow-hidden rounded-lg shadow hover:shadow-lg transition-shadow duration-200 border border-neutral-200 dark:border-neutral-700">
            <img src="{{ $item->main_image_url ? $item->main_image_url : asset('images/default-content.png') }}"
                 alt="{{ $item->title }}"
                 class="h-full w-full object-cover transition-transform duration-200 group-hover:scale-105" />

            <div class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-sm p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                {{ $item->title }}
            </div>
        </a>
    @empty
        <p class="text-center text-neutral-500 dark:text-neutral-400 col-span-full">No content items yet</p>
    @endforelse
</div>
</div>




