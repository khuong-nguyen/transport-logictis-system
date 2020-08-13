<?php

namespace App\Providers;

use App\BookingConsignee;
use App\ContainerBooking;
use App\ForwarderBooking;
use App\Repositories\BookingContainerRepository;
use App\Repositories\Eloquent\EloquentBookingContainerRepository;
use App\ShipperBooking;
use App\Customer;
use App\Booking;
use App\Container;
use App\Repositories\Eloquent\EloquentConsigneeBookingRepository;
use App\Repositories\Eloquent\EloquentForwarderBookingRepository;
use App\Repositories\Eloquent\EloquentShipperBookingRepository;
use App\Repositories\Eloquent\EloquentCustomerRepository;
use App\Repositories\Eloquent\EloquentBookingRepository;
use App\Repositories\ForwarderBookingRepository;
use App\Repositories\Eloquent\EloquentContainerRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ConsigneeBookingRepository;
use App\Repositories\ShipperBookingRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\BookingRepository;
use App\Repositories\ContainerRepository;

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
        $this->app->bind(
            ConsigneeBookingRepository::class,
            function () {
                return new EloquentConsigneeBookingRepository(new BookingConsignee());
            }
        );
        $this->app->bind(
            ShipperBookingRepository::class,
            function () {
                return new EloquentShipperBookingRepository(new ShipperBooking());
            }
        );
        $this->app->bind(
            ForwarderBookingRepository::class,
            function () {
                return new EloquentForwarderBookingRepository(new ForwarderBooking());
            }
        );

        $this->app->bind(
            BookingContainerRepository::class,
            function () {
                return new EloquentBookingContainerRepository(new ContainerBooking());
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
