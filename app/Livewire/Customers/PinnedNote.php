<?php

namespace App\Livewire\Customers;

use App\Models\{Customer, Note};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

#[On('pinned-note::refresh')]
class PinnedNote extends Component
{
    public Customer $customer;

    #[Computed]
    public function note(): ?Note
    {
        /** @var ?Note $note */
        $note = $this->customer->notes()
            ->with('user')
            ->wherePinned(true)->first();

        return $note;
    }

    public function render(): View
    {
        return view('livewire.customers.pinned-note');
    }
}
