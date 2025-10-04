<div class="flex flex-col gap-6">
    <x-auth-header :title="__('register.header.title')" :description="__('register.header.description')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('register.form.name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('register.form.fullname')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('register.form.email')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('register.form.password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('register.form.password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('register.form.confirm_password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('register.form.confirm_password')"
            viewable
        />

        <div class="flex items-center">
            <x-cinema-button
                type="submit"
                class="grow"
                :glow="true"
                palette="purple"
            >
                 {{ __('register.form.create') }}
            </x-cinema-button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('register.form.already_have_account') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('register.form.login') }}</flux:link>
    </div>
</div>
