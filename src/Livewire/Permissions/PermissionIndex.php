<?php

namespace AgenticMorf\FluxUITeams\Livewire\Permissions;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Team Permissions')]
class PermissionIndex extends Component
{
    public object $team;

    public function mount(object $team): void
    {
        $this->authorize('view', $team);
        $this->team = $team;
    }

    public function render(): View
    {
        return view('teams::permission-index')
            ->layout(config('fluxui-teams.layout', 'components.layouts.app.sidebar'));
    }
}
