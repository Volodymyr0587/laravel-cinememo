<div>
    <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('articles/create.create_article') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="save" enctype="multipart/form-data">

                        <div class="mt-4">
                            <flux:input
                                wire:model.live.debounce.300ms="title"
                                :label="__('articles/create.title') . ' *'"
                                type="text"
                                autocomplete="title"
                                placeholder="{{ __('articles/create.title_placeholder') }}"
                            />
                        </div>


                        <div class="mt-4">
                            <flux:textarea wire:model="introduction" :label="__('articles/create.introduction') . ' *'" id="introduction" rows="10"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="main" :label="__('articles/create.main') . ' *'" id="main" rows="10"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <flux:textarea wire:model="conclusion" :label="__('articles/create.conclusion')" id="conclusion" rows="10"></flux:textarea>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                id="tags"
                                wire:model.defer="tags"
                                :label="__('articles/create.tags')"
                                type="text"
                                placeholder="{{ __('articles/create.tags_example') }}"
                            />
                        </div>

                        @hasanyrole(['super_admin', 'admin'])
                            <div class="mt-4">
                                <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">{{ __("articles/create.visibility") }}</p>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox"
                                        wire:model="is_published"
                                        class="appearance-none w-5 h-5 rounded border border-gray-400 bg-white checked:bg-blue-600 checked:border-blue-600">
                                    <div class="grid grid-cols-1">
                                        <span class="text-gray-700 dark:text-white text-sm">{{ __("articles/create.make_public") }}</span>
                                        <span class="text-xs italic">({{ __("articles/create.other_users_view_leave_comments") }})</span>
                                    </div>
                                </label>
                            </div>
                        @endhasanyrole

                        <div class="mt-4">
                            <flux:input
                                :label="__('articles/create.image')"
                                wire:model="main_image"
                                type="file"
                                id="main_image"
                                accept="image/*" />

                            @if ($main_image)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-800 dark:text-white">{{ __("articles/create.preview") }}:</p>
                                    <img src="{{ $main_image->temporaryUrl() }}" alt="{{ __("articles/create.preview") }}" class="mt-1 h-32 w-32 object-cover rounded">
                                </div>
                            @endif

                            <div wire:loading wire:target="image" class="text-sm text-gray-600 mt-2">
                                {{ __("articles/create.uploading") }}...
                            </div>
                        </div>

                        <div class="mt-4">
                            <flux:input
                                :label="__('articles/create.additional_images')"
                                wire:model="additional_images"
                                type="file"
                                multiple />
                        </div>

                         @if ($additional_images)
                            <div class="mt-4">
                                <p class="text-sm text-gray-800 dark:text-white font-semibold mb-2">{{ __("articles/create.additional_image_previews") }}:</p>
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($additional_images as $file)
                                        <div class="w-24 h-24">
                                            <img src="{{ $file->temporaryUrl() }}" alt="{{ __("articles/create.preview") }}"
                                                class="w-full h-full object-cover rounded border border-gray-300">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <div class="my-12">
                                <hr class="h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" />
                                <p class="mt-2 font-bold text-xs italic">* - {{ __("articles/create.require_fields") }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <x-cinema-button type="submit" :glow="true" palette="gold" >
                                {{ __('articles/create.create_article_button') }}
                            </x-cinema-button>
                            <x-cinema-button :href="route('writer.articles.index')" :glow="true" palette="gray" wire:navigate>
                                {{ __("articles/create.cancel_button") }}
                            </x-cinema-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

