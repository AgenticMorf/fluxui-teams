<?php

namespace AgenticMorf\FluxUITeams\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Team')]
class TeamShow extends Component
{
    public object $team;

    public function mount(object $team): void
    {
        $this->authorize('view', $team);
        $this->team = $team;
    }

    public function getTeamEntitiesProperty()
    {
        $callback = config('fluxui-teams.team_entities_callback');
        if ($callback && is_callable($callback)) {
            return $callback($this->team);
        }

        return collect();
    }

    public function render(): View
    {
        return view('teams::team-show')
            ->layout(config('fluxui-teams.layout', 'components.layouts.app.sidebar'));
    }
}
