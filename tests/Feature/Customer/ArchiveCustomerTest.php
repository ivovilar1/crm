<?php

use App\Livewire\Customers;
use App\Models\Customer;
use Livewire\Livewire;

use function Pest\Laravel\assertSoftDeleted;

it('should be able to archive a customer', function () {

    $customer = Customer::factory()->create();

    Livewire::test(Customers\Archive::class)
        ->set('customer', $customer)
        ->call('archive');

    assertSoftDeleted('customers', [
        'id' => $customer->id,
    ]);

});

test('when confirming we should load the customer and set modal to true', function () {

    $customer = Customer::factory()->create();

    Livewire::test(Customers\Archive::class)
        ->call('confirmAction', $customer->id)
        ->assertSet('customer.id', $customer->id)
        ->assertSet('modal', true);
});

test('after archiving we should dispatch an event to tell the list to reload', function () {

    $customer = Customer::factory()->create();

    Livewire::test(Customers\Archive::class)
        ->set('customer', $customer)
        ->call('archive')
        ->assertDispatched('customer::reload');
});

test('after archiving we should close the modal', function () {

    $customer = Customer::factory()->create();

    Livewire::test(Customers\Archive::class)
        ->set('customer', $customer)
        ->call('archive')
        ->assertSet('modal', false);
});

it('should list archived customers', function () {

    Customer::factory()->count(2)->create();

    $customerArchived = Customer::factory()->archived()->create();

    Livewire::test(Customers\Index::class)
        ->set('search_trash', false)
        ->assertSet('items', function (\Illuminate\Pagination\LengthAwarePaginator $items) use ($customerArchived) {
            expect($items->items())->toHaveCount(2)
                ->and(collect($items->items())
                    ->filter(fn (Customer $customer) => $customer->id == $customerArchived->id))
                ->toBeEmpty();

            return true;
        })
        ->set('search_trash', true)
        ->assertSet('items', function (\Illuminate\Pagination\LengthAwarePaginator $items) use ($customerArchived) {
            expect($items->items())->toHaveCount(1)
                ->and(collect($items->items())
                    ->filter(fn (Customer $customer) => $customer->id == $customerArchived->id))
                ->not->toBeEmpty();

            return true;
        });

});