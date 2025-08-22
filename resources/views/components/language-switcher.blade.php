<div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
    {{-- English --}}
    <a href="{{ route('locale.switch', 'en') }}"
       class="p-1 rounded transition
              {{ app()->getLocale() === 'en'
                    ? 'bg-cyan-500 ring-2 ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.8)]'
                    : 'hover:bg-gray-200 dark:hover:bg-zinc-600' }}">
        <x-flag-language-en class="w-6 h-6" />
    </a>

    {{-- Ukrainian --}}
    <a href="{{ route('locale.switch', 'uk') }}"
       class="p-1 rounded transition
              {{ app()->getLocale() === 'uk'
                    ? 'bg-cyan-500 ring-2 ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.8)]'
                    : 'hover:bg-gray-200 dark:hover:bg-zinc-600' }}">
        <x-flag-language-uk class="w-6 h-6" />
    </a>

    {{ $slot }}
</div>
