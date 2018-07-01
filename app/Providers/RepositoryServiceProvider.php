<?php

namespace ImageGallery\Providers;

use Illuminate\Support\ServiceProvider;
use ImageGallery\Repositories\Login\LoginRepository;
use ImageGallery\Repositories\Login\LoginRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        LoginRepositoryInterface::class => LoginRepository::class
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
