<?php

namespace App\Providers;

use App\Contracts\Auth\UserServiceContract;
use App\Contracts\Manager\ManagerRecordServiceContract;
use App\Contracts\User\UserRecordServiceContract;
use App\Contracts\User\SignInstructionContract;
use App\Services\Auth\UserService;
use App\Services\Manager\ManagerRecordService;
use App\Services\User\UserRecordService;
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
        //Service binding operations
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(SignInstructionContract::class, SignInstructionService::class);
        $this->app->bind(UserRecordServiceContract::class, UserRecordService::class);
        $this->app->bind(ManagerRecordServiceContract::class, ManagerRecordService::class);
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
