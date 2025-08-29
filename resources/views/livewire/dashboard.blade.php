<div>
     <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <x-dashboard.card title="{{ __('dashboard.total_in_the_collection') }}">
                <div class="flex items-center gap-x-2 text-2xl font-bold"><flux:icon.film /> {{ $stats->contentItemsCount }}</div>
                @if ($stats->lastUpdatedContentItem)
                    <div class="text-gray-500 dark:text-gray-400">
                         {{ __("dashboard.last_updated") }}: {{ $stats->lastUpdatedContentItem->updated_at->diffForHumans() }} ({{ $stats->lastUpdatedContentItem->title }})
                    </div>
                @endif
            </x-dashboard.card>
            <x-dashboard.card title="{{ __('dashboard.total_categories') }}">
                <div class="flex items-center gap-x-2 text-2xl font-bold"><flux:icon.list-bullet />{{ $stats->contentTypesCount }}</div>
                @if ($stats->lastUpdatedContentType)
                    <div class="text-gray-500 dark:text-gray-400">
                        {{ __("dashboard.last_updated") }}: {{ $stats->lastUpdatedContentType->updated_at->diffForHumans() }} ({{ $stats->lastUpdatedContentType->name }})
                    </div>
                @endif
            </x-dashboard.card>
            <x-dashboard.card title="{{ __('dashboard.total_actors') }}">
                <div class="flex items-center gap-x-2 text-2xl font-bold"><flux:icon.list-bullet />{{ $stats->actorsCount }}</div>
                @if ($stats->actorsCount)
                    <div class="text-gray-500 dark:text-gray-400">
                        {{ __("dashboard.last_updated") }}: {{ $stats->lastUpdatedActor->updated_at->diffForHumans() }} ({{ $stats->lastUpdatedActor->name }})
                    </div>
                @endif
            </x-dashboard.card>
            <x-dashboard.card title="{{ __('dashboard.total_in_trash') }}">
                <div class="flex items-center gap-x-2 text-2xl font-bold"><flux:icon.trash />{{ $stats->trashedContentItemsCount }}</div>
                @if ($stats->lastTrashedContentItem)
                    <div class="text-gray-500 dark:text-gray-400">
                        {{ __("dashboard.last_trashed") }}: {{ $stats->lastTrashedContentItem->deleted_at->diffForHumans() }} ({{ $stats->lastTrashedContentItem->title }})
                    </div>
                @endif
            </x-dashboard.card>
            {{-- <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div> --}}
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
        @forelse ($stats->contentItems as $item)
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
            <p class="text-center text-neutral-500 dark:text-neutral-400 col-span-full">{{ __("There is currently nothing in your collection") }}.</p>
        @endforelse
    </div>
    <!-- Footer -->
    <footer class="py-6 text-center text-gray-500 dark:text-gray-400">
        © {{ date('Y') }} {{ config('app.name', 'MyApp') }}. {{ __("welcome.rights") }}.
    </footer>
</div>




