<?php

namespace AgenticMorf\FluxUITeams\Livewire\Members;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Team Members')]
class MemberIndex extends Component
{
    public object $team;

    public string $email = '';

    public string $role = 'member';

    public bool $showInviteModal = false;

    public function mount(object $team): void
    {
        $this->authorize('view', $team);
        $this->team = $team;
    }

    public function openInviteModal(): void
    {
        $this->authorize('addTeamMember', $this->team);
        $this->reset('email', 'role');
        $this->role = 'member';
        $this->showInviteModal = true;
    }

    public function inviteUser(): void
    {
        $this->authorize('addTeamMember', $this->team);
        $this->validate([
            'email' => 'required|email',
            'role' => 'required|string|in:admin,member',
        ]);

        $this->team->inviteUser($this->email, $this->role);
        $this->showInviteModal = false;
        $this->reset('email', 'role');
    }

    public function addUser(int|string $userId): void
    {
        $user = config('teams.models.user')::findOrFail($userId);
        $this->authorize('addTeamMember', $this->team);
        $this->team->addUser($user, $this->role);
    }

    public function updateRole(int|string $userId, string $role): void
    {
        $user = config('teams.models.user')::findOrFail($userId);
        $this->authorize('updateTeamMember', $this->team);
        $this->team->updateUser($user, $role);
    }

    public function removeMember(int|string $userId): void
    {
        $user = config('teams.models.user')::findOrFail($userId);
        $this->authorize('removeTeamMember', $this->team);
        $this->team->deleteUser($user);
    }

    public function render(): View
    {
        return view('teams::member-index')
            ->layout(config('fluxui-teams.layout', 'components.layouts.app.sidebar'));
    }
}
