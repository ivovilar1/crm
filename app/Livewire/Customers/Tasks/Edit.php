<?php

namespace App\Livewire\Customers\Tasks;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public Task $task;

    public bool $editing = false;

    public function rules(): array
    {
        return [
            'task.title' => ['required', 'string', 'max:255'],
        ];
    }

    public function render(): View
    {
        return view('livewire.customers.tasks.edit');
    }

    public function save(): void
    {
        $this->validate();
        $this->task->save();

        $this->info(__('Task updated successfully!'));
        $this->reset('editing');
    }

    public function toggleCheck(string $status): void
    {
        Task::whereId($this->task->id)
            ->when(
                $status == 'done',
                fn (Builder $q) => $q->update(['done_at' => now()]),
                fn (Builder $q) => $q->update(['done_at' => null])
            );

        $this->dispatch('task::updated');
    }

    public function deleteTask(): void
    {
        $this->task->delete();
        $this->dispatch('task::deleted');
    }
}