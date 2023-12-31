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
        // 開発者のみ許可
        Gate::define('superadmin', function ($user) {
            return ($user->role == 2);
        });
        // 店舗代表者のみ許可
        Gate::define('admin', function ($user) {
            return ($user->role == 1);
        });
        // 一般ユーザに許可
        Gate::define('user', function ($user) {
        return ($user->role == 0);
        });

        // 一般ユーザ,店舗代表者に許可
        Gate::define('user_or_superadmin', function ($user) {
            return in_array($user->role, [0, 2]);
            });
    }
}