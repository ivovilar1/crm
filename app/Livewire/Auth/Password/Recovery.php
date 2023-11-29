<?php

namespace App\Livewire\Auth\Password;

use App\Models\User;
use App\Notifications\PasswordRecoveryNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Recovery extends Component
{
    public ?string $message;
    #[Rule(['email', 'required'])]
    public ?string $email;
    public function render(): View
    {
        return view('livewire.auth.password.recovery');
    }

    public function startPasswordRecovery(): void
    {
        $this->validate();

        $user = User::query()->whereEmail($this->email)->first();

        $user?->notify(new PasswordRecoveryNotification());

        $this->message = 'You will receive an email with the password recovery link.';
    }
}
