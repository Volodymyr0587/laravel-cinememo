@props([
    'href' => null,
    'type' => 'button',
    'color' => 'green', // default color
])

@php
    $baseClasses = 'relative inline-flex items-center justify-center rounded-md px-5 py-2 font-semibold transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 hover:cursor-pointer';

    $colorStyles = [
        'green' => [
            'bg' => 'bg-green-500 hover:bg-green-600',
            'dark' => 'dark:bg-green-600 dark:hover:bg-green-500',
            'ring' => 'focus:ring-green-400 dark:focus:ring-green-500',
            'glow' => 'before:bg-green-400/50',
        ],
        'red' => [
            'bg' => 'bg-red-500 hover:bg-red-600',
            'dark' => 'dark:bg-red-600 dark:hover:bg-red-500',
            'ring' => 'focus:ring-red-400 dark:focus:ring-red-500',
            'glow' => 'before:bg-red-400/50',
        ],
        'blue' => [
            'bg' => 'bg-blue-500 hover:bg-blue-600',
            'dark' => 'dark:bg-blue-600 dark:hover:bg-blue-500',
            'ring' => 'focus:ring-blue-400 dark:focus:ring-blue-500',
            'glow' => 'before:bg-blue-400/50',
        ],
        // Add more colors if needed
    ];

    $styles = $colorStyles[$color] ?? $colorStyles['green'];

    $glowEffect = "hover:before:opacity-100 before:transition before:duration-300 before:absolute before:inset-0 before:-z-10 before:rounded-3xl before:blur-xl before:opacity-0 {$styles['glow']}";
@endphp

@if ($href)
    <a {{ $attributes->merge([
        'href' => $href,
        'class' => "$baseClasses {$styles['bg']} text-white {$styles['dark']} {$styles['ring']} $glowEffect",
    ]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge([
        'type' => $type,
        'class' => "$baseClasses {$styles['bg']} text-white {$styles['dark']} {$styles['ring']} $glowEffect",
    ]) }}>
        {{ $slot }}
    </button>
@endif
