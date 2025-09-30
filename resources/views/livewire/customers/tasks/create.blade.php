<form class="pt-1 pb-3 flex items-start gap-2" wire:submit="save">
    <div class="w-full">
        <x-input class="input-xs input-ghost" placeholder="{{ __('Write down your new task...') }}" wire:model="task"/>
    </div>
    <div>
        <x-button class="btn-xs btn-ghost" type="submit"> {{ __('Save') }} </x-button>
    </div>
</form>
