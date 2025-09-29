<?php

namespace App\Livewire\Customers\Tasks;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public Customer $customer;

    public function render(): View
    {
        return view('livewire.customers.tasks.index');
    }
}
