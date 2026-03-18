<div>
    <x-teams::layout
        :team="$team"
        heading="{{ __('Permissions') }}"
        :subheading="__('Permission reference for this team')"
        :breadcrumbs="[
            ['label' => __('Teams'), 'href' => route(config('fluxui-teams.route_name_prefix').'index')],
            ['label' => $team->name, 'href' => route(config('fluxui-teams.route_name_prefix').'show', $team)],
            ['label' => __('Permissions'), 'href' => null],
        ]"
    >
        <flux:card>
            <flux:heading size="lg">{{ __('All permissions') }}</flux:heading>
            <flux:subheading class="mb-4">{{ __('Permissions used in roles and groups') }}</flux:subheading>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>{{ __('Code') }}</flux:table.column>
                    <flux:table.column>{{ __('Used in') }}</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($team->permissions as $permission)
                        <flux:table.row :key="$permission->id">
                            <flux:table.cell variant="strong">{{ $permission->code }}</flux:table.cell>
                            <flux:table.cell>
                                @php
                                    $usedIn = $permission->roles->map(fn ($r) => 'Role: ' . $r->name)
                                        ->merge($permission->groups->map(fn ($g) => 'Group: ' . $g->name));
                                @endphp
                                {{ $usedIn->implode(', ') ?: '-' }}
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>

            @if ($team->permissions->isEmpty())
                <flux:text variant="subtle">{{ __('No permissions defined yet. Add roles or groups to create permissions.') }}</flux:text>
            @endif
        </flux:card>
    </x-teams::layout>
</div>
