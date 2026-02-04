<?php

namespace App\Providers;

use App\Events\RegisteredAgentAssigned;
use App\Listeners\CheckAgentCapacityListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        RegisteredAgentAssigned::class => [
            SendEmailVerificationNotification::class,
            CheckAgentCapacityListener::class,
        ],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
