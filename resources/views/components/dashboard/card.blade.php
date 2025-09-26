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

    <!-- Film strip / movie tape effect -->
    <!-- Top -->
    <div class="absolute top-0 left-0 right-0 h-6
            bg-gradient-to-r from-red-600 via-purple-600 to-pink-600
            rounded-t-2xl flex items-center justify-around px-2 overflow-hidden">

        @for ($i = 0; $i < 12; $i++)
            <div class="w-3 h-2 bg-neutral-100/80 dark:bg-neutral-900/70 rounded-sm"></div>
        @endfor
    </div>
    <!-- End Top -->
    <!-- Bottom -->
    <div class="absolute bottom-0 left-0 right-0 h-6
            bg-gradient-to-r from-red-600 via-purple-600 to-pink-600
            rounded-b-2xl flex items-center justify-around px-2 overflow-hidden">

        @for ($i = 0; $i < 12; $i++)
            <div class="w-3 h-2 bg-neutral-100/80 dark:bg-neutral-900/70 rounded-sm"></div>
        @endfor
    </div>
    <!-- End Bottom -->
    <!-- End film strip / movie tape effect -->


</div>
