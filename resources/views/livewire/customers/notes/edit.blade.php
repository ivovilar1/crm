<div class="bg-base-200 rounded-md p-4 space-y-2 text-base gap-4 flex flex-col relative
border-b border-b-gray-800">
    @unless($edit)
        <p>{{ $note->note }}</p>
        <p class="text-sm italic mt-2">by {{ $note->user->name }}</p>

        <div class="absolute top-2 right-2 flex gap-4">
            <x-button spinner class="btn-ghost btn-sm " wire:click="pinNote">
                <x-icon name="s-star" @class([
                    'w-5 h-5',
                    'text-yellow-500' => $note->pinned
                ]) />
            </x-button>
            @if($note->user->is(auth()->user()))
                <x-button icon="o-pencil" spinner class="btn-ghost btn-sm " wire:click="$set('edit', true)" />
            @endif
        </div>
    @else
        <form class="flex-col items-start gap-2" wire:submit="save">
            <div class="w-full">
                <x-textarea wire:model="note.note" class="input-xs input-ghost "
                    placeholder="{{ __('Write down you new note ....') }}" />
            </div>
            <div class="flex justify-between">
                <div class="flex gap-2">
                    <x-button type="submit" class="btn-xs btn-ghost">{{ __('Save') }}</x-button>
                    <x-button type="button" class="btn-xs btn-ghost btn-error" wire:click="$set('edit', false)">
                        {{ __('Cancel') }}
                    </x-button>
                </div>
                <x-button type="button" class="btn-xs btn-ghost !text-error" wire:confirm="{{ __('Are you sure?') }}"
                    wire:click="destroy">
                    {{ __('Delete') }}
                </x-button>
            </div>
        </form>

    @endunless

</div>