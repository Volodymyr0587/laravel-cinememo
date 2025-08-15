<div>
    <div class="mb-4">
        <flux:textarea wire:model.defer="body"  :label="__('Let\'s discuss')" id="body" rows="4"></flux:textarea>
        <flux:button class="mt-2" wire:click="postComment" variant="primary" type="submit" >{{ __('Add Comment') }}</flux:button>
    </div>

    @foreach($comments as $comment)
        <div class="border-b py-2 flex justify-between items-start">
            <div>
                <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-cyan-400 text-white">{{ $comment->user->name }}</span>
                {{ $comment->body }}
            </div>

            @can('delete', $comment)
                <button wire:click="deleteComment({{ $comment->id }})" wire:confirm="Are you sure you want to delete this comment?"
                        class="text-red-500 text-sm hover:underline ml-2 hover:cursor-pointer">
                    {{ __('Delete') }}
                </button>
            @endcan
        </div>
    @endforeach
</div>

