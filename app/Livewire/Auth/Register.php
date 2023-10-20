<?php

namespace App\Livewire\Auth;


use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Register extends Component
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $email_confirmation = null;

    public ?string $password = null;
    public function render(): View
    {
        return view('livewire.auth.register');
    }

    public function submit(): void
    {
        User::query()
            ->create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password
            ]);
    }
}
