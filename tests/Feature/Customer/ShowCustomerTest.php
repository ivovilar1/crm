<?php

use App\Models\Customer;
use App\Models\User;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    actingAs(User::factory()->create());
    $this->customer = Customer::factory()->create();
});

it('should be able to access customer.show route', function() {

    get(route('customers.show', $this->customer))->assertOk();
});

it('should show all the customer information in the page', function () {
    Livewire::test(App\Livewire\Customers\Show::class, ['customer' => $this->customer])
        ->assertSee($this->customer->name)
        ->assertSee($this->customer->email)
        ->assertSee($this->customer->phone)
        ->assertSee($this->customer->linkedin)
        ->assertSee($this->customer->facebook)
        ->assertSee($this->customer->twitter)
        ->assertSee($this->customer->instagram)
        ->assertSee($this->customer->address)
        ->assertSee($this->customer->city)
        ->assertSee($this->customer->state)
        ->assertSee($this->customer->country)
        ->assertSee($this->customer->zip)
        ->assertSee($this->customer->age)
        ->assertSee($this->customer->gender)
        ->assertSee($this->customer->company)
        ->assertSee($this->customer->position)
        ->assertSee($this->customer->created_at->diffForHumans());
});
