<div class="flex h-screen w-full">
    <div class="lg:flex items-center justify-center flex-1">
        <div class="max-w-md text-center">
            <x-draw.password-recovery />
        </div>
    </div>

    <div class="w-full bg-gray-100 lg:w-1/2 flex items-center justify-center">
        <div class="max-w-md w-full p-6">
            <h1 class="text-3xl font-semibold mb-6 text-black text-center">Password Recovery</h1>
                @if($message)
                    <x-alert icon="o-exclamation-triangle" class="alert-success mb-4">
                        <span>You will receive an email with the password recovery link.</span>
                    </x-alert>
                @endif
            <x-form wire:submit="startPasswordRecovery" class="space-y-4">
                <div>
                    <x-input
                        label="Email"
                        wire:model="email"
                        class="mt-1 p-2 w-full border rounded-md focus:border-gray-200
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors
                        duration-300"
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
                        Submit
                    </x-button>
                </div>
            </x-form>
        </div>
    </div>
</div>
