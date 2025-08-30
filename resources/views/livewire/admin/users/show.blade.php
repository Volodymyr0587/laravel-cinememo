<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white dark:bg-zinc-800 shadow-lg dark:shadow-zinc-500/50 sm:rounded-2xl">
            <div class="p-6 sm:p-8 space-y-6">

                {{-- Back Button --}}
                <div>
                    <flux:link href="{{ route('admin.users.index') }}" wire:navigate class="text-sm">
                        ← {{ __('Back to all users') }}
                    </flux:link>
                </div>

                {{-- Header --}}
                <div class="flex items-center gap-4">
                    {{-- Profile Image / Initials --}}
                    <div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-zinc-700 flex items-center justify-center overflow-hidden">
                        @if($user->profile_image)
                            <img src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-lg font-bold text-gray-800 dark:text-white">{{ $user->initials() }}</span>
                        @endif
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $user->name }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Member since') }} {{ $user->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                {{-- Info Badges --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:gap-6 gap-3">
                    <div class="flex items-center gap-x-2 text-sm">
                        <span class="font-medium text-gray-600 dark:text-gray-300">{{ __('login.form.email') }}:</span>
                        <span class="px-2 py-1 rounded text-xs font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900">
                            {{ $user->email }}
                        </span>
                    </div>
                </div>

                {{-- Meta Stats --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-zinc-700 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __("dashboard.total_in_the_collection") }}</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $user->contentItems->count() }}</p>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-zinc-700 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __("dashboard.total_actors") }}</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $user->actors->count() }}</p>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-zinc-700 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __("dashboard.total_categories") }}</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $user->contentTypes->count() }}</p>
                    </div>
                </div>

                {{-- Actions --}}
                @can('edit_users')
                <div class="flex justify-end">
                    <flux:button href="{{ route('admin.users.edit', $user) }}" wire:navigate>
                        {{ __('Edit User') }}
                    </flux:button>
                </div>
                @endcan

            </div>
        </div>
    </div>
</div>
