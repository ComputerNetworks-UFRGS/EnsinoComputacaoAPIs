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

        $this->setGates();

        $this->app['auth']->viaRequest('api', function ($request) {
            $api_token = $request->bearerToken();
            if ($api_token) {
                return User::where('api_token', $api_token)->first();
            }
        });

    }


    private function setGates()
    {
        Gate::define('has-permission', function ($user, $action) {
            $role = $user->role;
            if($role) {
                $permissions = $role->permissions;
                if(count($permissions) > 0) {
                    return $permissions->pluck('code')->contains($action);
                }
            }
            return false;
        });

        //
        // TODO: controle de acesso a recursos específicos...
        //
        // Gate::define('owns-resource', function ($user, $resource) {
        //     $users = $resource->users;
        //     if($users && count($users) > 0) {
        //         return collect($users)->search(function ($item, $key) use($user) {
        //             return $item->id == $user->id;
        //         }) !== false;
        //     }
        //     return false;
        // });
    }
}
