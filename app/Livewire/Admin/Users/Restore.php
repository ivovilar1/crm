<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Notifications\UserRestoredAccessNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class Restore extends Component
{
    use Toast;

    public ?User $user = null;

    #[Rule(['required', 'confirmed'])]
    public string $confirmation = 'I WANT TO RESTORE';

    public ?string $confirmation_confirmation = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.users.restore');
    }

    #[On('user::restoring')]
    public function openConfirmationFor(int $userID): void
    {
        $this->user = User::select('id', 'name')->withTrashed()->find($userID);
        $this->modal = true;
    }

    public function restore(): void
    {

        $this->validate();

        if ($this->isSameUser()) {
            $this->addError('confirmation', "You can't delete yourself.");
            return ;
        }

        $this->user->restore();

        $this->success('User restored successfully!');

        $this->user->notify(new UserRestoredAccessNotification());

        $this->dispatch('user::restored');

        $this->reset('modal');

    }

    private function isSameUser(): bool
    {
       return $this->user->is(auth()->user());
    }
}
