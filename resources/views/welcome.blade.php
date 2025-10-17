<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MyApp') }}</title>
    <script>
        const userPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (userPrefersDark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="cinema-background-sunset">
    <!-- Header -->
    <header class="flex items-center justify-between px-6 py-4">
        <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight">
             <x-app-logo />
        </a>
        <nav class="flex items-center gap-4">
            <!-- Lang Switcher-->
            <x-language-switcher />

            @if (Route::has('login'))
                @auth
                    <x-cinema-button href="{{ route('dashboard') }}"
                        wire:navigate
                        :glow="true"
                        palette="gold"
                    >
                        {{ __("welcome.buttons.dashboard") }}
                    </x-cinema-button>
                @else
                    <x-cinema-button href="{{ route('login') }}"
                        wire:navigate
                        :glow="true"
                        palette="gray"
                    >
                        {{ __("welcome.buttons.login") }}
                    </x-cinema-button>
                    @if (Route::has('register'))
                        <x-cinema-button href="{{ route('register') }}"
                            wire:navigate
                            :glow="true"
                            palette="purple"
                        >
                            {{ __("welcome.buttons.signup") }}
                        </x-cinema-button>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <!-- Hero -->
    <section class="text-center py-20 px-6">
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-4 text-neon-red">
            🎥 {{ config('app.name', 'CineMemo') }}
        </h1>
        <h2 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
            {{ __("welcome.header.first_part") }}, <br class="hidden md:block"> {{ __("welcome.header.second_part") }}
        </h2>
        <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300 mb-8">
            <span class="font-bold">{{ config('app.name', 'MyApp') }}</span> — {{ __("welcome.subheader") }}
        </p>
        <x-cinema-welcome-button href="{{ route('register') }}">
            🎬 {{ __("welcome.buttons.get_started") }}
        </x-cinema-welcome-button>
    </section>

    <!-- Features -->
    <section class="max-w-6xl mx-auto py-16 px-6 grid md:grid-cols-3 gap-10">
        <div class="p-6 rounded-2xl bg-gray-100 dark:bg-neutral-900 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">📚 {{ __("welcome.features.feat1-head") }}</h3>
            <p class="text-gray-600 dark:text-gray-300">
                {{ __("welcome.features.feat1-paragraph") }}.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-gray-100 dark:bg-neutral-900 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">💬 {{ __("welcome.features.feat2-head") }}</h3>
            <p class="text-gray-600 dark:text-gray-300">
                {{ __("welcome.features.feat2-paragraph") }}.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-gray-100 dark:bg-neutral-900 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">📱 {{ __("welcome.features.feat3-head") }}</h3>
            <p class="text-gray-600 dark:text-gray-300">
                {{ __("welcome.features.feat3-paragraph") }}.
            </p>
        </div>
    </section>

    <!-- Screenshots -->
    <section class="max-w-6xl mx-auto py-16 px-6">
        <h2 class="text-3xl font-bold text-center mb-10">{{ __("welcome.examples") }}</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <x-screenshot-card
                src="{{ asset('images/app-screenshots/screenshot-1.png') }}"
                alt="Main Dashboard"
                label="Main Dashboard"
            />
            <x-screenshot-card
                src="{{ asset('images/app-screenshots/screenshot-2.png') }}"
                alt="Content Types"
                label="Content Types"
            />
            <x-screenshot-card
                src="{{ asset('images/app-screenshots/screenshot-3.png') }}"
                alt="Create"
                label="Create"
            />
             <x-screenshot-card
                src="{{ asset('images/app-screenshots/screenshot-6.png') }}"
                alt="Your Content"
                label="Your Content"
            />
            <x-screenshot-card
                src="{{ asset('images/app-screenshots/screenshot-5.png') }}"
                alt="People"
                label="People"
            />
            <x-screenshot-card
                src="{{ asset('images/app-screenshots/screenshot-4.png') }}"
                alt="Recommendations"
                label="Recommendations"
            />
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gray-50 dark:bg-neutral-950">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                {{ __("welcome.reviews.head") }}
            </h2>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                {{ __("welcome.reviews.paragraph") }}:
            </p>

            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="rounded-2xl bg-white dark:bg-neutral-900 p-6 shadow-md">
                    <p class="text-gray-700 dark:text-gray-300">
                        “{{ __("welcome.reviews.first_review.message") }}.”
                    </p>
                    <div class="mt-4 flex items-center gap-4">
                        <img src="https://i.pravatar.cc/60?img=1" alt="User" class="h-12 w-12 rounded-full object-cover">
                        <div class="text-left">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ __("welcome.reviews.first_review.name") }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("welcome.reviews.first_review.profession") }}</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="rounded-2xl bg-white dark:bg-neutral-900 p-6 shadow-md">
                    <p class="text-gray-700 dark:text-gray-300">
                        “{{ __("welcome.reviews.second_review.message") }} ❤️”
                    </p>
                    <div class="mt-4 flex items-center gap-4">
                        <img src="https://i.pravatar.cc/60?img=2" alt="User" class="h-12 w-12 rounded-full object-cover">
                        <div class="text-left">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ __("welcome.reviews.second_review.name") }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("welcome.reviews.second_review.profession") }}</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="rounded-2xl bg-white dark:bg-neutral-900 p-6 shadow-md">
                    <p class="text-gray-700 dark:text-gray-300">
                        “{{ __("welcome.reviews.third_review.message") }}.”
                    </p>
                    <div class="mt-4 flex items-center gap-4">
                        <img src="https://i.pravatar.cc/60?img=3" alt="User" class="h-12 w-12 rounded-full object-cover">
                        <div class="text-left">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ __("welcome.reviews.third_review.name") }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("welcome.reviews.third_review.profession") }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="text-center mt-12">
        <x-cinema-welcome-button href="{{ route('register') }}">
            🎬 {{ __("welcome.buttons.get_started_bottom") }}
        </x-cinema-welcome-button>
    </div>

    <!-- Feedback -->
    <section class="max-w-6xl mx-auto py-16 px-6">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">{{ __("welcome.feedback.head") }}</h2>
        <div class="max-w-2xl mx-auto bg-white dark:bg-neutral-900 p-8 rounded-lg shadow">
            <livewire:contact-form />
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-6 text-center text-gray-500 dark:text-gray-400">
        © {{ date('Y') }} {{ config('app.name', 'MyApp') }}. {{ __("welcome.rights") }}.
    </footer>

</body>
</html>
