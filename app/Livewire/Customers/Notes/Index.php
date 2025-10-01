<?php

namespace App\Livewire\Customers\Notes;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;


#[On('notes::refresh')]
class Index extends Component
{
    public Customer $customer;

    #[Computed]
    public function notes(): Collection
    {
        return $this->customer->notes()->with('user')->latest()->get();
    }

    public function render(): View
    {
        return view('livewire.customers.notes.index');
    }
}
