<form class="pt-1 pb-3 flex items-start gap-2" wire:submit="save">
    <div class="w-full">
        <x-textarea wire:model="note" class="input-xs input-ghost "
            placeholder="{{ __('Write down you new note ....') }}" />
    </div>
    <div>
        <x-button type="submit" class="btn-xs btn-ghost">{{ __('Save') }}</x-button>
    </div>
</form>