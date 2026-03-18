<?php

namespace AgenticMorf\FluxUITeams;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FluxUITeamsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/fluxui-teams.php', 'fluxui-teams');
    }

    public function boot(): void
    {
        $paths = [__DIR__.'/../resources/views'];
        $published = $this->app->resourcePath('views/vendor/fluxui-teams');
        if (is_dir($published)) {
            array_unshift($paths, $published);
        }
        $this->loadViewsFrom($paths, 'teams');

        Blade::component('teams::layout', 'teams::layout');

        $this->app['router']->bind('team', function (string $value) {
            return config('teams.models.team')::findOrFail($value);
        });

        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/fluxui-teams.php' => config_path('fluxui-teams.php'),
            ], 'fluxui-teams-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/fluxui-teams'),
            ], 'fluxui-teams-views');
        }
    }

    protected function registerRoutes(): void
    {
        Route::middleware(config('fluxui-teams.middleware', ['web', 'auth']))
            ->prefix(config('fluxui-teams.route_prefix', 'teams'))
            ->name(config('fluxui-teams.route_name_prefix', 'teams.'))
            ->group(function () {
                Route::get('/', Livewire\TeamIndex::class)->name('index');
                Route::get('/create', Livewire\TeamForm::class)->name('create');
                Route::get('/{team}', Livewire\TeamShow::class)->name('show');
                Route::get('/{team}/edit', Livewire\TeamForm::class)->name('edit');
                Route::get('/{team}/members', Livewire\Members\MemberIndex::class)->name('members.index');
                Route::get('/{team}/roles', Livewire\Roles\RoleIndex::class)->name('roles.index');
                Route::get('/{team}/permissions', Livewire\Permissions\PermissionIndex::class)->name('permissions.index');
                Route::get('/{team}/groups', Livewire\Groups\GroupIndex::class)->name('groups.index');
                Route::get('/{team}/abilities', Livewire\Abilities\AbilityIndex::class)->name('abilities.index');
                Route::get('/{team}/invitations', Livewire\Invitations\InvitationIndex::class)->name('invitations.index');
            });
    }
}
