<div x-data="{ open: false }" {{ $attributes->merge(['class' => 'relative inline-block text-left']) }}>
    {{-- Кнопка dropdown --}}
    <button @click="open = !open"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-md bg-gray-100 dark:bg-zinc-900
                   hover:bg-gray-200 hover:cursor-pointer dark:hover:bg-zinc-800 transition focus:outline-none focus:ring-2 focus:ring-cyan-400">

        <x-icon name="flag-language-{{ app()->getLocale() }}" class="w-5 h-5" />

        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- Меню --}}
    <div x-show="open"
         @click.away="open = false"
         x-transition
         style="display: none"
         class="absolute right-0 mt-2 w-40 bg-white dark:bg-zinc-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
        <a href="{{ route('locale.switch', 'en') }}" wire:navigate
           class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-zinc-700
                  {{ app()->getLocale() === 'en' ? 'bg-cyan-500 text-white shadow-[0_0_10px_rgba(34,211,238,0.8)]' : '' }}">
            <x-flag-language-en class="w-5 h-5" /> English
        </a>
        <a href="{{ route('locale.switch', 'uk') }}" wire:navigate
           class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-zinc-700
                  {{ app()->getLocale() === 'uk' ? 'bg-cyan-500 text-white shadow-[0_0_10px_rgba(34,211,238,0.8)]' : '' }}">
            <x-flag-language-uk class="w-5 h-5" /> Українська
        </a>
    </div>
</div>
