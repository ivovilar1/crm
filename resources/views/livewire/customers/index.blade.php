<div>
    <x-header title="Customers" separator />

    <div class="flex space-x-4 mb-4">
        <div class="w-1/3">
            <x-input
                label="Search by name or email"
                icon="o-magnifying-glass"
                placeholder="Search by name and email"
                wire:model.live="search"/>
        </div>
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

    <x-table  :headers="$this->headers" :rows="$this->customers">
    </x-table>

    {{ $this->customers->links(data :['scrollTo' => false]) }}
</div>
