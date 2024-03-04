<?php

namespace App\Livewire\Customers;

use Illuminate\Contracts\View\View;
use Mary\Traits\Toast;
use Livewire\Attributes\{On};
use Livewire\Component;

class Create extends Component
{
    use Toast;
    public Form $form;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.customers.create');
    }

    #[On('customer::create')]
    public function open(): void
    {
        $this->form->resetErrorBag();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->create();

        $this->modal = false;
        $this->dispatch('customer::reload')->to('customers.index');

        $this->success('Customer created!');
    }
}
