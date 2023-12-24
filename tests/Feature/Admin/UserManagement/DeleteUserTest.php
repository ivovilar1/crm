<?php


use App\Models\User;
use Livewire\Livewire;
use \App\Livewire\Admin;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertSoftDeleted;

it('should be able to delete an user', function () {

    $user = User::factory()->admin()->create();

    $userForDeletion = User::factory()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Delete::class, ['user' => $userForDeletion])
        ->call('destroy')
        ->assertDispatched('user::deleted');

    assertSoftDeleted('users', [
        'id' => $userForDeletion->id,
    ]);
});
