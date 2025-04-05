<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <div class="flex flex-col items-center mx-4">

        <x-heading>
            {{"Login"}}
        </x-heading>

        <form method="POST" action="{{ route('login') }}" class="mt-4" style="width:100%">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="name" :value="__('Email/Username')"/>
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                              autocomplete="name" style="width:100%"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')"/>

                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="current-password" style="width:100%"/>

                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <x-input-error :messages="session()->get('no_role')" class="mt-2"/>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4" style="width:100%">

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <div class="flex mt-4 justify-end items-center">
                <p class="text-sm text-gray-600">Don't have an account , </p>
                <a href="{{ route('register') }}" class="font-semibold" style="color: #0ea5e9">
                    {{ __('Register') }}
                </a>
            </div>
        </form>
    </div>

</x-guest-layout>
