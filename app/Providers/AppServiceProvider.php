<?php

namespace App\Providers;

use App\Contracts\Auth\UserServiceContract;
use App\Contracts\User\SignInstructionContract;
use App\Services\Auth\UserService;
use App\Services\User\SignInstructionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(SignInstructionContract::class, SignInstructionService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
