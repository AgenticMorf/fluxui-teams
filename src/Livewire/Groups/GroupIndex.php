<?php

namespace AgenticMorf\FluxUITeams\Livewire\Groups;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Team Groups')]
class GroupIndex extends Component
{
    public object $team;

    public bool $showModal = false;

    public string $code = '';

    public string $name = '';

    public array $permissions = [];

    public string|int|null $editingGroupId = null;

    public function mount(object $team): void
    {
        $this->authorize('view', $team);
        $this->team = $team;
    }

    public function getAvailablePermissionsProperty(): array
    {
        $codes = [];
        foreach (config(config('fluxui-teams.permissions_config_key', 'permissions.codes'), []) as $items) {
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
        $this->reset('code', 'name', 'permissions', 'editingGroupId');
        $this->showModal = true;
    }

    public function openEditModal(string|int $groupId): void
    {
        $group = $this->team->groups()->findOrFail($groupId);
        $this->editingGroupId = $groupId;
        $this->code = $group->code;
        $this->name = $group->name ?? '';
        $this->permissions = $group->permissions->pluck('code')->toArray();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'code' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        if ($this->editingGroupId) {
            $this->team->updateGroup($this->editingGroupId, $this->permissions, $this->name ?: null);
        } else {
            $this->team->addGroup($this->code, $this->permissions, $this->name ?: null);
        }

        $this->showModal = false;
        $this->reset('code', 'name', 'permissions', 'editingGroupId');
    }

    public function deleteGroup(string|int $groupId): void
    {
        $this->team->deleteGroup($groupId);
    }

    public function render(): View
    {
        return view('teams::group-index')
            ->layout(config('fluxui-teams.layout', 'components.layouts.app.sidebar'));
    }
}
