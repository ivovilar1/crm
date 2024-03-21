<?php

use App\Livewire\Opportunities;
use Livewire\Livewire;
use App\Models\{Customer, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able to create a opportunity', function () {
    $customer = Customer::factory()->create();

    Livewire::test(Opportunities\Create::class)
        ->set('form.customer_id', $customer->id)
        ->assertPropertyWired('form.customer_id')
        ->set('form.title', 'John Doe')
        ->assertPropertyWired('form.title')
        ->set('form.status', 'won')
        ->assertPropertyWired('form.status')
        ->set('form.amount', '123.45')
        ->assertPropertyWired('form.amount')
        ->call('save')
        ->assertMethodWiredToForm('save')
        ->assertHasNoErrors();

    assertDatabaseHas('opportunities', [
        'customer_id' => $customer->id,
        'title'  => 'John Doe',
        'status' => 'won',
        'amount' => '12345',
    ]);
});

describe('validations', function () {
    test('customer', function ($rule, $value) {
        Livewire::test(Opportunities\Create::class)
            ->set('form.customer_id', $value)
            ->call('save')
            ->assertHasErrors(['form.customer_id' => $rule]);
    })->with([
        'required' => ['required', ''],
        'exists' => ['exists', 9430],
    ]);
    test('title', function ($rule, $value) {
        Livewire::test(Opportunities\Create::class)
            ->set('form.title', $value)
            ->call('save')
            ->assertHasErrors(['form.title' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'Jo'],
        'max'      => ['max', str_repeat('a', 256)],
    ]);

    test('status', function ($rule, $value) {
        Livewire::test(Opportunities\Create::class)
            ->set('form.status', $value)
            ->call('save')
            ->assertHasErrors(['form.status' => $rule]);
    })->with([
        'required' => ['required', ''],
        'in'       => ['in', 'jeremias'],
    ]);

    test('amount', function ($rule, $value) {
        Livewire::test(Opportunities\Create::class)
            ->set('form.amount', $value)
            ->call('save')
            ->assertHasErrors(['form.amount' => $rule]);
    })->with([
        'required' => ['required', ''],
    ]);
});

test('check if component is in the page', function () {
    Livewire::test(Opportunities\Index::class)
        ->assertContainsLivewireComponent('opportunities.create');
});
