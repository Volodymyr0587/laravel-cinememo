<div {{ $attributes }} class="flex gap-2 mr-4">
    {{-- English --}}
    <a href="{{ route('locale.switch', 'en') }}"
        class="p-1 rounded transition
            {{ app()->getLocale() === 'en'
                    ? 'bg-cyan-500 ring-2 ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.8)]'
                    : 'hover:bg-gray-200 dark:hover:bg-zinc-600' }}">
        <x-flag-language-en  class="w-8 h-8" />
    </a>

    {{-- Ukrainian --}}
    <a href="{{ route('locale.switch', 'uk') }}"
    class="p-1 rounded transition
            {{ app()->getLocale() === 'uk'
                    ? 'bg-cyan-500 ring-2 ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.8)]'
                    : 'hover:bg-gray-200 dark:hover:bg-zinc-800' }}">
         <x-flag-language-uk  class="w-8 h-8" />
    </a>

    {{ $slot}}
</div>
