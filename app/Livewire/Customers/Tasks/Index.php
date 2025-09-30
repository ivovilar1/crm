<?php

namespace App\Livewire\Customers\Tasks;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Index extends Component
{
    public Customer $customer;

    #[On('task::created')]
    public function render(): View
    {
        return view('livewire.customers.tasks.index');
    }

    #[Computed]
    public function doneTasks(): Collection
    {
        return $this->customer->tasks()->done()->get();
    }

    #[Computed]
    public function notDoneTasks(): Collection
    {
        return $this->customer->tasks()->notDone()->orderBy('sort_order')->get();
    }

    public function updateTaskOrder(array $data): void
    {
        $orders = collect($data)->pluck('value')->join(',');
        DB::table('tasks')->update(['sort_order' => DB::raw("field(id, $orders)")]);
    }
}
