<?php namespace Tukecx\Base\Caching\Services\Contracts;

interface CacheServiceContract
{
    /**
     * @param string $whereToSave
     * @return \Tukecx\Base\Caching\Services\CacheService
     */
    public function setCacheFile($whereToSave);

    /**
     * @return string
     */
    public function getCacheFile();

    /**
     * @param int $cacheLifetime
     * @return \Tukecx\Base\Caching\Services\CacheService
     */
    public function setCacheLifetime($cacheLifetime);

    /**
     * @return int
     */
    public function getCacheLifetime();

    /**
     * @param string $cacheDriver
     * @return \Tukecx\Base\Caching\Services\CacheService
     */
    public function setCacheDriver($cacheDriver);

    /**
     * @return string
     */
    public function getCacheDriver();

    /**
     * @param string $className
     * @param string $method
     * @param array $args
     * @return \Tukecx\Base\Caching\Services\CacheService
     */
    public function setCacheKey($method, $args);

    /**
     * @return string
     */
    public function getCacheKey();

    /**
     * @return \Tukecx\Base\Caching\Services\CacheService
     */
    public function resetCacheKey();

    /**
     * @return array
     */
    public function getCacheKeys();

    /**
     * Store cache key to file
     * @return \Tukecx\Base\Caching\Services\CacheService
     */
    public function storeCacheKey();

    /**
     * Try to retrieve data from cache
     * @param \Closure $closure
     * @return mixed
     */
    public function retrieveFromCache(\Closure $closure);

    /**
     * Reset all cache data
     * @return \Tukecx\Base\Caching\Services\CacheService
     */
    public function resetCache();

    /**
     * Flush cache of current class
     * @return array
     */
    public function flushCache();
}
