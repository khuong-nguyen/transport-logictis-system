<?php

namespace App\Providers;

use App\Repositories\CustomerRepository;
use App\Repositories\Eloquent\EloquentCustomerRepository;
use App\Customer;

use App\Repositories\EmployeeRepository;
use App\Repositories\Eloquent\EloquentEmployeeRepository;
use App\Employee;

use App\Repositories\FixedAssetRepository;
use App\Repositories\Eloquent\EloquentFixedAssetRepository;
use App\FixedAsset;

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
        
        $this->app->bind(
            EmployeeRepository::class,
            function () {
                return  new EloquentEmployeeRepository(new Employee());
            }
        );
        
        $this->app->bind(
            FixedAssetRepository::class,
            function () {
                return  new EloquentFixedAssetRepository(new FixedAsset());
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
