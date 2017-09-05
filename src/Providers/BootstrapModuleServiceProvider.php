<?php namespace Tukecx\Base\Caching\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'Tukecx\Base\Caching';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        $this->registerMenu();
    }

    private function registerMenu()
    {
        \DashboardMenu::registerItem([
            'id' => 'tukecx-caching',
            'priority' => 2,
            'parent_id' => 'tukecx-configuration',
            'heading' => null,
            'title' => '缓存',
            'font_icon' => 'fa fa-circle-o',
            'link' => route('admin::tukecx-caching.index.get'),
            'css_class' => null,
            'permissions' => ['view-cache'],
        ]);
    }
}
