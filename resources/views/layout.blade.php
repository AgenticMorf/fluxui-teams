@props([
    'team' => null,
    'heading' => '',
    'subheading' => '',
    'breadcrumbs' => [],
])

<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item :href="route(config('fluxui-teams.route_name_prefix').'index')" wire:navigate>{{ __('Teams') }}</flux:navlist.item>
            @if ($team)
                <flux:navlist.item :href="route(config('fluxui-teams.route_name_prefix').'show', $team)" wire:navigate>{{ $team->name }}</flux:navlist.item>
                <flux:navlist.item :href="route(config('fluxui-teams.route_name_prefix').'members.index', $team)" wire:navigate>{{ __('Members') }}</flux:navlist.item>
                <flux:navlist.item :href="route(config('fluxui-teams.route_name_prefix').'roles.index', $team)" wire:navigate>{{ __('Roles') }}</flux:navlist.item>
                <flux:navlist.item :href="route(config('fluxui-teams.route_name_prefix').'groups.index', $team)" wire:navigate>{{ __('Groups') }}</flux:navlist.item>
                <flux:navlist.item :href="route(config('fluxui-teams.route_name_prefix').'abilities.index', $team)" wire:navigate>{{ __('Abilities') }}</flux:navlist.item>
                <flux:navlist.item :href="route(config('fluxui-teams.route_name_prefix').'invitations.index', $team)" wire:navigate>{{ __('Invitations') }}</flux:navlist.item>
            @endif
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        @if (count($breadcrumbs) > 0)
            <flux:breadcrumbs class="mb-2">
                @foreach ($breadcrumbs as $item)
                    @if (! empty($item['href']))
                        <flux:breadcrumbs.item :href="$item['href']" separator="slash" wire:navigate>
                            {{ $item['label'] }}
                        </flux:breadcrumbs.item>
                    @else
                        <flux:breadcrumbs.item :href="null" separator="slash">
                            {{ $item['label'] }}
                        </flux:breadcrumbs.item>
                    @endif
                @endforeach
            </flux:breadcrumbs>
        @endif
        <flux:heading>{{ $heading }}</flux:heading>
        <flux:subheading>{{ $subheading }}</flux:subheading>

        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>
</div>
