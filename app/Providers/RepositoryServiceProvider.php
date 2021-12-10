<?php

namespace App\Providers;

use App\Repositories\Contracts\ICategoryRepository;
use App\Repositories\Contracts\IProductRepository;
use App\Repositories\Contracts\IRepository;
use App\Repositories\Contracts\IRoleRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IVariationRepository;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\VariationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IRepository::class, BaseRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(IVariationRepository::class, VariationRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
