<?php

use App\Enum\Can;
use App\Livewire\Admin;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should be able to access the route admin/users', function () {

    actingAs(User::factory()->admin()->create());

    get(route('admin.users'))->assertOk();
});

test('making sure that the route is protected by the permission BE_AN_ADMIN', function () {

    actingAs(User::factory()->create());

    get(route('admin.users'))->assertForbidden();
});

test("let's create a livewire component to list all users in the page", function () {

    actingAs(User::factory()->admin()->create());
    $users = User::factory()->count(10)->create();

    $livewire = Livewire::test(Admin\Users\Index::class);
    $livewire->assertSet('users', function ($users) {
                expect($users)
                    ->toHaveCount(11);

                return true;
            });
    foreach ($users as $user) {
        $livewire->assertSee($user->name);
    }
});

test('check the table format', function () {

    actingAs(User::factory()->admin()->create());

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'name', 'label' => 'Name', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'email', 'label' => 'Email', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'permissions', 'label' => 'Permissions', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ]);
});

it('should be able to filter by name and email', function () {

    $admin = User::factory()->admin()->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);
    $userRandom = User::factory()->create(['name' => 'Random Guy', 'email' => 'random_guy@gmai.com']);

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);

        return true;
    })
        ->set('search', 'Rand')
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(1)
                ->first()->name
                ->toBe('Random Guy');

        return true;
        })
        ->set('search', 'guy')
            ->assertSet('users', function ($users) {
                expect($users)
                    ->toHaveCount(1)
                    ->first()->name
                    ->toBe('Random Guy');

                return true;
            });
});

it('should be able to filter by permission.key', function () {

    $admin = User::factory()->admin()->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);
    $userRandom = User::factory()->withPermission(Can::TESTING)->create(['name' => 'Random Guy', 'email' => 'random_guy@gmai.com']);
    $permission = Permission::where('key', '=', Can::BE_AN_ADMIN->value)->first();
    $permissionTesting = Permission::where('key', '=', Can::TESTING->value)->first();

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);

            return true;
        })
        ->set('search_permissions', [$permission->id, $permissionTesting->id])
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);

            return true;
        });
});


it('should be able to list deleted users', function () {

    $admin = User::factory()->admin()->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);
    $deletedUsers = User::factory()->count(2)->create(['deleted_at' => now()]);

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(1);

            return true;
        })
        ->set('search_trash', true)
        ->assertSet('users', function ($users) {
            expect($users)
                ->toHaveCount(2);

            return true;
        });
});

it('should be able to sort by name', function () {

    $admin = User::factory()->admin()->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);
    $userRandom = User::factory()->withPermission(Can::TESTING)->create(['name' => 'Random Guy', 'email' => 'random_guy@gmai.com']);

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->set('sortDirection', 'asc')
        ->set('sortColumnBy', 'name')
        ->assertSet('users', function ($users) {
            expect($users)
                ->first()->name->toBe('Admin')
                ->and($users)->last()->name->toBe('Random Guy');

            return true;
        });

    Livewire::test(Admin\Users\Index::class)
        ->set('sortDirection', 'desc')
        ->set('sortColumnBy', 'name')
        ->assertSet('users', function ($users) {
            expect($users)
                ->first()->name->toBe('Random Guy')
                ->and($users)->last()->name->toBe('Admin');

            return true;
        });

});

it('should be able to paginate the result', function () {

    $admin = User::factory()->admin()->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);
    User::factory()->withPermission(Can::TESTING)->count(30)->create();

    actingAs($admin);

    Livewire::test(Admin\Users\Index::class)
        ->assertSet('users', function (LengthAwarePaginator $users) {
            expect($users)
                ->toHaveCount(15);

            return true;
        });
    Livewire::test(Admin\Users\Index::class)
        ->set('perPage', 20)
        ->assertSet('users', function (LengthAwarePaginator $users) {
            expect($users)
                ->toHaveCount(20);

            return true;
        });
});
