<?php


use App\Models\User;
use App\Notifications\UserDeletedNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use App\Livewire\Admin;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertNotSoftDeleted;
use function Pest\Laravel\assertSoftDeleted;

it('should be able to delete an user', function () {

    $user = User::factory()->admin()->create();

    $userForDeletion = User::factory()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Delete::class)
        ->set('user', $userForDeletion)
        ->set('confirmation_confirmation', 'I WANT TO DELETE')
        ->call('destroy')
        ->assertDispatched('user::deleted');

    assertSoftDeleted('users', [
        'id' => $userForDeletion->id,
    ]);

    $userForDeletion->refresh();

    expect($userForDeletion)
        ->deletedBy->id->toBe($user->id);
});

it('should have a confirmation before deletion', function () {

    $user = User::factory()->admin()->create();

    $userForDeletion = User::factory()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Delete::class)
        ->set('user', $userForDeletion)
        ->call('destroy')
        ->assertHasErrors(['confirmation' => 'confirmed'])
        ->assertNotDispatched('user::deleted');

    assertNotSoftDeleted('users', [
        'id' => $userForDeletion->id
    ]);

});

it('should send a notification to the user telling him that he has no long access to the application', function () {

    Notification::fake();

    $user = User::factory()->admin()->create();

    $userForDeletion = User::factory()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Delete::class)
        ->set('user', $userForDeletion)
        ->set('confirmation_confirmation', 'I WANT TO DELETE')
        ->call('destroy');

    Notification::assertSentTo($userForDeletion, UserDeletedNotification::class);

});

it('should not be possible to delete the logged user', function () {

    $user = User::factory()->admin()->create();

    actingAs($user);

    Livewire::test(Admin\Users\Delete::class)
        ->set('user', $user)
        ->set('confirmation_confirmation', 'I WANT TO DELETE')
        ->call('destroy')
        ->assertHasErrors(['confirmation'])
        ->assertNotDispatched('user::deleted');

    assertNotSoftDeleted('users', [
        'id' => $user->id
    ]);
});
