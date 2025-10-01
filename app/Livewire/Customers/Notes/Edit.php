<?php

namespace App\Livewire\Customers\Notes;

use App\Models\Note;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public Note $note;

    public bool $edit = false;

    public function rules(): array
    {
        return [
            'note.note' => ['required', 'string'],
        ];
    }

    public function pinNote(): void
    {
        if (
            $this->note
                ->customer
                ->notes()
                ->where('pinned', '=', true)
                ->where('id', '!=', $this->note->id)
                ->exists()
        ) {
            $this->error('You can only have one pinned note');

            return;
        }

        $this->note->pinned = !$this->note->pinned;
        $this->note->save();

        $this->dispatch('pinned-note::refresh')->to('customers.pinned-note');
        $this->info($this->note->pinned ? 'Note pinned' : 'Note unpinned');
    }

    public function destroy(): void
    {

        $this->note->delete();

        $this->success(__('Note deleted successfully.'));
        $this->dispatch('notes::refresh')->to('customers.notes.index');
    }

    public function save(): void
    {
        $this->validate();
        $this->note->save();
        $this->success(__('Note updated successfully.'));
        $this->reset('edit');
    }

    public function render(): View
    {
        return view('livewire.customers.notes.edit');
    }
}
