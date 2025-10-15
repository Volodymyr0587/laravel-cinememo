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
                <div class="flex flex-wrap items-center gap-6">
                    {{-- Profile Image / Initials --}}
                    <div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-zinc-700 flex items-center justify-center overflow-hidden">
                        @if($user->profile_image)
                            <img src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-lg font-bold text-gray-800 dark:text-white">
                                {{ $user->initials() }}
                            </span>
                        @endif
                    </div>

                    {{-- User Info + Roles --}}
                    <div class="flex flex-1 flex-wrap items-center justify-between gap-4">
                        <!-- Left: User info -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                                {{ $user->name }}
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Member since') }} {{ $user->created_at->format('M d, Y') }}
                            </p>
                        </div>

                        <!-- Right: Roles -->
                        <div class="text-right">
                            <span class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Roles:</span>
                            <div class="flex flex-wrap justify-end items-center gap-2">
                                @forelse ($user->getRoleNames() as $roleName)
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-blue-500 text-white">
                                        {{ $roleName }}
                                    </span>
                                @empty
                                    <span class="text-sm text-gray-500 dark:text-gray-400">User has no roles</span>
                                @endforelse
                            </div>
                        </div>
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
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __("dashboard.total_cast_and_crew") }}</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $user->people->count() }}</p>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-zinc-700 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ __("dashboard.total_categories") }}</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $user->contentTypes->count() }}</p>
                    </div>
                </div>

                {{-- Actions --}}
                @can('update', $user)
                <div class="flex justify-end">
                    <x-cinema-button href="{{ route('admin.users.edit', $user) }}"
                        class=""
                        wire:navigate
                        :glow="true"
                        palette="purple"
                    >
                        {{ __("Edit User") }}
                    </x-cinema-button>
                </div>
                @endcan

            </div>
        </div>
    </div>
</div>
