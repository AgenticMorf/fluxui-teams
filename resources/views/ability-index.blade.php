<div>
    <x-teams::layout
        :team="$team"
        heading="{{ __('Abilities') }}"
        :subheading="__('Entity-level permissions')"
        :breadcrumbs="[
            ['label' => __('Teams'), 'href' => route(config('fluxui-teams.route_name_prefix').'index')],
            ['label' => $team->name, 'href' => route(config('fluxui-teams.route_name_prefix').'show', $team)],
            ['label' => __('Abilities'), 'href' => null],
        ]"
    >
        <flux:card>
            <flux:heading size="lg">{{ __('Abilities') }}</flux:heading>
            <flux:subheading class="mb-4">{{ __('Entity-level abilities allow granting or forbidding specific actions on specific resources (e.g. Base, Document).') }}</flux:subheading>

            <flux:text variant="subtle">
                {{ __('Use $user->allowTeamAbility($team, $action, $entity) or $user->forbidTeamAbility($team, $action, $entity) in your application code.') }}
            </flux:text>

            @if ($this->teamEntities->isNotEmpty())
                <flux:heading size="sm" class="mt-6">{{ __('Entities owned by this team') }}</flux:heading>
                <flux:table class="mt-2">
                    <flux:table.columns>
                        <flux:table.column>{{ __('Name') }}</flux:table.column>
                        <flux:table.column>{{ __('ID') }}</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @foreach ($this->teamEntities as $entity)
                            <flux:table.row :key="$entity->id">
                                <flux:table.cell>{{ $entity->name }}</flux:table.cell>
                                <flux:table.cell>{{ $entity->id }}</flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            @endif
        </flux:card>
    </x-teams::layout>
</div>
