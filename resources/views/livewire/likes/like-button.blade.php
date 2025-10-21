<div>
    <button
        wire:click="toggleLike"
        {{ $canLike ? '' : 'disabled' }}
        class="flex items-center gap-1 transition-colors duration-200 text-sm
               {{ $canLike ? 'hover:cursor-pointer' : 'opacity-50 cursor-not-allowed' }}"
    >
        <div class="flex items-center gap-x-2">
            <flux:icon.heart
                variant="{{ $isLiked ? 'solid' : 'outline' }}"
                class="w-5 h-5 {{ $isLiked ? 'text-red-500 font-bold' : 'text-black dark:text-white' }}"
            />

            <span class="font-bold text-black dark:text-white">{{ $likesCount }}</span>
        </div>
    </button>
</div>


