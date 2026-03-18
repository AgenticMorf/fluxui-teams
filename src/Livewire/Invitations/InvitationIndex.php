<?php

namespace AgenticMorf\FluxUITeams\Livewire\Invitations;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Team Invitations')]
class InvitationIndex extends Component
{
    public object $team;

    public function mount(object $team): void
    {
        $this->authorize('view', $team);
        $this->team = $team;
    }

    public function render(): View
    {
        return view('teams::invitation-index')
            ->layout(config('fluxui-teams.layout', 'components.layouts.app.sidebar'));
    }
}
