<?php

namespace App\Livewire\Customers\Tasks;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.customers.tasks.index');
    }
}
