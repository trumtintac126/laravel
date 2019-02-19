<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2/19/2019
 * Time: 11:08 AM
 */

namespace Core\Providers;


use Core\Services\ServiceInterface;
use Core\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Core\Repositories\UserRepository;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind(
            RepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            ServiceInterface::class,
            UserService::class

        );
    }
}