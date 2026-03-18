<div>
    <x-teams::layout
        :team="$team"
        :heading="$teamId ? __('Edit team') : __('Create team')"
        :subheading="$teamId ? __('Update team details') : __('Create a new team')"
        :breadcrumbs="$teamId
            ? [
                ['label' => __('Teams'), 'href' => route(config('fluxui-teams.route_name_prefix').'index')],
                ['label' => $team->name, 'href' => route(config('fluxui-teams.route_name_prefix').'show', $team)],
                ['label' => __('Edit'), 'href' => null],
              ]
            : [
                ['label' => __('Teams'), 'href' => route(config('fluxui-teams.route_name_prefix').'index')],
                ['label' => __('Create'), 'href' => null],
              ]"
    >
        <flux:card>
            <form wire:submit="save" class="space-y-4">
                <flux:input
                    wire:model="name"
                    label="{{ __('Team name') }}"
                    placeholder="{{ __('e.g. Engineering') }}"
                    required
                />

                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">
                        {{ $teamId ? __('Save') : __('Create') }}
                    </flux:button>
                    <flux:button :href="$teamId ? route(config('fluxui-teams.route_name_prefix').'show', $teamId) : route(config('fluxui-teams.route_name_prefix').'index')" variant="ghost" wire:navigate>
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </x-teams::layout>
</div>
