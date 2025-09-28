@props([
    'src' => '',
    'alt' => '',
    'label' => '',
    'gradientFrom' => 'red-600/20',
    'gradientTo' => 'purple-600/20',
    'class' => ''
])

<div {{ $attributes->merge(['class' => 'group relative overflow-hidden rounded-2xl shadow-2xl transform hover:scale-105 transition-all duration-500 floating-animation glow-effect ' . $class]) }}>
    <div class="absolute inset-0 bg-gradient-to-br from-{{ $gradientFrom }} to-{{ $gradientTo }} z-10"></div>
    <img src="{{ $src }}" alt="{{ $alt }}" class="w-full h-full object-cover">

    @if($label)
        <div class="absolute bottom-4 left-4 text-white z-20">
            <div class="bg-black/50 backdrop-blur-sm rounded-lg px-3 py-2">
                <span class="text-sm font-semibold">{{ $label }}</span>
            </div>
        </div>
    @endif

    <x-film-strip-effect />
</div>
