<div {{ $attributes }}>
    {{ $slot}}
</div>

<div {{ $attributes }} class="flex gap-2 mr-4">
    {{-- English --}}
    <a href="{{ route('locale.switch', 'en') }}"
        class="p-1 rounded transition
            {{ app()->getLocale() === 'en'
                    ? 'bg-cyan-500 ring-2 ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.8)]'
                    : 'hover:bg-gray-200 dark:hover:bg-zinc-600' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 32 32">
            <rect x="1" y="4" width="30" height="24" rx="4" ry="4" fill="#071b65"></rect>
            <path d="M5.101,4h-.101c-1.981,0-3.615,1.444-3.933,3.334L26.899,28h.101c1.981,0,3.615-1.444,3.933-3.334L5.101,4Z" fill="#fff"></path>
            <path d="M22.25,19h-2.5l9.934,7.947c.387-.353,.704-.777,.929-1.257l-8.363-6.691Z" fill="#b92932"></path>
            <path d="M1.387,6.309l8.363,6.691h2.5L2.316,5.053c-.387,.353-.704,.777-.929,1.257Z" fill="#b92932"></path>
            <path d="M5,28h.101L30.933,7.334c-.318-1.891-1.952-3.334-3.933-3.334h-.101L1.067,24.666c.318,1.891,1.952,3.334,3.933,3.334Z" fill="#fff"></path>
            <rect x="13" y="4" width="6" height="24" fill="#fff"></rect>
            <rect x="1" y="13" width="30" height="6" fill="#fff"></rect>
            <rect x="14" y="4" width="4" height="24" fill="#b92932"></rect>
            <rect x="14" y="1" width="4" height="30" transform="translate(32) rotate(90)" fill="#b92932"></rect>
            <path d="M28.222,4.21l-9.222,7.376v1.414h.75l9.943-7.94c-.419-.384-.918-.671-1.471-.85Z" fill="#b92932"></path>
            <path d="M2.328,26.957c.414,.374,.904,.656,1.447,.832l9.225-7.38v-1.408h-.75L2.328,26.957Z" fill="#b92932"></path>
        </svg>
    </a>

    {{-- Ukrainian --}}
    <a href="{{ route('locale.switch', 'uk') }}"
    class="p-1 rounded transition
            {{ app()->getLocale() === 'uk'
                    ? 'bg-cyan-500 ring-2 ring-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.8)]'
                    : 'hover:bg-gray-200 dark:hover:bg-zinc-800' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 32 32">
            <path d="M31,8c0-2.209-1.791-4-4-4H5c-2.209,0-4,1.791-4,4v9H31V8Z" fill="#2455b2"></path>
            <path d="M5,28H27c2.209,0,4-1.791,4-4v-8H1v8c0,2.209,1.791,4,4,4Z" fill="#f9da49"></path>
        </svg>
    </a>

    {{ $slot}}
</div>
