<div>
    <div class="mt-2 flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('content_items/trash.deleted_content') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <x-flash-message />

                <!-- Content Items Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('content_items/trash.name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('content_items/trash.deleted') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('content_items/trash.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($contentItems as $contentItem)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $contentItem->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $contentItem->deleted_at->format('Y-m-d H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-1">
                                        <x-cinema-button wire:click="restore({{ $contentItem->id }})" :glow="true" palette="green" >
                                            {{ __('content_items/trash.restore') }}
                                        </x-cinema-button>
                                        <x-cinema-button wire:click="forceDelete({{ $contentItem->id }})"
                                                wire:confirm="{{ __('content_items/trash.are_you_sure_delete') }}"
                                                :glow="true" palette="red">
                                            {{ __("content_items/trash.delete_permanently") }}
                                        </x-cinema-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        {{ __('content_items/trash.trash_empty') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $contentItems->links('pagination.custom-tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>
