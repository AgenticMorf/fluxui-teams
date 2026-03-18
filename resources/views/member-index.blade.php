<div>
    <x-teams::layout
        :team="$team"
        heading="{{ __('Members') }}"
        :subheading="__('Manage team members')"
        :breadcrumbs="[
            ['label' => __('Teams'), 'href' => route(config('fluxui-teams.route_name_prefix').'index')],
            ['label' => $team->name, 'href' => route(config('fluxui-teams.route_name_prefix').'show', $team)],
            ['label' => __('Members'), 'href' => null],
        ]"
    >
        <flux:card>
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">{{ __('Team members') }}</flux:heading>
                @can('addTeamMember', $team)
                    <flux:button wire:click="openInviteModal" variant="primary" icon="plus">
                        {{ __('Invite') }}
                    </flux:button>
                @endcan
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>{{ __('Name') }}</flux:table.column>
                    <flux:table.column>{{ __('Email') }}</flux:table.column>
                    <flux:table.column>{{ __('Role') }}</flux:table.column>
                    @can('updateTeamMember', $team)
                        <flux:table.column class="text-end">{{ __('Actions') }}</flux:table.column>
                    @endcan
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($team->allUsers() as $user)
                        <flux:table.row :key="$user->id">
                            <flux:table.cell variant="strong">{{ $user->name }}</flux:table.cell>
                            <flux:table.cell>{{ $user->email }}</flux:table.cell>
                            <flux:table.cell>
                                @if ((string) $team->user_id === (string) $user->id)
                                    <flux:badge color="blue">{{ __('Owner') }}</flux:badge>
                                @else
                                    {{ $team->userRole($user)?->name ?? '-' }}
                                @endif
                            </flux:table.cell>
                            @can('updateTeamMember', $team)
                                <flux:table.cell class="text-end">
                                    @if ((string) $team->user_id !== (string) $user->id)
                                        <flux:select wire:change="updateRole('{{ $user->id }}', $event.target.value)">
                                            <option value="admin" @selected(($team->userRole($user)?->code ?? null) === 'admin')>Admin</option>
                                            <option value="member" @selected(($team->userRole($user)?->code ?? 'member') === 'member')>Member</option>
                                        </flux:select>
                                        <flux:button
                                            wire:click="removeMember('{{ $user->id }}')"
                                            wire:confirm="{{ __('Are you sure?') }}"
                                            variant="danger"
                                            size="sm"
                                        >
                                            {{ __('Remove') }}
                                        </flux:button>
                                    @endif
                                </flux:table.cell>
                            @endcan
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </x-teams::layout>

    @can('addTeamMember', $team)
        <flux:modal wire:model="showInviteModal" name="invite-member" class="max-w-md">
            <form wire:submit="inviteUser" class="space-y-4">
                <flux:heading size="lg">{{ __('Invite by email') }}</flux:heading>
                <flux:input wire:model="email" type="email" label="{{ __('Email') }}" required />
                <flux:select wire:model="role" label="{{ __('Role') }}">
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                </flux:select>
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">{{ __('Send invitation') }}</flux:button>
                    <flux:button type="button" variant="ghost" wire:click="$set('showInviteModal', false)">
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    @endcan
</div>
