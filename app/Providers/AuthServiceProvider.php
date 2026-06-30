<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create-permission', function ($user) {
            return ($user->role == "admin") ?
                Response::allow() :
                Response::deny("Only admins are allowed");
        });

        Gate::define('update-permission', function ($user) {
            return ($user->role == "admin") ?
                Response::allow() :
                Response::deny("Only admins are allowed");
        });

        Gate::define('delete-permission', function ($user) {
            return ($user->role == "admin") ?
                Response::allow() :
                Response::deny("Only admins are allowed");
        });
    }
}