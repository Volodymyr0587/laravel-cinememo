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
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 shadow-lg">
                            Sign up
                        </a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <!-- Hero -->
    <section class="text-center py-20 px-6">
        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
            Organize your content, <br class="hidden md:block"> save your ideas, stay productive
        </h1>
        <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300 mb-8">
            {{ config('app.name', 'MyApp') }} — це застосунок для збереження нотаток, фільмів, статей та всього, що важливо.
            В одному місці. У будь-який час.
        </p>
        <a href="{{ route('register') }}"
           class="px-6 py-3 rounded-xl bg-blue-600 text-white text-lg font-semibold shadow-lg hover:bg-blue-700 transition">
            Почати безкоштовно
        </a>
    </section>

    <!-- Features -->
    <section class="max-w-6xl mx-auto py-16 px-6 grid md:grid-cols-3 gap-10">
        <div class="p-6 rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">📚 Організуй все</h3>
            <p class="text-gray-600 dark:text-gray-300">
                Категорії, теги та фільтри допоможуть швидко знайти потрібне.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">💬 Спілкуйся та взаємодій</h3>
            <p class="text-gray-600 dark:text-gray-300">
                Можливість коментувати та ставити вподобайки контенту інших користувачів.
            </p>
        </div>
        <div class="p-6 rounded-2xl bg-gray-100 dark:bg-gray-800 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">📱 Завжди поруч</h3>
            <p class="text-gray-600 dark:text-gray-300">
                Використовуй застосунок на смартфоні, планшеті чи комп’ютері.
            </p>
        </div>
    </section>

    <!-- Screenshots -->
    <section class="max-w-6xl mx-auto py-16 px-6">
        <h2 class="text-3xl font-bold text-center mb-10">Приклади інтерфейсу</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="rounded-xl overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-700">
                <img src="{{ asset('images/app-screenshots/screenshot-1.png') }}" alt="Screenshot 1" class="w-full h-auto">
            </div>
            <div class="rounded-xl overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-700">
                <img src="{{ asset('images/app-screenshots/screenshot-2.png') }}" alt="Screenshot 2" class="w-full h-auto">
            </div>
            <div class="rounded-xl overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-700">
                <img src="{{ asset('images/app-screenshots/screenshot-3.png') }}" alt="Screenshot 3" class="w-full h-auto">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-6 text-center text-gray-500 dark:text-gray-400">
        © {{ date('Y') }} {{ config('app.name', 'MyApp') }}. All rights reserved.
    </footer>

</body>
</html>
