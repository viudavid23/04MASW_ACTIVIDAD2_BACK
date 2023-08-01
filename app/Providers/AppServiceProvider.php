<?php

namespace App\Providers;

use App\Exceptions\BadRequestException;
use App\Http\Contracts\PersonGateway;
use Illuminate\Support\ServiceProvider;
use App\Http\Contracts\ResidentGateway;
use App\Http\Services\Implementations\PersonGatewayImpl;
use App\Http\Services\Implementations\ResidentGatewayImpl;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ResidentGateway::class, ResidentGatewayImpl::class);
        $this->app->bind(PersonGateway::class, PersonGatewayImpl::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
