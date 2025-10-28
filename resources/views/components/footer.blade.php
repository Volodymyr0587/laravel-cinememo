<footer {{ $attributes->merge([
        'class' => "bg-black/90 border-t border-gray-800 text-gray-400",
    ]) }}>
    <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col sm:flex-row items-center justify-between gap-6">
        <!-- Logo / App name -->
        <div class="flex items-center space-x-2">
            <x-app-logo />
            {{-- <span class="text-lg font-semibold text-gray-200 tracking-wide">CineMemo</span> --}}
        </div>

        <!-- Navigation links -->
        <nav class="flex space-x-6 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-yellow-400 transition-colors">Home</a>

            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate class="hover:text-yellow-400 transition-colors">
                        {{ __("welcome.buttons.dashboard") }}
                    </a>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="hover:text-yellow-400 transition-colors">
                        {{ __("welcome.buttons.login") }}
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" wire:navigate class="hover:text-yellow-400 transition-colors">
                            {{ __("welcome.buttons.signup") }}
                        </a>
                    @endif
                @endauth
            @endif
        </nav>

        <!-- Social icons -->
        <div class="flex space-x-4">
            <a href="#" aria-label="X">
                <x-svg.x />
            </a>
            <a href="https://github.com/Volodymyr0587" target="_blank" aria-label="GitHub">
                <x-svg.github class="" />
            </a>
            <a href="#" aria-label="YouTube">
                <x-svg.youtube />
            </a>
        </div>
    </div>
    <div class="border-t border-gray-800 mt-4">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-xs text-gray-500">
            © {{ now()->year }} {{ config('app.name', 'MyApp') }}. {{ __("welcome.rights") }}.
        </div>
    </div>
</footer>
