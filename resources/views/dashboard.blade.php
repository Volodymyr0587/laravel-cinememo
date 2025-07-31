<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <x-dashboard.card title="Total Content Items">
                <div class="text-2xl font-bold">{{ $contentItemsCount }}</div>
                @if ($lastUpdatedContentItem)
                    <div class="text-gray-500 dark:text-gray-400">
                         Last updated: {{ $lastUpdatedContentItem->updated_at->diffForHumans() }} ({{ $lastUpdatedContentItem->title }})
                    </div>
                @endif
            </x-dashboard.card>
            <x-dashboard.card title="Total Content Types">
                <div class="text-2xl font-bold">{{ $contentTypesCount }}</div>
                @if ($lastUpdatedContentType)
                    <div class="text-gray-500 dark:text-gray-400">
                        Last updated: {{ $lastUpdatedContentType->updated_at->diffForHumans() }} ({{ $lastUpdatedContentType->name }})
                    </div>
                @endif
            </x-dashboard.card>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>
