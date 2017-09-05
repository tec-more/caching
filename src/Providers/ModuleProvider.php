<?php namespace Tukecx\Base\Caching\Providers;

use Illuminate\Support\ServiceProvider;
use Tukecx\Base\Caching\Services\CacheItemPool;
use Tukecx\Base\Caching\Services\CacheService;
use Tukecx\Base\Caching\Services\Contracts\CacheItemPoolContract;
use Tukecx\Base\Caching\Services\Contracts\CacheServiceContract;
use Illuminate\Contracts\Cache\Repository as LaravelRepositoryCacheContract;

class ModuleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Load views*/
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'tukecx-caching');
        /*Load translations*/
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'tukecx-caching');

        \Event::listen(['cache:cleared'], function () {
            \File::delete(config('tukecx-caching.repository.store_keys'));
            \File::delete(storage_path('framework/cache/cache-service.json'));
        });

        $this->publishes([
            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/vendor/tukecx-caching',
        ], 'views');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => base_path('resources/lang/vendor/tukecx-caching'),
        ], 'lang');
        $this->publishes([
            __DIR__ . '/../../config' => base_path('config'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(BootstrapModuleServiceProvider::class);

        $this->mergeConfigFrom(__DIR__ . '/../../config/tukecx-caching.php', 'tukecx-caching');

        //Bind some services
        $this->app->bind(CacheItemPoolContract::class, function () {
            return new CacheItemPool($this->app->make(LaravelRepositoryCacheContract::class));
        });
        $this->app->bind(CacheServiceContract::class, CacheService::class);
    }
}
