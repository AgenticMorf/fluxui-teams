<div>
    <x-teams::layout
        heading="{{ __('Teams') }}"
        subheading="{{ __('Manage your teams') }}"
        :breadcrumbs="[['label' => __('Teams'), 'href' => null]]"
    >
        <flux:card>
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">{{ __('Your teams') }}</flux:heading>
                <flux:button :href="route(config('fluxui-teams.route_name_prefix').'create')" variant="primary" icon="plus" wire:navigate>
                    {{ __('Create team') }}
                </flux:button>
            </div>

            @if ($this->teams->isEmpty())
                <flux:text variant="subtle">{{ __('You have no teams yet. Create one to get started.') }}</flux:text>
            @else
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>{{ __('Name') }}</flux:table.column>
                        <flux:table.column>{{ __('Owner') }}</flux:table.column>
                        <flux:table.column>{{ __('Members') }}</flux:table.column>
                        <flux:table.column class="text-end">{{ __('Actions') }}</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @foreach ($this->teams as $team)
                            <flux:table.row :key="$team->id">
                                <flux:table.cell>
                                    <flux:link :href="route(config('fluxui-teams.route_name_prefix').'show', $team)" wire:navigate>{{ $team->name }}</flux:link>
                                </flux:table.cell>
                                <flux:table.cell>{{ $team->owner?->name ?? '-' }}</flux:table.cell>
                                <flux:table.cell>{{ $team->allUsers()->count() }}</flux:table.cell>
                                <flux:table.cell class="text-end">
                                    <flux:button :href="route(config('fluxui-teams.route_name_prefix').'show', $team)" variant="ghost" size="sm" wire:navigate>
                                        {{ __('View') }}
                                    </flux:button>
                                    @can('update', $team)
                                        <flux:button :href="route(config('fluxui-teams.route_name_prefix').'edit', $team)" variant="ghost" size="sm" wire:navigate>
                                            {{ __('Edit') }}
                                        </flux:button>
                                    @endcan
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            @endif
        </flux:card>
    </x-teams::layout>
</div>
