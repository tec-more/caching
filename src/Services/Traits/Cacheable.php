<?php namespace Tukecx\Base\Caching\Services\Traits;

trait Cacheable
{
    /**
     * Determine when enabled cache for query
     * @var bool
     */
    protected $cacheEnabled;

    /**
     * @return bool
     */
    public function isUseCache()
    {
        return !!$this->cacheEnabled;
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function withCache($bool = true)
    {
        $this->cacheEnabled = !!$bool;

        return $this;
    }
}
