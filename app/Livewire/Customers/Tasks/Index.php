<?php

namespace App\Livewire\Customers\Tasks;

use App\Actions\DataSort;
use App\Models\Customer;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
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
        (new DataSort('tasks', $data, 'value'))->run();
    }

    public function toggleCheck(int $id, string $status): void
    {
        Task::query()
        ->whereId($id)
        ->when(
            $status === 'done',
            fn (Builder $q) => $q->update(['done_at' => now()]),
            fn (Builder $q) => $q->update(['done_at' => null]),
        );
    }
}
