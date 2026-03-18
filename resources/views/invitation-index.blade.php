<div>
    <x-teams::layout
        :team="$team"
        heading="{{ __('Invitations') }}"
        :subheading="__('Pending team invitations')"
        :breadcrumbs="[
            ['label' => __('Teams'), 'href' => route(config('fluxui-teams.route_name_prefix').'index')],
            ['label' => $team->name, 'href' => route(config('fluxui-teams.route_name_prefix').'show', $team)],
            ['label' => __('Invitations'), 'href' => null],
        ]"
    >
        <flux:card>
            <flux:heading size="lg">{{ __('Pending invitations') }}</flux:heading>

            @if ($team->invitations->isEmpty())
                <flux:text variant="subtle" class="mt-2">{{ __('No pending invitations.') }}</flux:text>
            @else
                <flux:table class="mt-4">
                    <flux:table.columns>
                        <flux:table.column>{{ __('Email') }}</flux:table.column>
                        <flux:table.column>{{ __('Role') }}</flux:table.column>
                        <flux:table.column>{{ __('Invited') }}</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @foreach ($team->invitations as $invitation)
                            <flux:table.row :key="$invitation->id">
                                <flux:table.cell variant="strong">{{ $invitation->email }}</flux:table.cell>
                                <flux:table.cell>{{ $invitation->role?->name ?? '-' }}</flux:table.cell>
                                <flux:table.cell>{{ $invitation->created_at?->diffForHumans() ?? '-' }}</flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            @endif
        </flux:card>
    </x-teams::layout>
</div>
