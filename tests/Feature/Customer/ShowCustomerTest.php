<?php

use App\Livewire\Customers;
use App\Models\{Customer, User};

use function Pest\Laravel\{actingAs, get, livewire};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

test('should be able to access the customer show page', function () {
    $customer = Customer::factory()->create();

    get(route('customers.show', $customer))->assertOk();
});

it('should be able to see the customer details', function () {
    $customer = Customer::factory()->create();

    Livewire::test(Customers\Show::class, ['customer' => $customer])
        ->assertSee($customer->name)
        ->assertSee($customer->email)
        ->assertSee($customer->phone)
        ->assertSee($customer->linkedin)
        ->assertSee($customer->instagram)
        ->assertSee($customer->facebook)
        ->assertSee($customer->twitter)
        ->assertSee($customer->address)
        ->assertSee($customer->city)
        ->assertSee($customer->state)
        ->assertSee($customer->zip)
        ->assertSee($customer->country)
        ->assertSee($customer->gender)
        ->assertSee($customer->company)
        ->assertSee($customer->position)
        ->assertSee($customer->created_at->diffForHumans());
});