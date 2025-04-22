<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-gray-300" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}"
        class="bg-transparent backdrop-blur-md text-white p-8 sm:p-10 rounded-2xl shadow-2xl border border-white/10 max-w-md w-full mx-auto">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
            <x-text-input
                id="email"
                class="block mt-2 w-full bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg focus:ring focus:ring-white focus:outline-none"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="you@example.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
            <x-text-input
                id="password"
                class="block mt-2 w-full bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg focus:ring focus:ring-white focus:outline-none"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded bg-gray-900 border-gray-600 text-white shadow-sm focus:ring-white"
                    name="remember">
                <span class="ml-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Links -->
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a
                    class="underline text-sm text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <a
                class="underline text-sm text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white"
                href="{{ route('register') }}">
                {{ __("Don't have an account yet? Register") }}
            </a>
        </div>

        <!-- Login Button -->
        <div class="mt-6">
            <x-primary-button
                class="w-full bg-white hover:bg-gray-200 text-black py-3 rounded-lg shadow-lg transition flex items-center justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
