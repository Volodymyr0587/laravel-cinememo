<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Create Article') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save" enctype="multipart/form-data">

                        <div class="mt-4">
                            <flux:input
                                {{-- wire:model="name" --}}
                                wire:model.live.debounce.300ms="title"
                                :label="__('Title') . ' *'"
                                type="text"
                                autocomplete="title"
                                placeholder="Leonardo DiCaprio admits deep regret over passing on major Hollywood movie"
                            />
                        </div>


                        <div class="mt-4">
                            <flux:textarea wire:model="body" :label="__('Body')" id="body" rows="10"></flux:textarea>
                        </div>

                        <div class="mt-4">
                        <flux:field variant="inline">
                            <flux:checkbox wire:model="is_published" />

                            <flux:label>Publish article</flux:label>

                            <flux:error name="is_published" />
                        </flux:field>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                :label="__('Image')"
                                wire:model="main_image"
                                type="file"
                                id="main_image"
                                accept="image/*" />

                            @if ($main_image)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-800 dark:text-white">Preview:</p>
                                    <img src="{{ $main_image->temporaryUrl() }}" alt="Preview" class="mt-1 h-32 w-32 object-cover rounded">
                                </div>
                            @endif

                            <div wire:loading wire:target="image" class="text-sm text-gray-600 mt-2">
                                Uploading...
                            </div>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                :label="__('Additional images')"
                                wire:model="additional_images"
                                type="file"
                                multiple />
                        </div>

                         @if ($additional_images)
                            <div class="mt-4">
                                <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">Additional Image Previews:</p>
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($additional_images as $file)
                                        <div class="w-24 h-24">
                                            <img src="{{ $file->temporaryUrl() }}" alt="Preview"
                                                class="w-full h-full object-cover rounded border border-gray-300">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- <div class="mt-4">
                            <label for="content_type_id" class="block text-sm font-semibold text-gray-800 dark:text-white mb-2">
                                {{ __("Select tags") }}
                            </label>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-3">
                                @forelse($tags as $tag)
                                    <label x-data="{ hover: false }" class="relative flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox"
                                            id="content_item_{{ $tag->id }}"
                                            wire:model="content_items"
                                            value="{{ $tag->id }}"
                                            class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600">

                                        <span @mouseenter="hover = true" @mouseleave="hover = false"
                                            class="text-gray-700 dark:text-white text-sm relative">
                                            {{ $tag->name }}
                                        </span>
                                    </label>
                                @empty
                                    <span class="font-semibold italic text-xs dark:text-white">
                                        {{ __("There are no tags yet.") }}
                                    </span>
                                @endforelse
                            </div>
                            <div class="my-12">
                                <hr class="h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                                <p class="mt-2 font-bold text-xs italic">* - {{ __("Required fields") }}</p>
                            </div>

                        </div> --}}

                        <div class="mt-6 flex items-center justify-between">
                            <flux:button variant="primary" type="submit" >{{ __('Create Article') }}</flux:button>
                            <flux:link :href="route('articles.index')" wire:navigate>{{ __('Cancel') }}</flux:link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

