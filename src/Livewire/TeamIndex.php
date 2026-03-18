<?php

namespace AgenticMorf\FluxUITeams\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Teams')]
class TeamIndex extends Component
{
    public function getTeamsProperty()
    {
        return auth()->user()->allTeams();
    }

    public function render(): View
    {
        return view('teams::team-index')
            ->layout(config('fluxui-teams.layout', 'components.layouts.app.sidebar'));
    }
}
