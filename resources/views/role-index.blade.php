<div>
    <x-teams::layout
        :team="$team"
        heading="{{ __('Roles') }}"
        :subheading="__('Manage team roles and permissions')"
        :breadcrumbs="[
            ['label' => __('Teams'), 'href' => route(config('fluxui-teams.route_name_prefix').'index')],
            ['label' => $team->name, 'href' => route(config('fluxui-teams.route_name_prefix').'show', $team)],
            ['label' => __('Roles'), 'href' => null],
        ]"
    >
        <flux:card>
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">{{ __('Roles') }}</flux:heading>
                <flux:button wire:click="openCreateModal" variant="primary" icon="plus">
                    {{ __('Add role') }}
                </flux:button>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>{{ __('Code') }}</flux:table.column>
                    <flux:table.column>{{ __('Name') }}</flux:table.column>
                    <flux:table.column>{{ __('Permissions') }}</flux:table.column>
                    <flux:table.column class="text-end">{{ __('Actions') }}</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($team->roles as $role)
                        <flux:table.row :key="$role->id">
                            <flux:table.cell variant="strong">{{ $role->code }}</flux:table.cell>
                            <flux:table.cell>{{ $role->name ?? '-' }}</flux:table.cell>
                            <flux:table.cell>
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($role->permissions->take(5) as $perm)
                                        <flux:badge size="sm">{{ $perm->code }}</flux:badge>
                                    @endforeach
                                    @if ($role->permissions->count() > 5)
                                        <flux:badge size="sm">+{{ $role->permissions->count() - 5 }}</flux:badge>
                                    @endif
                                </div>
                            </flux:table.cell>
                            <flux:table.cell class="text-end">
                                <flux:button wire:click="openEditModal('{{ $role->id }}')" variant="ghost" size="sm">
                                    {{ __('Edit') }}
                                </flux:button>
                                @if (! in_array($role->code, ['admin', 'owner']))
                                    <flux:button
                                        wire:click="deleteRole('{{ $role->id }}')"
                                        wire:confirm="{{ __('Are you sure?') }}"
                                        variant="danger"
                                        size="sm"
                                    >
                                        {{ __('Delete') }}
                                    </flux:button>
                                @endif
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </x-teams::layout>

    <flux:modal wire:model="showModal" name="role-form" class="max-w-lg">
        <form wire:submit="save" class="space-y-4">
            <flux:heading size="lg">{{ $editingRoleId ? __('Edit role') : __('Add role') }}</flux:heading>
            <flux:input wire:model="code" label="{{ __('Code') }}" placeholder="e.g. editor" :disabled="(bool) $editingRoleId" required />
            <flux:input wire:model="name" label="{{ __('Name') }}" placeholder="{{ __('Display name') }}" />
            <flux:input wire:model="description" label="{{ __('Description') }}" />

            <div>
                <flux:subheading class="mb-2">{{ __('Permissions') }}</flux:subheading>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @foreach ($this->availablePermissions as $code => $label)
                        <flux:checkbox
                            wire:model="permissions"
                            value="{{ $code }}"
                            :label="$label"
                        />
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
