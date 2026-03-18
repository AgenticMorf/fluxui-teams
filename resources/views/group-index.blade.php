<div>
    <x-teams::layout
        :team="$team"
        heading="{{ __('Groups') }}"
        :subheading="__('Manage team groups')"
        :breadcrumbs="[
            ['label' => __('Teams'), 'href' => route(config('fluxui-teams.route_name_prefix').'index')],
            ['label' => $team->name, 'href' => route(config('fluxui-teams.route_name_prefix').'show', $team)],
            ['label' => __('Groups'), 'href' => null],
        ]"
    >
        <flux:card>
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">{{ __('Groups') }}</flux:heading>
                <flux:button wire:click="openCreateModal" variant="primary" icon="plus">
                    {{ __('Add group') }}
                </flux:button>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>{{ __('Code') }}</flux:table.column>
                    <flux:table.column>{{ __('Name') }}</flux:table.column>
                    <flux:table.column>{{ __('Members') }}</flux:table.column>
                    <flux:table.column>{{ __('Permissions') }}</flux:table.column>
                    <flux:table.column class="text-end">{{ __('Actions') }}</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($team->groups as $group)
                        <flux:table.row :key="$group->id">
                            <flux:table.cell variant="strong">{{ $group->code }}</flux:table.cell>
                            <flux:table.cell>{{ $group->name ?? '-' }}</flux:table.cell>
                            <flux:table.cell>{{ $group->users->count() }}</flux:table.cell>
                            <flux:table.cell>
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($group->permissions->take(3) as $perm)
                                        <flux:badge size="sm">{{ $perm->code }}</flux:badge>
                                    @endforeach
                                    @if ($group->permissions->count() > 3)
                                        <flux:badge size="sm">+{{ $group->permissions->count() - 3 }}</flux:badge>
                                    @endif
                                </div>
                            </flux:table.cell>
                            <flux:table.cell class="text-end">
                                <flux:button wire:click="openEditModal('{{ $group->id }}')" variant="ghost" size="sm">
                                    {{ __('Edit') }}
                                </flux:button>
                                <flux:button
                                    wire:click="deleteGroup('{{ $group->id }}')"
                                    wire:confirm="{{ __('Are you sure?') }}"
                                    variant="danger"
                                    size="sm"
                                >
                                    {{ __('Delete') }}
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>

            @if ($team->groups->isEmpty())
                <flux:text variant="subtle">{{ __('No groups yet. Create one to organize team members.') }}</flux:text>
            @endif
        </flux:card>
    </x-teams::layout>

    <flux:modal wire:model="showModal" name="group-form" class="max-w-lg">
        <form wire:submit="save" class="space-y-4">
            <flux:heading size="lg">{{ $editingGroupId ? __('Edit group') : __('Add group') }}</flux:heading>
            <flux:input wire:model="code" label="{{ __('Code') }}" placeholder="e.g. editors" :disabled="(bool) $editingGroupId" required />
            <flux:input wire:model="name" label="{{ __('Name') }}" placeholder="{{ __('Display name') }}" />

            <div>
                <flux:subheading class="mb-2">{{ __('Permissions') }}</flux:subheading>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @foreach ($this->availablePermissions as $code => $label)
                        <flux:checkbox wire:model="permissions" value="{{ $code }}" :label="$label" />
                    @endforeach
                </div>
            </div>

            <div class="flex gap-2">
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
                <flux:button type="button" variant="ghost" wire:click="$set('showModal', false)">
                    {{ __('Cancel') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
