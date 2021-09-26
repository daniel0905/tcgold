<?php

namespace App\Providers;

use App\Repository\Parcel\ParcelRepository;
use App\Repository\Parcel\ParcelRepositoryImpl;
use App\Service\Parcel\ParcelService;
use App\Service\Parcel\ParcelServiceImpl;
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
