<?php

use App\Livewire\Dev\BranchEnv;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Facades\Process;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should show a current branch in the page', function () {

    Process::fake([
        'git branch --show-current' => Process::result('jeremias')
    ]);

    Livewire::test(BranchEnv::class)
        ->assertSet('branch','jeremias')
        ->assertSee('jeremias');

    Process::assertRan('git branch --show-current');
});

it('should show a current environment in the page', function () {

    $env = 'testing';

    Livewire::test(BranchEnv::class)
        ->assertSet('env', $env)
        ->assertSee('testing');

});

it('should not load the livewire component on production environment', function () {

    $user = User::factory()->create();

    app()->detectEnvironment(fn () => 'production');

    actingAs($user);

    get(route('dashboard')) // app.blade.php
    ->assertDontSeeLivewire('dev.login');

    get(route('login')) // guest.blade.php
    ->assertDontSeeLivewire('dev.login');


});

it('should load the livewire component on non production environment', function () {

    $user = User::factory()->create();

    app()->detectEnvironment(fn () => 'local');

    actingAs($user);

    get(route('dashboard')) // app.blade.php
    ->assertSeeLivewire('dev.login');

    get(route('login')) // guest.blade.php
    ->assertSeeLivewire('dev.login');

});
