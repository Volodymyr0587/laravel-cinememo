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
<body class="bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 text-gray-900 dark:text-gray-100">
    <!-- Header -->
    <header class="flex items-center justify-between px-6 py-4">
        <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight">
             <x-app-logo />
            {{-- {{ config('app.name', 'MyApp') }} --}}
        </a>
        <nav class="flex space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700">
                        {{ __("Dashboard") }}
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700">
                        {{ __("Log in") }}
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 shadow-lg">
                            {{ __("Sign up") }}
                        </a>
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
            {{ __("Organize your content") }}, <br class="hidden md:block"> {{ __("save your ideas, stay productive") }}
        </h2>
        <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300 mb-8">
            <span class="font-bold">{{ config('app.name', 'MyApp') }}</span> — {{ __("is an application for saving notes, movies, articles and everything that is important. In one place. Anytime.") }}
        </p>
        <a href="{{ route('register') }}"
           class="px-6 py-3 rounded-xl bg-blue-600 text-white text-lg font-semibold shadow-lg hover:bg-blue-700 transition">
            {{ __("Get started for free") }}
        </a>
    </section>

    <!-- Features -->
    <section class="max-w-6xl mx-auto py-16 px-6 grid md:grid-cols-3 gap-10">
        <div class="p-6 rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">📚 {{ __("Organize everything") }}</h3>
            <p class="text-gray-600 dark:text-gray-300">
                {{ __("Categories, tags, and filters will help you quickly find what you need.") }}
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">💬 {{ __("Communicate and interact") }}</h3>
            <p class="text-gray-600 dark:text-gray-300">
                {{ __("The ability to comment and like other users' content.") }}
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">📱 {{ __("Always nearby") }}</h3>
            <p class="text-gray-600 dark:text-gray-300">
                {{ __("Use the app on your smartphone, tablet, or computer.") }}
            </p>
        </div>
    </section>

    <!-- Screenshots -->
    <section class="max-w-6xl mx-auto py-16 px-6">
        <h2 class="text-3xl font-bold text-center mb-10">{{ __("Examples of the interface") }}</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="rounded-xl overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-700  hover:scale-150 transition-transform duration-200">
                <img src="{{ asset('images/app-screenshots/screenshot-1.png') }}" alt="Screenshot 1" class="w-full h-auto">
            </div>
            <div class="rounded-xl overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-700  hover:scale-150 transition-transform duration-200">
                <img src="{{ asset('images/app-screenshots/screenshot-2.png') }}" alt="Screenshot 2" class="w-full h-auto">
            </div>
            <div class="rounded-xl overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-700  hover:scale-150 transition-transform duration-200">
                <img src="{{ asset('images/app-screenshots/screenshot-3.png') }}" alt="Screenshot 3" class="w-full h-auto">
            </div>
            <div class="rounded-xl overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-700  hover:scale-150 transition-transform duration-200">
                <img src="{{ asset('images/app-screenshots/screenshot-4.png') }}" alt="Screenshot 4" class="w-full h-auto">
            </div>
            <div class="rounded-xl overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-700  hover:scale-150 transition-transform duration-200">
                <img src="{{ asset('images/app-screenshots/screenshot-5.png') }}" alt="Screenshot 5" class="w-full h-auto">
            </div>
            <div class="rounded-xl overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-700  hover:scale-150 transition-transform duration-200">
                <img src="{{ asset('images/app-screenshots/screenshot-6.png') }}" alt="Screenshot 6" class="w-full h-auto">
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gray-50 dark:bg-neutral-950">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                {{ __("User reviews") }}
            </h2>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                {{ __("Here's what our users say about the app") }}:
            </p>

            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="rounded-2xl bg-white dark:bg-neutral-900 p-6 shadow-md">
                    <p class="text-gray-700 dark:text-gray-300">
                        “{{ __("Thanks to this app, I don't forget anything anymore. It's very convenient to share with friends.") }}”
                    </p>
                    <div class="mt-4 flex items-center gap-4">
                        <img src="https://i.pravatar.cc/60?img=1" alt="User" class="h-12 w-12 rounded-full object-cover">
                        <div class="text-left">
                            <p class="font-semibold text-gray-900 dark:text-white">Andriy K.</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("Freelancer") }}</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="rounded-2xl bg-white dark:bg-neutral-900 p-6 shadow-md">
                    <p class="text-gray-700 dark:text-gray-300">
                        “{{ __("I like that you can comment and like. It adds an element of socialization. I love this ❤️") }}”
                    </p>
                    <div class="mt-4 flex items-center gap-4">
                        <img src="https://i.pravatar.cc/60?img=2" alt="User" class="h-12 w-12 rounded-full object-cover">
                        <div class="text-left">
                            <p class="font-semibold text-gray-900 dark:text-white">Oksana P.</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("Student") }}</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="rounded-2xl bg-white dark:bg-neutral-900 p-6 shadow-md">
                    <p class="text-gray-700 dark:text-gray-300">
                        “{{ __("The design is simple and convenient. Registration is quick, and the features are really useful in everyday life.") }}”
                    </p>
                    <div class="mt-4 flex items-center gap-4">
                        <img src="https://i.pravatar.cc/60?img=3" alt="User" class="h-12 w-12 rounded-full object-cover">
                        <div class="text-left">
                            <p class="font-semibold text-gray-900 dark:text-white">Igor L.</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("Manager") }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feedback -->
    <section class="max-w-6xl mx-auto py-16 px-6">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">{{ __("Do you have any questions? Write to us!") }}</h2>
        <div class="max-w-2xl mx-auto bg-white dark:bg-neutral-900 p-8 rounded-lg shadow">
            <livewire:contact-form />
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-6 text-center text-gray-500 dark:text-gray-400">
        © {{ date('Y') }} {{ config('app.name', 'MyApp') }}. All rights reserved.
    </footer>

</body>
</html>
