<?php

namespace App\Providers;

use App\Repositories\CustomerRepository;
use App\Repositories\Eloquent\EloquentCustomerRepository;
use App\Customer;

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
        //
        $this->app->bind(
            CustomerRepository::class,
            function () {
                return  new EloquentCustomerRepository(new Customer());
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
