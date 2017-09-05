<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('tukecx.admin_route');

$moduleRoute = 'caching';

/**
 * Admin routes
 */
Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->get('', 'CachingController@getIndex')
        ->name('admin::tukecx-caching.index.get')
        ->middleware('has-permission:view-cache');

    $router->get('clear-cms-cache', 'CachingController@getClearCmsCache')
        ->name('admin::tukecx-caching.clear-cms-cache.get')
        ->middleware('has-permission:clear-cache');

    $router->get('refresh-compiled-views', 'CachingController@getRefreshCompiledViews')
        ->name('admin::tukecx-caching.refresh-compiled-views.get')
        ->middleware('has-permission:clear-cache');

    $router->get('create-config-cache', 'CachingController@getCreateConfigCache')
        ->name('admin::tukecx-caching.create-config-cache.get')
        ->middleware('has-permission:modify-cache');

    $router->get('clear-config-cache', 'CachingController@getClearConfigCache')
        ->name('admin::tukecx-caching.clear-config-cache.get')
        ->middleware('has-permission:clear-cache');

    $router->get('optimize-class', 'CachingController@getOptimizeClass')
        ->name('admin::tukecx-caching.optimize-class.get')
        ->middleware('has-permission:modify-cache');

    $router->get('clear-compiled-class', 'CachingController@getClearCompiledClass')
        ->name('admin::tukecx-caching.clear-compiled-class.get')
        ->middleware('has-permission:clear-cache');

    $router->get('create-route-cache', 'CachingController@getCreateRouteCache')
        ->name('admin::tukecx-caching.create-route-cache.get')
        ->middleware('has-permission:modify-cache');

    $router->get('clear-route-cache', 'CachingController@getClearRouteCache')
        ->name('admin::tukecx-caching.clear-route-cache.get')
        ->middleware('has-permission:clear-cache');
});
