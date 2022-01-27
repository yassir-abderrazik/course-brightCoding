<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Post' => 'App\Policies\PostPolicy',
        'App\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::resource('post', 'App\Policies\PostPolicy');

        Gate::define('secret.page', function($user){
            return $user->is_admin;
        });
        // Gate::define("postDelete", function($user, $post){
        //     return $user->id === $post->user_id;
        // });
        // Gate::before(function($user, $ability){
        //     if($user->is_admin && in_array($ability, ["update"]) ){
        //         return true;
        //     }
        // });
        
    }
}