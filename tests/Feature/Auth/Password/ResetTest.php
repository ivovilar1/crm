<?php

use function Pest\Laravel\get;

test('i need to have a route that will receive the token and the email that needs to be reset it', function () {
    get(route('password.reset'))
        ->assertOk();
});
