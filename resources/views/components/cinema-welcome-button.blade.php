@props([
    'href' => null, // If set, render <a>, otherwise <button>
])

@php
    $baseClasses = "
        relative inline-block px-10 py-10 rounded-2xl
        text-2xl font-bold text-neon-gold
        bg-gradient-to-r from-black via-gray-800 to-gray-900
        shadow-lg hover:shadow-2xl
        transform hover:scale-105 hover:-rotate-1
        transition duration-300 ease-out
        glow-effect overflow-hidden group
    ";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses]) }} wire:navigate>
        {{ $slot }}
        <x-spotlight-sweep-hover />
        <x-film-strip-effect />
    </a>
@else
    <button {{ $attributes->merge(['class' => $baseClasses]) }}>
        {{ $slot }}
        <x-spotlight-sweep-hover />
        <x-film-strip-effect />
    </button>
@endif

