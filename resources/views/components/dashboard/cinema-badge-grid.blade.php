@props(['levels'])

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 my-4">
    @foreach($levels as $level)
        <div
            class="flex flex-col items-center p-4 rounded-xl shadow relative
                {{ $level['unlocked']
                    ? 'bg-gradient-to-r from-green-400 to-emerald-500 text-white'
                    : 'bg-gradient-to-br from-neutral-100 to-neutral-200
                dark:from-neutral-800 dark:to-neutral-700' }}
                {{ $level['current'] ? 'ring-4 ring-yellow-400 scale-105 transition' : '' }}"
        >
            <div class="text-3xl mb-2">
                {{ $level['unlocked'] ? $level['badge'] : '🔒' }}
            </div>
            <p class="font-semibold">{{ $level['label'] }}</p>
            <p class="text-xs opacity-75">from {{ $level['min'] }} items in collection</p>
        </div>
    @endforeach
</div>
