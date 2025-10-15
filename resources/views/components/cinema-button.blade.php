@props([
    'href' => null,          // if set, renders <a>
    'size' => 'md',          // sm | md | lg | xl
    'palette' => 'gold',     // gold | red | silver | neon
    'glow' => false,         // add glowing shadow
    'disabled' => false,
])

@php
    $baseClasses = "
        relative inline-flex items-center justify-center cursor-pointer
        font-bold rounded-lg transition-all duration-300 ease-out
        transform hover:scale-105 hover:-rotate-1 shadow-lg overflow-hidden group
    ";

    $sizeClasses = match($size) {
        'sm' => 'px-2 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
        'xl' => 'px-8 py-4 text-xl',
        default => 'px-4 py-2 text-base',
    };

    $paletteClasses = match($palette) {
        'gold' => 'bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 text-black dark:text-white',
        'red' => 'bg-gradient-to-r from-red-600 via-red-700 to-red-800 text-white',
        'silver' => 'bg-gradient-to-r from-gray-300 via-gray-400 to-gray-500 text-black dark:text-white',
        'neon' => 'bg-gradient-to-r from-pink-500 via-fuchsia-600 to-purple-700 text-white',
        'blue' => 'bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 text-white',
        'purple' => 'bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 text-white',
        'white' => 'bg-gradient-to-r from-white via-gray-100 to-gray-200 text-black',
        'black' => 'bg-gradient-to-r from-gray-800 via-gray-900 to-black text-white',
        'green'  => 'bg-gradient-to-r from-green-500 via-green-600 to-green-700 text-white',
        'orange' => 'bg-gradient-to-r from-orange-500 via-orange-600 to-orange-700 text-white',
        default => 'bg-gradient-to-r from-gray-600 to-gray-800 text-white',
    };

    $glowClasses = $glow
        ? match($palette) {
            'gold' => 'shadow-[0_0_20px_rgba(255,215,0,0.7)] dark:shadow-[0_0_25px_rgba(255,215,0,1)]',
            'red' => 'shadow-[0_0_20px_rgba(220,38,38,0.7)] dark:shadow-[0_0_25px_rgba(220,38,38,1)]',
            'silver' => 'shadow-[0_0_20px_rgba(156,163,175,0.7)] dark:shadow-[0_0_25px_rgba(156,163,175,1)]',
            'neon' => 'shadow-[0_0_20px_rgba(236,72,153,0.7)] dark:shadow-[0_0_25px_rgba(236,72,153,1)]',
            'blue'   => 'shadow-[0_0_20px_rgba(37,99,235,0.7)] dark:shadow-[0_0_25px_rgba(37,99,235,1)]',
            'purple' => 'shadow-[0_0_20px_rgba(139,92,246,0.7)] dark:shadow-[0_0_25px_rgba(139,92,246,1)]',
            'white'  => 'shadow-[0_0_20px_rgba(255,255,255,0.6)] dark:shadow-[0_0_25px_rgba(255,255,255,0.9)]',
            'black'  => 'shadow-[0_0_20px_rgba(0,0,0,0.7)] dark:shadow-[0_0_25px_rgba(0,0,0,1)]',
            'green'  => 'shadow-[0_0_20px_rgba(34,197,94,0.7)] dark:shadow-[0_0_25px_rgba(34,197,94,1)]',
            'orange' => 'shadow-[0_0_20px_rgba(249,115,22,0.7)] dark:shadow-[0_0_25px_rgba(249,115,22,1)]',
            default => 'shadow-[0_0_20px_rgba(255,255,255,0.5)] dark:shadow-[0_0_25px_rgba(255,255,255,0.8)]',
        }
    : '';

    $disabledClasses = $disabled
        ? 'opacity-60 cursor-not-allowed transform-none hover:cursor-not-allowed hover:scale-100 hover:-rotate-0'
        : '';



    $sweepColor = match($palette) {
        'gold' => 'after:via-yellow-200/50 dark:after:via-yellow-300/40',
        'red' => 'after:via-red-200/50 dark:after:via-red-300/40',
        'silver' => 'after:via-gray-100/50 dark:after:via-gray-200/40',
        'neon' => 'after:via-pink-200/50 dark:after:via-pink-300/40',
        'blue'   => 'after:via-blue-200/50 dark:after:via-blue-300/40',
        'purple' => 'after:via-purple-200/50 dark:after:via-purple-300/40',
        'white'  => 'after:via-gray-200/60 dark:after:via-gray-300/40',
        'black'  => 'after:via-gray-700/60 dark:after:via-gray-800/50',
        'green'  => 'after:via-green-200/50 dark:after:via-green-300/40',
        'orange' => 'after:via-orange-200/50 dark:after:via-orange-300/40',
        default => 'after:via-white/40 dark:after:via-white/30',
    };

    $sweep = "
        after:absolute after:inset-0 after:z-10
        after:-translate-x-full after:bg-gradient-to-r after:from-transparent
        $sweepColor after:to-transparent
        after:skew-x-12 after:transition-transform after:duration-500
        hover:after:translate-x-full
    ";
@endphp

@if($href)
    <a href="{{ $disabled ? '#' : $href }}" {{ $attributes->merge([
        'class' => "$baseClasses $sizeClasses $paletteClasses $glowClasses $sweep $disabledClasses"
    ]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge([
        'class' => "$baseClasses $sizeClasses $paletteClasses $glowClasses $sweep $disabledClasses"
    ]) }} @if($disabled) disabled @endif>
        {{ $slot }}
    </button>
@endif
