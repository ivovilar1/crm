<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|min:3|max:255')]
    public ?string $name = null;

    #[Validate('required_without:phone|email|unique:customers')]
    public ?string $email = null;

    #[Validate('required_without:email|unique:customers')]
    public ?string $phone = null;

    public function render(): View
    {
        return view('livewire.customers.create');
    }

    public function save(): void
    {
        $this->validate();

        $customer = Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone
        ]);

    }
}
