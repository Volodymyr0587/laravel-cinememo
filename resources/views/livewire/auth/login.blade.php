<div class="flex flex-col gap-6">
    <x-auth-header :title="__('login.header.title')" :description="__('login.header.description')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('login.form.email')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('login.form.password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('login.form.password')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('login.form.forgot_password') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('login.form.remember')" />

        <div class="flex items-center justify-end">
             <x-cinema-button
                type="submit"
                class="grow"
                :glow="true"
                palette="purple"
            >
                 {{ __('login.form.login') }}
            </x-cinema-button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('login.form.dont_have_account') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('login.form.signup') }}</flux:link>
        </div>
    @endif
</div>
