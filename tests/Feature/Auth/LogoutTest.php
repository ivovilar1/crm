<?php

use App\Livewire\Auth\Logout;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Logout::class)
        ->assertStatus(200);
});

it('should be able to can logout our system', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Logout::class)
        ->call('logout')
        ->assertOk()
        ->assertRedirect(route('login'));

    expect(auth())
        ->guest()
        ->toBeTrue();

});
