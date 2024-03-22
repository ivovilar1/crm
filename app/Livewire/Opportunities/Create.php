<?php

namespace App\Livewire\Opportunities;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;
    public Form $form;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.opportunities.create');
    }

    #[On('opportunity::create')]
    public function open(): void
    {
        $this->form->resetErrorBag();
        $this->form->searchCustomers();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->create();

        $this->modal = false;
        $this->dispatch('opportunity::reload')->to('opportunities.index');

        $this->success('Opportunity created!');
    }
    public function search(string $value = ''): void
    {
        $this->form->searchCustomers($value);
    }
}
