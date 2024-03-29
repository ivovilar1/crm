<div>
    <x-header title="Customers" separator/>

    <div class="flex mb-4 items-end justify-between">
        <div class="w-full flex space-x-4 items-end">
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
            <x-checkbox
                label="Show archived customers"
                wire:model.live="search_trash"
                class="checkbox-primary"
                right tight
            />
        </div>
        <x-button @click="$dispatch('customer::create')" label="New Customer" icon="o-plus"/>
    </div>

    <x-table :headers="$this->headers" :rows="$this->items">
        @scope('header_id', $header)
        <x-table.th :$header name="id"/>
        @endscope

        @scope('header_name', $header)
        <x-table.th :$header name="name"/>
        @endscope

        @scope('header_email', $header)
        <x-table.th :$header name="email"/>
        @endscope

        @scope('actions', $customer)

        <div class="flex items-center space-x-2">
            <x-button
                id="show-btn-{{ $customer->id }}"
                wire:key="show-btn-{{ $customer->id }}"
                icon="o-pencil"
                @click="$dispatch('customer::update', { id: {{ $customer->id }} })"
                spinner class="btn-sm"
            />
            @unless($customer->trashed())
                <x-button
                    id="archive-btn-{{ $customer->id }}"
                    wire:key="archive-btn-{{ $customer->id }}"
                    icon="o-trash"
                    @click="$dispatch('customer::archive', { id: {{ $customer->id }} })"
                    spinner class="btn-sm"
                />
            @else
                <x-button
                    id="restore-btn-{{ $customer->id }}"
                    wire:key="restore-btn-{{ $customer->id }}"
                    icon="o-arrow-uturn-left"
                    @click="$dispatch('customer::restore', { id: {{ $customer->id }} })"
                    spinner class="btn-sm"
                />
            @endunless
        </div>

        @endscope
    </x-table>

    {{ $this->items->links(data :['scrollTo' => false]) }}
    <livewire:customers.create/>
    <livewire:customers.archive/>
    <livewire:customers.restore/>
    <livewire:customers.update/>
</div>
