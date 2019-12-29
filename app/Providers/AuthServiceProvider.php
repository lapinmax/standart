<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('horoscopes', function ($user) {
            return $user->isAdmin() || $user->horoscopes;
        });

        Gate::define('clients', function ($user) {
            return $user->isAdmin() || $user->clients;
        });

        Gate::define('chats', function ($user) {
            return $user->isAdmin() || $user->chats;
        });

        Gate::define('templates', function ($user) {
            return $user->isAdmin() || $user->templates;
        });

        Gate::define('users', function ($user) {
            return $user->isAdmin() || $user->users;
        });

        Gate::define('rules', function ($user) {
            return $user->isAdmin() || $user->rules;
        });
    }
}
