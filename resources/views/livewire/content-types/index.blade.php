<div>

    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('content_types/main.categories') }}
            @if($search)
                <flux:button
                    wire:click.prevent="clearFilters"
                    wire:key="index-content-types-clear-filters-btn"
                    class="ml-2 hover:cursor-pointer"
                >
                    {{ __('content_types/main.clear_filters') }}
                </flux:button>
            @endif
        </h2>
        <x-cinema-button href="{{ route('content-types.create') }}"
                class="order-1 sm:order-none"
                wire:navigate
                :glow="true"
                palette="gold"
            >
                {{ __('content_types/main.add_new_category') }}
        </x-cinema-button>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">

                    <x-flash-message />

                    <div class="mb-4">
                        <flux:input
                            wire:model.live="search"
                            :label="__('content_types/main.search')"
                            type="text"
                            :placeholder="__('content_types/main.search_category')"
                        />
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('content_types/main.name') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('content_types/main.items_count') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('content_types/main.created') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('content_types/main.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($contentTypes as $contentType)
                                    <tr wire:key="content-type-{{ $contentType->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            <span class="px-2 py-1 rounded text-xs font-bold" style="background-color: {{ $contentType->color }}">
                                                {{ $contentType->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $contentType->content_items_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $contentType->created_at->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <x-cinema-button href="{{ route('content-types.edit', $contentType) }}"
                                                wire:navigate
                                                palette="purple"
                                            >{{ __("people/main.edit") }}</x-cinema-button>
                                            <x-cinema-button wire:click="delete({{  $contentType->id }})"
                                                wire:confirm="{{ __('content_types/main.delete_confirm_message') }}"
                                                class="hover:cursor-pointer ml-2"
                                                palette="red"
                                            >{{ __("content_types/main.delete") }}</x-cinema-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            <div class="col-span-full text-center py-8">
                                                <p>{{ __('content_types/main.no_categories_found') }}.</p>
                                                <flux:link :href="route('content-types.create')" wire:navigate>{{ __("content_types/main.add_first_category") }}</flux:link>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $contentTypes->links('pagination.custom-tailwind') }}
                    </div>

            </div>
        </div>
    </div>
</div>
