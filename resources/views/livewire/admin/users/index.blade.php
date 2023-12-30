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
        <x-checkbox
            label="Show deleted users"
            wire:model.live="search_trash"
            class="checkbox-primary"
            right tight
        />
        <x-select
            wire:model.live="perPage"
            :options="
                [
                    ['id' => 5, 'name' => 5],
                    ['id' => 15, 'name' => 15],
                    ['id' => 25, 'name' => 25],
                    ['id' => 50, 'name' => 50]
                ]"
            label="Records per page"
        />
    </div>
        <x-table  :headers="$this->headers" :rows="$this->users">

            @scope('header_id', $header)
                <x-table.th :$header name="id" />
            @endscope

            @scope('header_name', $header)
                <x-table.th :$header name="name" />
            @endscope

            @scope('header_email', $header)
                <x-table.th :$header name="email" />
            @endscope

            @scope('cell_permissions', $user)
                @foreach($user->permissions as $permission)
                    <x-badge :value="$permission->key" class="badge-primary"/>
                @endforeach
            @endscope


            @scope('actions', $user)

                <div class="flex items-center space-x-2">
                    <x-button
                        id="show-btn-{{ $user->id }}"
                        wire:key="show-btn-{{ $user->id }}"
                        icon="o-eye"
                        wire:click="showUser({{ $user->id }})"
                        spinner class="btn-sm"
                    />

                    @can(\App\Enum\Can::BE_AN_ADMIN->value)
                        @unless($user->trashed())
                            @unless($user->is(auth()->user()))
                                <x-button
                                    id="delete-btn-{{ $user->id }}"
                                    wire:key="delete-btn-{{ $user->id }}"
                                    icon="o-trash"
                                    wire:click="destroy('{{ $user->id }}')"
                                    spinner class="btn-sm"
                                />
                            @endunless
                        @else
                            <x-button
                                icon="o-arrow-path-rounded-square"
                                wire:click="restore({{ $user->id }})"
                                spinner
                                class="btn-sm btn-success btn-ghost"/>
                        @endunless
                    @endcan
                </div>

            @endscope
        </x-table>

    {{ $this->users->links(data :['scrollTo' => false]) }}

    <livewire:admin.users.delete />
    <livewire:admin.users.restore />
    <livewire:admin.users.show />
</div>
