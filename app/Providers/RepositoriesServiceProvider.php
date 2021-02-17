<?php


namespace App\Providers;


use App\Interfaces\ImportFileRepositoryInterface;
use App\Interfaces\LogRepositoryInterface;
use App\Repositories\ImportFileRepository;
use App\Repositories\LogRepository;
use App\Repositories\ReportRepository;
use App\Repositories\ReportRepositoryInterface;

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

        $this->app->bind(
            ImportFileRepositoryInterface::class,
            ImportFileRepository::class
        );

        $this->app->bind(
            ReportRepositoryInterface::class,
            ReportRepository::class
        );
    }
}
