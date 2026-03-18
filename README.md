# christhompsontldr/fluxui-teams

FluX UI for [Jurager Teams](https://github.com/jurager/teams) — Livewire components and Blade views for team management.

## Requirements

- PHP ^8.2
- Laravel ^11.0|^12.0
- Livewire ^3.0|^4.0
- [livewire/flux](https://fluxui.dev) ^2.0
- [jurager/teams](https://github.com/jurager/teams) ^3.0

## Installation

```bash
composer require christhompsontldr/fluxui-teams
```

## Configuration

Publish the config:

```bash
php artisan vendor:publish --tag=fluxui-teams-config
```

Configure `config/fluxui-teams.php`:

- **layout** — Livewire layout (default: `components.layouts.app.sidebar`)
- **route_prefix** — URL prefix (default: `teams`)
- **route_name_prefix** — Route name prefix (default: `teams.`)
- **permissions_config_key** — Config key for permission codes
- **default_roles_config_key** — Config key for default role permissions
- **team_entities_callback** — Optional callback returning entities owned by a team (e.g. bases)

## Blade Overrides

Views use the `teams::` namespace (e.g. `teams::layout`, `teams::team-index`). Publish to override:

```bash
php artisan vendor:publish --tag=fluxui-teams-views
```

Published views go to `resources/views/vendor/fluxui-teams/` and take precedence.

## Routes

The package registers these routes (with `web` and `auth` middleware):

- `GET /teams` — Team index
- `GET /teams/create` — Create team
- `GET /teams/{team}` — Team show
- `GET /teams/{team}/edit` — Edit team
- `GET /teams/{team}/members` — Members
- `GET /teams/{team}/roles` — Roles
- `GET /teams/{team}/permissions` — Permissions
- `GET /teams/{team}/groups` — Groups
- `GET /teams/{team}/abilities` — Abilities
- `GET /teams/{team}/invitations` — Invitations

## License

MIT
