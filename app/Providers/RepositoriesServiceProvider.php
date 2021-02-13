<?php


namespace App\Providers;


use App\Interfaces\LogRepositoryInterface;
use App\Repositories\LogRepository;

class RepositoriesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the repositories/interfaces
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            LogRepositoryInterface::class,
            LogRepository::class
        );
    }
}
