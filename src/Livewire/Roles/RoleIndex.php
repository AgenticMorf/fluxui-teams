<?php

namespace AgenticMorf\FluxUITeams\Livewire\Roles;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Team Roles')]
class RoleIndex extends Component
{
    public object $team;

    public bool $showModal = false;

    public string $code = '';

    public string $name = '';

    public string $description = '';

    public array $permissions = [];

    public string|int|null $editingRoleId = null;

    public function mount(object $team): void
    {
        $this->authorize('view', $team);
        $this->team = $team;
    }

    public function getAvailablePermissionsProperty(): array
    {
        $codes = [];
        foreach (config(config('fluxui-teams.permissions_config_key', 'permissions.codes'), []) as $group => $items) {
            if (is_array($items)) {
                foreach ($items as $code => $label) {
                    $codes[$code] = $label;
                }
            }
        }

        return $codes;
    }

    public function openCreateModal(): void
    {
        $this->reset('code', 'name', 'description', 'permissions', 'editingRoleId');
        $this->showModal = true;
    }

    public function openEditModal(string|int $roleId): void
    {
        $role = $this->team->roles()->findOrFail($roleId);
        $this->editingRoleId = $roleId;
        $this->code = $role->code;
        $this->name = $role->name ?? '';
        $this->description = $role->description ?? '';
        $this->permissions = $role->permissions->pluck('code')->toArray();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'code' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        if ($this->editingRoleId) {
            $this->team->updateRole($this->editingRoleId, $this->permissions, $this->name ?: null, $this->description ?: null);
        } else {
            $this->team->addRole($this->code, $this->permissions, $this->name ?: null, $this->description ?: null);
        }

        $this->showModal = false;
        $this->reset('code', 'name', 'description', 'permissions', 'editingRoleId');
    }

    public function deleteRole(string|int $roleId): void
    {
        $this->team->deleteRole($roleId);
    }

    public function render(): View
    {
        return view('teams::role-index')
            ->layout(config('fluxui-teams.layout', 'components.layouts.app.sidebar'));
    }
}
