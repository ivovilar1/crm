<?php

namespace App\Livewire\Admin\Users;

use App\Enum\Can;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

/** @property-read Collection|User[] $users */
class Index extends Component
{
    public ?string $search = null;

    public array $search_permissions = [];
    public function mount(): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);
    }
    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    #[Computed]
    public function users(): Collection
    {
        $this->validate(['search_permissions' => 'exists:permissions,id']);

        return User::query()
            ->when(
                $this->search, fn(Builder $query) => $query
                ->where(
                    DB::raw('lower(name)'), /** @phpstan-ignore-line */
                    'like',
                    '%' . strtolower($this->search) . '%'
                )
                ->orWhere(
                    'email',
                    'like',
                    '%' . $this->search . '%'
                )
            )
            ->when(
                $this->search_permissions,
                fn(Builder $query ) => $query->whereHas('permissions', function (Builder $q) {
                    $q->whereIn('id', $this->search_permissions);
                })
            )
            ->get();
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'permissions', 'label' => 'Permissions'],
        ];
    }
}
