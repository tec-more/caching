<?php namespace Tukecx\Base\Caching\Http\Controllers;

use Tukecx\Base\Core\Http\Controllers\BaseAdminController;

class CachingController extends BaseAdminController
{
    protected $module = 'tukecx-caching';

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addLink('缓存', route('admin::tukecx-caching.index.get'));

        $this->getDashboardMenu($this->module);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $this->setPageTitle('缓存管理', '管理所有CMS缓存');

        $this->assets->addJavascripts('jquery-datatables');

        return do_filter('tukecx-caching.index.get', $this)->viewAdmin('index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getClearCmsCache()
    {
        \Artisan::call('cache:clear');

        $this->flashMessagesHelper
            ->addMessages('Cache cleaned', 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('admin::tukecx-caching.index.get'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRefreshCompiledViews()
    {
        \Artisan::call('view:clear');

        $this->flashMessagesHelper
            ->addMessages('Views refreshed', 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('admin::tukecx-caching.index.get'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCreateConfigCache()
    {
        \Artisan::call('config:cache');

        $this->flashMessagesHelper
            ->addMessages('Config cache created', 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('admin::tukecx-caching.index.get'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getClearConfigCache()
    {
        \Artisan::call('config:clear');

        $this->flashMessagesHelper
            ->addMessages('Config cache cleared', 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('admin::tukecx-caching.index.get'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getOptimizeClass()
    {
        \Artisan::call('optimize');

        $this->flashMessagesHelper
            ->addMessages('Generated optimized class loader', 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('admin::tukecx-caching.index.get'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getClearCompiledClass()
    {
        \Artisan::call('clear-compiled');

        $this->flashMessagesHelper
            ->addMessages('Optimized class loader cleared', 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('admin::tukecx-caching.index.get'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCreateRouteCache()
    {
        \Artisan::call('route:cache');

        $this->flashMessagesHelper
            ->addMessages('Route cache created', 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('admin::tukecx-caching.index.get'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getClearRouteCache()
    {
        \Artisan::call('route:clear');

        $this->flashMessagesHelper
            ->addMessages('Route cache cleared', 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('admin::tukecx-caching.index.get'));
    }
}
