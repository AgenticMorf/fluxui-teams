<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    | The Livewire layout component used for teams pages.
    */
    'layout' => 'components.layouts.app.sidebar',

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    */
    'route_prefix' => 'teams',
    'route_name_prefix' => 'teams.',
    'middleware' => ['web', 'auth'],

    /*
    |--------------------------------------------------------------------------
    | Permissions Config Key
    |--------------------------------------------------------------------------
    | Config key for permission codes (used in roles/groups UI).
    */
    'permissions_config_key' => 'permissions.codes',

    /*
    |--------------------------------------------------------------------------
    | Default Roles Config Key
    |--------------------------------------------------------------------------
    */
    'default_roles_config_key' => 'permissions.default_roles',

    /*
    |--------------------------------------------------------------------------
    | Team Entities Callback
    |--------------------------------------------------------------------------
    | Optional. Returns entities (e.g. bases) owned by a team for display.
    | Signature: fn(object $team): \Illuminate\Support\Collection
    */
    'team_entities_callback' => null,
];
