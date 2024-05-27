<?php

namespace App\Providers;

use App\Repositories\Interfaces\ItemRepoInterface;
use App\Repositories\ItemRepo;
use App\Usecase\Interfaces\ItemUsecaseInterface;
use App\Usecase\ItemUsecase;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ItemRepoInterface::class,
            function (Application $app) {
                return $app->make(ItemRepo::class, ['path' => '/database/data.json']);
            }
        );

        $this->app->bind(
            ItemUsecaseInterface::class,
            ItemUsecase::class
        );
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
