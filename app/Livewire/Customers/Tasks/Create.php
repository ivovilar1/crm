<?php

namespace App\Livewire\Customers\Tasks;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;
    #[Rule('required|string|max:255')]
    public ?string $task = null;
    public Customer $customer;
    public function render(): View
    {
        return view('livewire.customers.tasks.create');
    }

    public function save(): void
    {
        $this->validate();
        
        $this->customer->tasks()->create([
            'title' => $this->task,
        ]);

        $this->dispatch('task::created')->to('customers.tasks.index');

        $this->success('Task created!');

        $this->reset('task');
    }
}
