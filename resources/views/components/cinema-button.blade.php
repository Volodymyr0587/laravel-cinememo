@props([
    'href' => null,          // if set, renders <a>
    'size' => 'md',          // sm | md | lg | xl
    'palette' => 'gold',     // gold | red | silver | neon
    'glow' => false,         // add glowing shadow
])

@php
    $baseClasses = "
        relative inline-flex items-center justify-center
        font-bold rounded-2xl transition-all duration-300 ease-out
        transform hover:scale-105 hover:-rotate-1 shadow-lg overflow-hidden group
    ";

    $sizeClasses = match($size) {
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-10 py-6 text-2xl',
        'xl' => 'px-12 py-8 text-3xl',
        default => 'px-6 py-3 text-base',
    };

    $paletteClasses = match($palette) {
        'gold' => 'bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 text-black dark:text-white',
        'red' => 'bg-gradient-to-r from-red-600 via-red-700 to-red-800 text-white',
        'silver' => 'bg-gradient-to-r from-gray-300 via-gray-400 to-gray-500 text-black dark:text-white',
        'neon' => 'bg-gradient-to-r from-pink-500 via-fuchsia-600 to-purple-700 text-white',
        default => 'bg-gradient-to-r from-gray-600 to-gray-800 text-white',
    };

    $glowClasses = $glow
        ? 'shadow-[0_0_20px_rgba(255,215,0,0.7)] dark:shadow-[0_0_25px_rgba(255,215,0,1)]'
        : '';

    // spotlight sweep effect
    $sweep = "
        relative overflow-hidden
        after:absolute after:inset-0
        after:-translate-x-full after:bg-gradient-to-r after:from-transparent
        after:via-white/20 dark:after:via-white/10 after:to-transparent
        after:skew-x-12 after:transition-transform after:duration-700
        group-hover:after:translate-x-full
    ";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge([
        'class' => "$baseClasses $sizeClasses $paletteClasses $glowClasses $sweep"
    ]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge([
        'class' => "$baseClasses $sizeClasses $paletteClasses $glowClasses $sweep"
    ]) }}>
        {{ $slot }}
    </button>
@endif
