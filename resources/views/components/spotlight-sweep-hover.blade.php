@php
    $baseClasses = "absolute inset-0 -translate-x-full
                    bg-gradient-to-r from-transparent via-white/20 to-transparent
                    skew-x-12 transition-transform duration-700
                    group-hover:translate-x-full"
@endphp

<span {{ $attributes->merge(['class' => $baseClasses]) }} ></span>
