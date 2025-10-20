<div>
    <div class="mt-2 flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('articles/deleted.deleted_articles') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">

                <x-flash-message />

                <!-- ArticlesTable -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('articles/deleted.name') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('articles/deleted.deleted') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('articles/deleted.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($articles as $article)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $article->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $article->deleted_at->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td class="flex gap-x-2 px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <x-cinema-button wire:click="restore({{ $article->id }})"
                                            type="button" :glow="true" palette="green">
                                            {{ __("articles/deleted.restore") }}
                                        </x-cinema-button>
                                        <x-cinema-button wire:click="forceDelete({{ $article->id }})"
                                            wire:confirm="{{ __('articles/deleted.are_you_sure_delete') }}"
                                            type="button" :glow="true" palette="red">
                                            {{ __("articles/deleted.delete_permanently") }}
                                        </x-cinema-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        {{ __('articles/deleted.trash_empty') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $articles->links('pagination.custom-tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>
