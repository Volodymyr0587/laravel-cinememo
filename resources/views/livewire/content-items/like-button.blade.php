<div>
    <flux:button
        wire:click="toggleLike"
        class="flex items-center gap-1 hover:cursor-pointer transition-colors duration-200"
    >
        <div class="flex items-center gap-x-2">
            <flux:icon.heart
                variant="{{ $isLiked ? 'solid' : 'outline' }}"
                class="w-5 h-5 {{ $isLiked ? 'text-red-500 font-bold' : 'text-gray-500 hover:text-red-400' }}"
            />

            <span>{{ $likesCount }}</span>
        </div>
    </flux:button>
</div>
