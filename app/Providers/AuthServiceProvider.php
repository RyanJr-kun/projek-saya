<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Definisikan Gate untuk admin di sini.
        // Ini adalah cara standar dan akan berfungsi di semua versi Laravel.
        Gate::define('is-admin', function (User $user) {
            // Asumsi role_id 1 adalah Admin.
            return $user->role_id === 1;
        });
    }
}
