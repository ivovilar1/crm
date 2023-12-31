<?php

namespace App\Livewire\Dev;

use Illuminate\Support\Facades\Process;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read string $branch
 * @property-read string $env
 */
class BranchEnv extends Component
{
    public function render(): string
    {
        return <<<'HTML'
        <div class="flex items-center space-x-2">
            <x-badge :value="$this->branch"/>
            <x-badge :value="$this->env"/>
        </div>
        HTML;
    }

    #[Computed]
    public function env(): string
    {
        return config('app.env');
    }
    #[Computed]
    public function branch(): string
    {
        return trim(Process::run('git branch --show-current')->output());
    }
}
