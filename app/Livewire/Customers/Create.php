<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
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

    public bool $modal = false;
    public function render(): View
    {
        return view('livewire.customers.create');
    }

    #[On('customer::create')]
    public function open(): void
    {
        $this->resetErrorBag();
        $this->modal = true;
    }
    public function save(): void
    {
        $this->validate();

        $customer = Customer::create([
            'type' => 'customer',
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone
        ]);

        $this->modal = false;
    }
}
