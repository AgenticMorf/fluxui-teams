---
title: Configuration
---

# Configuration

Publish the config:

```bash
php artisan vendor:publish --tag=fluxui-teams-config
```

Edit `config/fluxui-teams.php`:

- **layout** — Livewire layout (default: `components.layouts.app.sidebar`)
- **route_prefix** — URL prefix (default: `teams`)
- **route_name_prefix** — Route name prefix (default: `teams.`)
- **middleware** — Route middleware (default: `web`, `auth`)
- **permissions_config_key** — Config key for permission codes
- **default_roles_config_key** — Config key for default role permissions
- **team_entities_callback** — Optional callback returning entities owned by a team (e.g. bases)

## Blade Overrides

Views use the `teams::` namespace. Publish to override:

```bash
php artisan vendor:publish --tag=fluxui-teams-views
```

Published views go to `resources/views/vendor/fluxui-teams/` and take precedence.
