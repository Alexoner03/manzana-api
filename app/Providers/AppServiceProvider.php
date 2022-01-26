<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Food\Domain\Contracts\FoodRepositoryContract;
use Src\Food\Infraestructure\Repositories\FoodEloquentRepository;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Infraestructure\Repositories\UserEloquentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class,UserEloquentRepository::class);
        $this->app->bind(FoodRepositoryContract::class,FoodEloquentRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('app.env') == "production")
        {
            \URL::forceScheme("https");
        }
    }
}
