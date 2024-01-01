<?php

namespace App\Livewire\Auth;

use App\Events\Auth\SendNewCode;
use App\Models\User;
use App\Notifications\Auth\ValidationCodeNotification;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class EmailValidation extends Component
{
    public ?string $code = null;

    public function render(): View
    {
        return view('livewire.auth.email-validation');
    }

    public function handle(): void
    {
        $this->validate([
            'code' => function (string $attribute, mixed $value, Closure $fail) {
                if ($value !== auth()->user()->validation_code) {
                    $fail("Invalid code");
                }
            },
        ]);
    }

    public function sendNewCode(): void
    {
        SendNewCode::dispatch(auth()->user());
    }
}
