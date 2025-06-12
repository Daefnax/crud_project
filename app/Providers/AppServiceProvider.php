<?php

namespace App\Providers;

use App\Services\Auth\LoginService;
use App\Services\Auth\SessionService;
use App\Services\ProfileService;
use App\Services\RegisterService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(LoginService::class, fn () => new LoginService());
        $this->app->singleton(SessionService::class, fn () => new SessionService());
        $this->app->singleton(RegisterService::class, fn () => new RegisterService());
        $this->app->singleton(ProfileService::class, fn () => new ProfileService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
