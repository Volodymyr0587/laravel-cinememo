<div>
    <div class="mb-4">
        <flux:textarea wire:model.defer="body" :label="__('content_items/show.lets_discuss')" id="body" rows="4"></flux:textarea>
        <div class="flex items-center justify-between mt-2">

                <span
                    class="flex items-center gap-x-2 text-sm text-gray-500 focus:outline-hidden dark:text-neutral-400">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z" />
                    </svg>
                    {{ $count }}
                </span>

        <flux:button class="mt-2 hover:cursor-pointer" wire:click="postComment" variant="primary" type="submit">
            {{__('content_items/show.add_comment') }}
        </flux:button>
        </div>
    </div>
    @foreach($comments as $comment)
    <div class="border-b py-3">
        <div class="flex justify-between items-start">
            <div class="flex items-center gap-3">
                @if ($comment->user->profile_image)
                <flux:avatar src="{{ Storage::url($comment->user->profile_image) }}" />
                @else
                <flux:avatar name="{{ $comment->user->name }}" initials:single />
                @endif

                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                        {{ $comment->user->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $comment->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>

            @can('delete', $comment)
            <flux:button wire:click="deleteComment({{ $comment->id }})"
                wire:confirm="Are you sure you want to delete this comment?"
                square icon="trash" class="hover:cursor-pointer" />
            @endcan
        </div>

        <div class="mt-2 ml-11 text-sm text-gray-800 dark:text-gray-200 leading-relaxed">
            {{ $comment->body }}
        </div>
    </div>
    @endforeach
</div>
