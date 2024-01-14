<?php

namespace App\Livewire\Admin\Users;

use App\Enum\Can;
use App\Support\Table\Header;
use App\Traits\Livewire\HasTable;
use App\Models\{Permission, User};
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Computed, On};
use Livewire\{Component, WithPagination};

/** @property-read Collection|User[] $users */
class Index extends Component
{
    use WithPagination;
    use HasTable;

    public bool $search_trash = false;

    public Collection $permissionsToSearch;

    public array $search_permissions = [];

    public function mount(): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);
        $this->filterPermissions();
    }

    #[On('user::deleted')]
    #[On('user::restored')]
    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    public function updatedPerPage($value): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        $this->validate(['search_permissions' => 'exists:permissions,id']);

        return User::query()
            ->with('permissions')
            ->search($this->search, ['name', 'email'])
            ->when(
                $this->search_permissions,
                fn (Builder $query) => $query->whereHas('permissions', function (Builder $q) {
                    $q->whereIn('id', $this->search_permissions);
                })
            )
            ->when(
                $this->search_trash,
                fn (Builder $query) => $query->onlyTrashed()
            ) /** @phpstan-ignore-line */
            ->orderBy($this->sortColumnBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('id', '#'),
            Header::make('name', 'Name'),
            Header::make('email', 'Email'),
            Header::make('permissions', 'Permissions')
        ];
    }

    public function filterPermissions(?string $value = null): void
    {
        $this->permissionsToSearch = Permission::query()
            ->when($value, fn (Builder $query) => $query->where('key', 'like', '%' . $value . '%'))
            ->orderBy('key')
            ->get();
    }

    public function sortBy(string $column, string $direction): void
    {
        $this->sortColumnBy  = $column;
        $this->sortDirection = $direction;
    }

    public function destroy(int $id): void
    {
        $this->dispatch('user::deletion', userID: $id)->to('admin.users.delete');
    }

    public function impersonate(int $id): void
    {
        $this->dispatch('user::impersonation', userId: $id)->to('admin.users.impersonate');
    }
    public function restore(int $id): void
    {
        $this->dispatch('user::restoring', userID: $id)->to('admin.users.restore');
    }

    public function showUser(int $id): void
    {
        $this->dispatch('user::show', id: $id)->to('admin.users.show');
    }
}
