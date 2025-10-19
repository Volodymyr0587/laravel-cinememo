<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __("professions/show.more_about_the_profession") }} <span class="text-2xl">"{{ $profession->name
                }}"</span>
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg shadow-lg">
                <div class="p-6">
                    {{-- Back Button --}}
                    <div class="mb-4">
                        <flux:link href="{{ route('admin.professions.index') }}" wire:navigate>
                            ← {{ __('professions/show.back_to_all_professions') }}
                        </flux:link>
                    </div>

                    {{-- Name --}}
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
                        {{ $profession->name }}
                    </h2>

                    {{-- Description --}}
                    @if($profession->description)
                    <div class="mb-6">
                        <p class="text-base text-gray-800 dark:text-white">{{ $profession->description }}</p>
                    </div>
                    @endif

                    {{-- Action Buttons --}}
                    @can('update', $profession)
                    <div class="flex justify-between items-center mt-6">
                        <x-cinema-button href="{{ route('admin.professions.edit', $profession) }}" class=""
                            wire:navigate :glow="true" palette="purple">
                            {{ __("professions/show.edit_button") }}
                        </x-cinema-button>

                        <x-cinema-button wire:click="delete({{ $profession->id }})"
                            wire:confirm="{{ __('professions/show.are_you_sure', ['name' => $profession->name]) }}"
                            :glow="true" palette="red">
                            {{ __("professions/show.delete_button") }}
                        </x-cinema-button>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
