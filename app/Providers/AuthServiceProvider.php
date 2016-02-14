<?php
/**
 * Author: Paul Bardack paul.bardack@gmail.com http://paulbardack.com
 * Date: 14.02.16
 * Time: 19:43
 */

namespace App\Providers;

use Illuminate\Auth\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Gate::define('create-locale', function ($user) {
            return $user->role === 'admin';
        });
        Gate::define('create-user', function ($user) {
            return $user->role === 'admin';
        });
    }
}
