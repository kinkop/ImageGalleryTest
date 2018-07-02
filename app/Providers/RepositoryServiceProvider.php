<?php

namespace ImageGallery\Providers;

use Illuminate\Support\ServiceProvider;
use ImageGallery\Repositories\ImageUpload\ImageUploadRepository;
use ImageGallery\Repositories\ImageUpload\ImageUploadRepositoryInterface;
use ImageGallery\Repositories\Login\LoginRepository;
use ImageGallery\Repositories\Login\LoginRepositoryInterface;
use ImageGallery\Repositories\User\UserRepository;
use ImageGallery\Repositories\User\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        LoginRepositoryInterface::class => LoginRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        ImageUploadRepositoryInterface::class => ImageUploadRepository::class
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
