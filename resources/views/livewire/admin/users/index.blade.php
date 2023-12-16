<div>
    <x-header title="Users" separator />

    <div class="flex space-x-4 mb-4">
        <div class="w-1/3">
            <x-input
                label="Search by name or email"
                icon="o-magnifying-glass"
                placeholder="Search by name and email"
                wire:model.live="search"/>
        </div>
        <x-choices
            label="Search by permissions"
            placeholder="Filter by Permissions"
            wire:model.live="search_permissions"
            :options="$permissionsToSearch"
            option-label="key"
            search-function="filterPermissions"
            searchable
            no-result-text="Nothing here"
        />
    </div>
        <x-table  :headers="$this->headers" :rows="$this->users">
            @scope('cell_permissions', $user)
                @foreach($user->permissions as $permission)
                    <x-badge :value="$permission->key" class="badge-primary"/>
                @endforeach
            @endscope

            @scope('actions', $user)
                <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm"/>
            @endscope
        </x-table>
</div>
