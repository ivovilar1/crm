<?php

namespace App\Livewire\Admin\Users;

use App\Enum\Can;
use App\Models\Permission;
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

    public bool $search_trash = false;

    public Collection $permissionsToSearch;
    public array $search_permissions = [];

    public string $sortDirection = 'asc' ;

    public string $sortColumnBy = 'id';

    public int $perPage = 15;
    public function mount(): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);
        $this->filterPermissions();
    }
    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    #[Computed]
    public function users(): LengthAwarePaginator
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
            ->when($this->search_trash,
                fn(Builder $query) => $query->onlyTrashed()) /** @phpstan-ignore-line */
            ->orderBy($this->sortColumnBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'name', 'label' => 'Name', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'email', 'label' => 'Email', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'permissions', 'label' => 'Permissions', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
        ];
    }


    public function filterPermissions(?string $value = null): void
    {
        $this->permissionsToSearch = Permission::query()
            ->when($value, fn(Builder $query) => $query->where('key', 'like', '%' . $value . '%'))
            ->orderBy('key')
            ->get();
    }

    public function sortBy(string $column, string $direction): void
    {
        $this->sortColumnBy = $column;
        $this->sortDirection = $direction;
    }
}
