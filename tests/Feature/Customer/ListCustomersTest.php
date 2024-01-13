<?php

use App\Enum\Can;
use App\Livewire\Admin;
use App\Models\{Permission, User};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

it('should be able to access the route customers', function () {

    actingAs(User::factory()->create());

    get(route('customers'))->assertOk();
});

test("let's create a livewire component to list all customers in the page", function () {

    actingAs(User::factory()->admin()->create());
    $customers = User::factory()->count(10)->create();

    $livewire = Livewire::test(Customers\Index::class);
    $livewire->assertSet('customers', function ($customers) {
        expect($customers)
            ->toHaveCount(11);

        return true;
    });

    foreach ($customers as $user) {
        $livewire->assertSee($user->name);
    }
});

test('check the table format', function () {

    actingAs(User::factory()->admin()->create());

    Livewire::test(Customers\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'name', 'label' => 'Name', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'email', 'label' => 'Email', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ]);
});

it('should be able to filter by name and email', function () {

    $admin      = User::factory()->admin()->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);
    $userRandom = User::factory()->create(['name' => 'Random Guy', 'email' => 'random_guy@gmai.com']);

    actingAs($admin);

    Livewire::test(Customers\Index::class)
        ->assertSet('customers', function ($customers) {
            expect($customers)
                ->toHaveCount(2);

            return true;
        })
        ->set('search', 'Rand')
        ->assertSet('customers', function ($customers) {
            expect($customers)
                ->toHaveCount(1)
                ->first()->name
                ->toBe('Random Guy');

            return true;
        })
        ->set('search', 'guy')
            ->assertSet('customers', function ($customers) {
                expect($customers)
                    ->toHaveCount(1)
                    ->first()->name
                    ->toBe('Random Guy');

                return true;
            });
});

it('should be able to filter by permission.key', function () {

    $admin             = User::factory()->admin()->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);
    $userRandom        = User::factory()->withPermission(Can::TESTING)->create(['name' => 'Random Guy', 'email' => 'random_guy@gmai.com']);
    $permission        = Permission::where('key', '=', Can::BE_AN_ADMIN->value)->first();
    $permissionTesting = Permission::where('key', '=', Can::TESTING->value)->first();

    actingAs($admin);

    Livewire::test(Customers\Index::class)
        ->assertSet('customers', function ($customers) {
            expect($customers)
                ->toHaveCount(2);

            return true;
        })
        ->set('search_permissions', [$permission->id, $permissionTesting->id])
        ->assertSet('customers', function ($customers) {
            expect($customers)
                ->toHaveCount(2);

            return true;
        });
});

it('should be able to list deleted customers', function () {

    $admin        = User::factory()->admin()->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);
    $deletedcustomers = User::factory()->count(2)->create(['deleted_at' => now()]);

    actingAs($admin);

    Livewire::test(Customers\Index::class)
        ->assertSet('customers', function ($customers) {
            expect($customers)
                ->toHaveCount(1);

            return true;
        })
        ->set('search_trash', true)
        ->assertSet('customers', function ($customers) {
            expect($customers)
                ->toHaveCount(2);

            return true;
        });
});

it('should be able to sort by name', function () {

    $admin      = User::factory()->admin()->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);
    $userRandom = User::factory()->withPermission(Can::TESTING)->create(['name' => 'Random Guy', 'email' => 'random_guy@gmai.com']);

    actingAs($admin);

    Livewire::test(Customers\Index::class)
        ->set('sortDirection', 'asc')
        ->set('sortColumnBy', 'name')
        ->assertSet('customers', function ($customers) {
            expect($customers)
                ->first()->name->toBe('Admin')
                ->and($customers)->last()->name->toBe('Random Guy');

            return true;
        });

    Livewire::test(Customers\Index::class)
        ->set('sortDirection', 'desc')
        ->set('sortColumnBy', 'name')
        ->assertSet('customers', function ($customers) {
            expect($customers)
                ->first()->name->toBe('Random Guy')
                ->and($customers)->last()->name->toBe('Admin');

            return true;
        });

});

it('should be able to paginate the result', function () {

    $admin = User::factory()->admin()->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);
    User::factory()->withPermission(Can::TESTING)->count(30)->create();

    actingAs($admin);

    Livewire::test(Customers\Index::class)
        ->assertSet('customers', function (LengthAwarePaginator $customers) {
            expect($customers)
                ->toHaveCount(15);

            return true;
        });
    Livewire::test(Customers\Index::class)
        ->set('perPage', 20)
        ->assertSet('customers', function (LengthAwarePaginator $customers) {
            expect($customers)
                ->toHaveCount(20);

            return true;
        });
});
