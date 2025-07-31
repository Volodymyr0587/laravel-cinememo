@props([
    'title' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-2xl p-4 shadow-md bg-neutral-200  dark:bg-neutral-700 border border-gray-200 dark:border-gray-700 transition']) }}>
    @if ($title || $icon)
        <div class="flex items-center justify-between mb-2">
            @if ($title)
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $title }}</h3>
            @endif
            @if ($icon)
                <div class="text-gray-400 dark:text-gray-500">
                    {!! $icon !!}
                </div>
            @endif
        </div>
    @endif

    <div class="text-gray-700 dark:text-gray-300 text-sm">
        {{ $slot }}
    </div>
</div>
