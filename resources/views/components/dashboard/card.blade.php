@props([
    'title' => null,
    'icon' => null,
])

<div {{ $attributes->merge([
    'class' => 'group relative rounded-2xl p-5 shadow-lg
                bg-gradient-to-br from-neutral-100 to-neutral-200
                dark:from-neutral-800 dark:to-neutral-700
                border border-gray-200 dark:border-gray-700
                transition transform hover:-translate-y-1 hover:shadow-xl'
]) }}>
    @if ($title || $icon)
        <div class="flex items-center justify-between my-4">
            @if ($title)
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                    {{ $title }}
                </h3>
            @endif

            @if ($icon)
                <div class="flex items-center justify-center w-10 h-10
                            rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600
                            text-white shadow-md group-hover:scale-110 transition">
                    {!! $icon !!}
                </div>
            @endif
        </div>
    @endif

    <div class="mb-4 text-gray-700 dark:text-gray-300 text-base leading-relaxed">
        {{ $slot }}
    </div>

    <x-film-strip-effect />

</div>
