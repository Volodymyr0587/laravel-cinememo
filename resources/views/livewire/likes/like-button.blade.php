<div>
    <button
        wire:click="toggleLike"
        {{ $canLike ? '' : 'disabled' }}
        class="group relative inline-flex items-center gap-2 px-3 py-1.5 rounded-lg
               transition-all duration-300 ease-out text-sm font-medium
               {{ $canLike
                   ? 'bg-gradient-to-br from-amber-100 via-yellow-100 to-amber-100 dark:from-amber-950/50 dark:via-yellow-950/50 dark:to-amber-950/50
                      hover:from-amber-200 hover:via-yellow-200 hover:to-amber-200 dark:hover:from-amber-900/60 dark:hover:via-yellow-900/60 dark:hover:to-amber-900/60
                      hover:shadow-lg hover:shadow-amber-300/50 dark:hover:shadow-amber-600/40
                      hover:cursor-pointer hover:-translate-y-0.5
                      active:translate-y-0 active:shadow-sm
                      border border-amber-300/70 dark:border-amber-700/60 hover:border-amber-400/90 dark:hover:border-amber-600/80'
                   : 'opacity-50 cursor-not-allowed bg-gray-100 dark:bg-gray-800/50'
               }}"
    >
        <!-- Glow effect on hover -->
        <div class="absolute inset-0 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300
                   {{ $canLike ? 'bg-gradient-to-br from-amber-400/20 via-yellow-400/20 to-amber-400/20 blur-md' : '' }}"></div>

        <!-- Content -->
        <div class="relative flex items-center gap-x-2 z-10">
            <x-svg.star-icon
                :isLiked="$isLiked"
                class="{{ $isLiked ? 'text-amber-500 scale-110 drop-shadow-lg drop-shadow-amber-500/60' : 'text-gray-600 dark:text-gray-400 group-hover:text-amber-500 dark:group-hover:text-amber-400' }}"
            />

            <span class="transition-all duration-300
                        {{ $isLiked
                            ? 'text-amber-600 dark:text-amber-400 font-bold'
                            : 'text-gray-700 dark:text-gray-300 group-hover:text-amber-600 dark:group-hover:text-amber-400'
                        }}">
                {{ $likesCount }}
            </span>
        </div>
    </button>
</div>
