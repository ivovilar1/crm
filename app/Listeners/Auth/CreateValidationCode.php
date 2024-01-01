<?php

namespace App\Listeners\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateValidationCode
{
    public function handle(Registered $event): void
    {
        /** @var User $user */
        $user = $event->user;

        $user->validation_code = random_int(100000,999999);
        $user->save();
    }
}
