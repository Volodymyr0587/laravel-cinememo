<div>
    <x-flash-message />
    <form wire:submit.prevent="send" class="space-y-6">
        <div>
            <label for="name" class="block text-sm mb-2 font-medium text-gray-700 dark:text-gray-200">{{ __("welcome.feedback.form.name") }}</label>
            <flux:input type="text" id="name" wire:model.defer="name" required />
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm mb-2 font-medium text-gray-700 dark:text-gray-200">{{ __("welcome.feedback.form.email") }}</label>
            <flux:input type="email" id="email" wire:model.defer="email" required />
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="message" class="block text-sm mb-2 font-medium text-gray-700 dark:text-gray-200">{{ __("welcome.feedback.form.message") }}</label>
            <flux:textarea id="message" wire:model.defer="message" rows="4" required />
            @error('message') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end">
            <x-cinema-button
            type="submit"
            :glow="true"
            palette="purple"
        >
            {{ __("welcome.buttons.send") }}
        </x-cinema-button>
        </div>


        @if (session('success'))
            <div class="mt-4 p-3 rounded bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif
    </form>
</div>


