{{--<x-card title="Register" shadow class="mx-auto w-[350px]">--}}
{{--    <x-form wire:submit="submit">--}}
{{--        <x-input label="Name" wire:model="name"/>--}}
{{--        <x-input label="Email" wire:model="email"/>--}}
{{--        <x-input label="Confirm your email" wire:model="email_confirmation"/>--}}
{{--        <x-input label="Password" wire:model="password" type="password"/>--}}
{{--        <x-slot:actions>--}}
{{--            <div class="w-full flex items-center justify-between">--}}
{{--                <a wire:navigate href="{{ route('login') }}" class="link link-primary">--}}
{{--                    I already have an account--}}
{{--                </a>--}}
{{--                <div>--}}
{{--                    <x-button label="Reset" type="reset"/>--}}
{{--                    <x-button label="Register" class="btn-primary" type="submit" spinner="submit"/>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </x-slot:actions>--}}
{{--    </x-form>--}}
{{--</x-card>--}}
<div class="flex h-screen w-full">
    <div class="lg:flex items-center justify-center flex-1">
        <div class="max-w-md text-center">
            <x-draw.register />
        </div>
    </div>

    <div class="w-full bg-gray-100 lg:w-1/2 flex items-center justify-center">
        <div class="max-w-md w-full p-6">
            <h1 class="text-3xl font-semibold mb-6 text-black text-center">Sign Up</h1>
            <x-form wire:submit="submit" class="space-y-4">
                <div>
                    <x-input
                        label="Name"
                        wire:model="name"
                        class="mt-1 p-2 w-full border rounded-md focus:border-gray-200
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors
                        duration-300"
                    />
                </div>
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
                        label="Confirm your email"
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
                        type="password"
                        class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2
                        focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300"
                    />
                </div>
                <div class="flex justify-center space-x-10">
                    <div>
                        <x-button
                            type="submit"
                            class="w-48 bg-black text-white p-2 rounded-md hover:bg-gray-800 focus:outline-none
                            focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900
                            transition-colors duration-300"
                            spinner="submit"
                        >
                            Register
                        </x-button>
                    </div>
                    <div>
                        <x-button
                            type="reset"
                            class="w-48 bg-red-800 text-white p-2 rounded-md hover:bg-gray-800 focus:outline-none
                            focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900
                            transition-colors duration-300"
                        >
                            Reset
                        </x-button>
                    </div>
                </div>
            </x-form>
            <div class="mt-4 text-sm text-gray-600 text-center">
                <a
                    wire:navigate
                    href="{{ route('login') }}"
                    class="text-black hover:underline"
                >
                    I already have an account
                </a>
            </div>
        </div>
    </div>
</div>
