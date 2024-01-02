<div class="flex h-screen w-full">
    <div class="lg:flex items-center justify-center flex-1">
        <div class="max-w-md text-center">
            <x-draw.login />
        </div>
    </div>

    <div class="w-full bg-gray-100 lg:w-1/2 flex items-center justify-center">
        <div class="max-w-md w-full p-6">
            <h1 class="text-3xl font-semibold mb-6 text-black text-center">Welcome to your CRM</h1>
            @if($message = session()->get('status'))--}}
                    <x-alert icon="o-exclamation-triangle" class="alert-error mb-4">
                        {{ $message }}
                    </x-alert>
                @endif

                @if($errors->hasAny(['invalidCredentials', 'rateLimiter']))
                    <x-alert icon="o-exclamation-triangle" class="alert-warning mb-4">
                        @error('invalidCredentials')
                        <span> {{ $message }} </span>
                        @enderror

                        @error('rateLimiter')
                        <span> {{ $message }} </span>
                        @enderror
                    </x-alert>
                @endif
            <x-form wire:submit="tryToLogin" class="space-y-4">
                <div>
                    <x-input
                        label="Email"
                        wire:model="email"
                        class="mt-1 p-2 w-full border rounded-md focus:border-gray-200
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors
                        duration-300"
                    />
                </div>
                <div>
                    <x-input
                        label="Password"
                        wire:model="password"
                        type="password"
                        class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2
                        focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300"
                    />
                </div>
                <a
                    href="{{ route('password.recovery') }}"
                    class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500"
                >
                    Forgot password?
                </a>
                <div>
                    <x-button
                        type="submit"
                        class="w-full bg-black text-white p-2 rounded-md hover:bg-gray-800 focus:outline-none
                        focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900
                        transition-colors duration-300"
                        spinner="submit"
                    >
                        Login
                    </x-button>
                </div>
            </x-form>
            <div class="mt-4 text-sm text-gray-600 text-center">
                <p>
                    Don't have an account?
                    <a
                        wire:navigate
                        href="{{ route('auth.register') }}"
                        class="text-black hover:underline"
                    >
                        Sign up here
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
