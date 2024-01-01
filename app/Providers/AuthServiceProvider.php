<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->role->name == 'Admin';
        });
        Gate::define('isPimpinan', function ($user) {
            return $user->role->name == 'Pimpinan';
        });
        Gate::define('isStaff', function ($user) {
            return $user->role->name == 'Staff';
        });
        Gate::define('isDosen', function ($user, $post) {
            return $user->role->name == 'Dosen';
        });

        Gate::define('isAdminOrStaff', function ($user) {
            return $user->role->name == 'Admin' || $user->role->name == 'Staff';
        });
    }
}
