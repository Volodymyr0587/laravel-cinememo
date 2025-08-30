<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route('home') }}" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('layouts-app-header.dashboard') }}
                </flux:navbar.item>
            </flux:navbar>

            <flux:dropdown position="top" align="start" class="max-lg:hidden">
                <flux:button variant="ghost" size="sm" icon="circle-stack" icon:trailing="chevron-down" class="hover:cursor-pointer">{{ __('layouts-app-header.my-collection') }}</flux:button>
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            @php
                                $countActors = auth()->user()->actors()->count();
                            @endphp
                            <flux:navbar.item icon="users" :href="route('actors.index')"
                                class="{{ request()->routeIs('actors.index') ? 'text-neon-gold' : '' }}" wire:navigate>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('layouts-app-header.actors') }}</span>
                                    <flux:badge color="purple" size="sm" class="ml-1">{{ $countActors }}</flux:badge>
                                </div>
                            </flux:navbar.item>
                        </div>

                        <flux:menu.separator />

                        <div class="p-0 text-sm font-normal">
                            @php
                                $countContentTypes = auth()->user()->contentTypes()->count();
                            @endphp
                            <flux:navbar.item icon="list-bullet" :href="route('content-types.index')"
                                class="{{ request()->routeIs('content-types.index') ? 'text-neon-gold' : '' }}" wire:navigate>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('layouts-app-header.categories') }} </span>
                                    <flux:badge   flux:badge color="orange" size="sm" class="ml-1">{{ $countContentTypes }}</flux:badge>
                                </div>
                            </flux:navbar.item>

                        </div>

                        <flux:menu.separator />

                        @php
                            $countContentItems = auth()->user()->contentItems()->count();
                        @endphp
                        <flux:navbar.item icon="film" :href="route('content-items.index')"
                            class="{{ request()->routeIs('content-items.index') ? 'text-neon-gold' : '' }}" wire:navigate>
                            <div class="flex items-center justify-between">
                                <span>{{ __('layouts-app-header.content') }}</span>
                                <flux:badge color="blue" size="sm" class="ml-1">{{ $countContentItems }}</flux:badge>
                            </div>
                        </flux:navbar.item>

                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>

            @php
                $countPublicContentItems = App\Models\ContentItem::where('is_public', true)->count();
            @endphp

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="film" :href="route('public-content.index')" :current="request()->routeIs('public-content.index')" wire:navigate>
                    {{ __('layouts-app-header.public-content') }} <flux:badge color="green" size="sm" class="ml-1">{{ $countPublicContentItems }}</flux:badge>
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />
            @php
                $countTrashedContentItems = auth()->user()->contentItems()->onlyTrashed()->count();
            @endphp

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="trash" :href="route('content-items.trash')" :current="request()->routeIs('content-items.trash')" wire:navigate>
                    {{ __('layouts-app-header.trash') }} <flux:badge color="rose" size="sm" class="ml-1">{{ $countTrashedContentItems }}</flux:badge>
                </flux:navbar.item>
            </flux:navbar>

            <!-- Lang Switcher-->
            <x-language-switcher class="mr-2" />

            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">
                @if (auth()->user()->profile_image)
                    <flux:profile
                        class="cursor-pointer"
                        :name="auth()->user()->name"
                        :avatar="Storage::url(auth()->user()->profile_image)"
                     />
                @else
                    <flux:profile
                        class="cursor-pointer"
                        :name="auth()->user()->name"
                        :initials="auth()->user()->initials()"
                     />
                @endif

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                         @if (auth()->user()->profile_image)
                                            <img src="{{ Storage::url(auth()->user()->profile_image) }}" alt="">
                                         @else
                                            {{ auth()->user()->initials() }}
                                         @endif
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    @role('admin')
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('admin.users.index')" icon="users" wire:navigate>{{ __('layouts-app-header.user-management') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />
                    @endrole

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('layouts-app-header.settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('layouts-app-header.log-out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('home') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Menu')">
                    <flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                      {{ __('layouts-app-header.dashboard') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('actors.index')" :current="request()->routeIs('actors.index')" wire:navigate>
                        <div class="flex items-center justify-between">
                            <span>{{ __('layouts-app-header.actors') }}</span>
                            <flux:badge color="purple" size="sm" class="ml-1">{{ $countActors }}</flux:badge>
                        </div>
                    </flux:navlist.item>
                    <flux:navlist.item icon="list-bullet" :href="route('content-types.index')" :current="request()->routeIs('content-types.index')" wire:navigate>
                        <div class="flex items-center justify-between">
                            <span>{{ __('layouts-app-header.categories') }}</span>
                            <flux:badge color="orange" size="sm" class="ml-1">{{ $countContentTypes }}</flux:badge>
                        </div>
                    </flux:navlist.item>
                    <flux:navlist.item icon="film" :href="route('content-items.index')" :current="request()->routeIs('content-items.index')" wire:navigate>
                        <div class="flex items-center justify-between">
                            <span>{{ __('layouts-app-header.my-collection') }}</span>
                            <flux:badge color="blue" size="sm" class="ml-1">{{ $countContentItems }}</flux:badge>
                        </div>
                    </flux:navlist.item>
                    <flux:navlist.item icon="film" :href="route('public-content.index')" :current="request()->routeIs('public-content.index')" wire:navigate>
                        <div class="flex items-center justify-between">
                            <span>{{ __('layouts-app-header.public-content') }}</span>
                            <flux:badge color="green" size="sm" class="ml-1">{{ $countPublicContentItems }}</flux:badge>
                        </div>
                    </flux:navlist.item>
                    <flux:navlist.item icon="trash" :href="route('content-items.trash')" :current="request()->routeIs('content-items.trash')" wire:navigate>
                        <div class="flex items-center justify-between">
                            <span>{{ __('layouts-app-header.trash') }}</span>
                            <flux:badge color="rose" size="sm" class="ml-1">{{ $countTrashedContentItems }}</flux:badge>
                        </div>
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            {{-- <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist> --}}
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
