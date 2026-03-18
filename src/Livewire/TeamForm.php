<?php

namespace AgenticMorf\FluxUITeams\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Team')]
class TeamForm extends Component
{
    public ?string $teamId = null;

    public string $name = '';

    public function mount(?object $team = null): void
    {
        $teamModel = config('teams.models.team');
        if ($team) {
            $this->authorize('update', $team);
            $this->teamId = $team->id;
            $this->name = $team->name;
        }
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $teamModel = config('teams.models.team');

        if ($this->teamId) {
            $team = $teamModel::findOrFail($this->teamId);
            $this->authorize('update', $team);
            $team->update(['name' => $this->name]);
            $this->redirect(route(config('fluxui-teams.route_name_prefix').'show', $team), navigate: true);
        } else {
            $team = new $teamModel;
            $team->name = $this->name;
            $team->user_id = auth()->user()->getKey();
            $team->save();

            $defaultRoles = config(config('fluxui-teams.default_roles_config_key', 'permissions.default_roles'), []);
            $team->addRole('admin', $defaultRoles['admin'] ?? [], 'Administrator', 'Full team access');
            $team->addRole('member', $defaultRoles['member'] ?? [], 'Member', 'Basic access');

            $this->redirect(route(config('fluxui-teams.route_name_prefix').'show', $team), navigate: true);
        }
    }

    public function render(): View
    {
        $teamModel = config('teams.models.team');
        $team = $this->teamId ? $teamModel::find($this->teamId) : null;

        return view('teams::team-form', ['team' => $team])
            ->layout(config('fluxui-teams.layout', 'components.layouts.app.sidebar'));
    }
}
