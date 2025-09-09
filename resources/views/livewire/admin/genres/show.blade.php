<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
            <div class="p-6">
                {{-- Back Button --}}
                <div class="mb-4">
                    <flux:link href="{{ route('admin.genres.index') }}" wire:navigate>
                        ← {{ __('Back to all genres') }}
                    </flux:link>
                </div>

                {{-- Name --}}
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
                    {{ $genre->name }}
                </h2>

                {{-- Description --}}
                @if($genre->description)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __('Description') }}</p>
                        <p class="text-base text-gray-800 dark:text-white">{{ $genre->description }}</p>
                    </div>
                @endif

                {{-- Action Buttons --}}
                @can('update', $genre)
                <div class="flex justify-between items-center mt-6">
                    <flux:button href="{{ route('admin.genres.edit', $genre) }}" wire:navigate>
                        {{ __('Edit') }}
                    </flux:button>

                    <button type="submit" wire:click="delete({{ $genre->id }})"
                            wire:confirm="Are you sure you want to delete this genre?"
                            class="px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-800 text-sm font-medium hover:cursor-pointer">
                        {{ __('Delete') }}
                    </button>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>

<script>

</script>
