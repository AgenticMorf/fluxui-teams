<div>
    <x-teams::layout
        :team="$team"
        :heading="$team->name"
        :subheading="__('Team overview')"
        :breadcrumbs="[
            ['label' => __('Teams'), 'href' => route(config('fluxui-teams.route_name_prefix').'index')],
            ['label' => $team->name, 'href' => null],
        ]"
    >
        <flux:card>
            <flux:heading size="lg">{{ __('Details') }}</flux:heading>
            <flux:subheading>{{ __('Owner') }}: {{ $team->owner?->name ?? '-' }}</flux:subheading>
            <flux:text>{{ __('Members') }}: {{ $team->allUsers()->count() }}</flux:text>

            <div class="mt-4 flex gap-2">
                @can('update', $team)
                    <flux:button :href="route(config('fluxui-teams.route_name_prefix').'edit', $team)" variant="primary" wire:navigate>
                        {{ __('Edit') }}
                    </flux:button>
                @endcan
                <flux:button :href="route(config('fluxui-teams.route_name_prefix').'members.index', $team)" variant="outline" wire:navigate>
                    {{ __('Members') }}
                </flux:button>
                <flux:button :href="route(config('fluxui-teams.route_name_prefix').'roles.index', $team)" variant="outline" wire:navigate>
                    {{ __('Roles') }}
                </flux:button>
                <flux:button :href="route(config('fluxui-teams.route_name_prefix').'groups.index', $team)" variant="outline" wire:navigate>
                    {{ __('Groups') }}
                </flux:button>
            </div>
        </flux:card>

        @if ($this->teamEntities->isNotEmpty())
            <flux:card class="mt-6">
                <flux:heading size="lg">{{ __('Entities owned by this team') }}</flux:heading>
                <flux:table class="mt-4">
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
            </flux:card>
        @endif
    </x-teams::layout>
</div>
