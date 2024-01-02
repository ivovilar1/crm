<div class="flex h-screen w-full">
    <div class="lg:flex items-center justify-center flex-1">
        <div class="max-w-md text-center">
            <x-draw.password-reset />
        </div>
    </div>

    <div class="w-full bg-gray-100 lg:w-1/2 flex items-center justify-center">
        <div class="max-w-md w-full p-6">
            <h1 class="text-3xl font-semibold mb-6 text-black text-center">Password Reset</h1>
            @if($message = session()->get('status'))
                <x-alert icon="o-exclamation-triangle" class="alert-error mb-4">
                    {{ $message }}
                </x-alert>
            @endif
            <x-form wire:submit="updatePassword" class="space-y-4">
                <div>
                    <x-input
                        label="Email"
                        value="{{ $this->obfuscateEmail }}"
                        readonly
                        class="mt-1 p-2 w-full border rounded-md focus:border-gray-200
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors
                        duration-300"
                    />
                </div>
                <div>
                    <x-input
                        label="Email Confirmation"
                        wire:model="email_confirmation"
                        class="mt-1 p-2 w-full border rounded-md focus:border-gray-200
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors
                        duration-300"
                    />
                </div>
                <div>
                    <x-input
                        label="Password"
                        wire:model="password"
                        class="mt-1 p-2 w-full border rounded-md focus:border-gray-200
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors
                        duration-300"
                        type="password"
                    />
                </div>
                <div>
                    <x-input
                        label="Password Confirmation"
                        wire:model="password_confirmation"
                        class="mt-1 p-2 w-full border rounded-md focus:border-gray-200
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors
                        duration-300"
                        type="password"
                    />
                </div>
                <a
                    href="{{ route('login') }}"
                    class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500"
                >
                    Back to Login.
                </a>
                <div>
                    <x-button
                        type="submit"
                        class="w-full bg-black text-white p-2 rounded-md hover:bg-gray-800 focus:outline-none
                        focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900
                        transition-colors duration-300"
                        spinner="submit"
                    >
                        Reset
                    </x-button>
                </div>
            </x-form>
        </div>
    </div>
</div>
