<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {

        Gate::define('has-permission', function ($user, $action) {
            // TODO: get user permissions
            return 'aaa' == $action;
        });

        Gate::define('owns-resource', function ($user, $resource) {
            $users = $resource->users;
            if($users && count($users) > 0) {
                return collect($users)->search(function ($item, $key) use($user) {
                    return $item->id == $user->id;
                }) !== false;
            }
            return false;
        });

        $this->app['auth']->viaRequest('api', function ($request) {
            $api_token = $request->bearerToken();
            if ($api_token) {
                return User::where('api_token', $api_token)->first();
            }
        });

    }
}
