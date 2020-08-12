<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CustomerRepository;
use App\Repositories\BookingRepository;
use App\Repositories\ContainerRepository;
use App\Repositories\Eloquent\EloquentCustomerRepository;
use App\Repositories\Eloquent\EloquentBookingRepository;
use App\Repositories\Eloquent\EloquentContainerRepository;
use App\Customer;
use App\Booking;
use App\Container;

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
            CustomerRepository::class,
            function () {
                return  new EloquentCustomerRepository(new Customer());
            }
        );

        $this->app->bind(
            BookingRepository::class,
            function () {
                return new EloquentBookingRepository(new Booking());
            }
        );

        $this->app->bind(
            ContainerRepository::class,
            function () {
                return new EloquentContainerRepository(new Container());
            }
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
