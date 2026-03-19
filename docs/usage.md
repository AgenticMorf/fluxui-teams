---
title: Usage
---

# Usage

## Routes

The package registers (with `web` and `auth` middleware):

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

## Sidebar

Add a Teams nav item in your sidebar pointing to `route('teams.index')`.
