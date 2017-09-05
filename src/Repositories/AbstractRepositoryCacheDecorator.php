<?php namespace Tukecx\Base\Caching\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tukecx\Base\Caching\Repositories\Traits\RepositoryValidatableCache;
use Tukecx\Base\Core\Criterias\Contracts\CriteriaContract;
use Tukecx\Base\Core\Exceptions\Repositories\WrongCriteria;
use Tukecx\Base\Core\Models\Contracts\BaseModelContract;
use Tukecx\Base\Core\Repositories\AbstractBaseRepository;
use Tukecx\Base\Caching\Services\Contracts\CacheableContract;
use Tukecx\Base\Caching\Services\Traits\Cacheable;
use Tukecx\Base\Core\Repositories\Contracts\AbstractRepositoryContract;
use Tukecx\Base\Core\Repositories\Contracts\RepositoryValidatorContract;

abstract class AbstractRepositoryCacheDecorator implements AbstractRepositoryContract, CacheableContract, RepositoryValidatorContract
{
    use RepositoryValidatableCache;

    /**
     * @var AbstractBaseRepository|Cacheable
     */
    protected $repository;

    /**
     * @var \Tukecx\Base\Caching\Services\CacheService
     */
    protected $cache;

    /**
     * @param CacheableContract $repository
     */
    public function __construct(CacheableContract $repository)
    {
        $this->repository = $repository;

        $this->cache = app(\Tukecx\Base\Caching\Services\Contracts\CacheServiceContract::class);

        $this->cache
            ->setCacheObject($this->repository)
            ->setCacheLifetime(config('tukecx-caching.repository.lifetime'))
            ->setCacheFile(config('tukecx-caching.repository.store_keys'));
    }

    /**
     * @return bool
     */
    public function isUseCache()
    {
        return call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function withCache($bool = true)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @return AbstractBaseRepository|Cacheable
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return \Tukecx\Base\Caching\Services\CacheService
     */
    public function getCacheInstance()
    {
        return $this->cache;
    }

    /**
     * @param $lifetime
     * @return $this
     */
    public function setCacheLifetime($lifetime)
    {
        $this->cache->setCacheLifetime($lifetime);

        return $this;
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function beforeGet($method, $parameters)
    {
        $repository = clone $this->repository;

        $this->cache->setCacheKey($method, $parameters);

        /**
         * Clear params
         */
        $this->repository->resetModel();

        return $this->cache->retrieveFromCache(function () use ($repository, $method, $parameters) {
            return call_user_func_array([$repository, $method], $parameters);
        });
    }

    /**
     * @param $method
     * @param $parameters
     * @param bool $flushCache
     * @return mixed
     */
    public function afterUpdate($method, $parameters, $flushCache = true, $forceFlush = false)
    {
        $result = call_user_func_array([$this->repository, $method], $parameters);

        if ($flushCache === true && ($forceFlush === true || (is_array($result) && isset($result['error']) && !$result['error']))) {
            $this->cache->flushCache();
        }

        return $result;
    }

    /**
     * @return BaseModelContract
     */
    public function getModel()
    {
        return call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
    }

    /**
     * @return BaseModelContract
     */
    public function getBuilderModel()
    {
        return call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
    }

    /**
     * @return array
     */
    public function getBuilder()
    {
        return call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
    }

    /**
     * Get model table
     * @return string
     */
    public function getTable()
    {
        return call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
    }

    /**
     * Get primary key
     * @return string
     */
    public function getPrimaryKey()
    {
        return call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
    }

    /**
     * @param $columns
     * @return $this
     */
    public function select($columns)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCriteria()
    {
        return call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
    }

    /**
     * @param $criteria
     * @return $this
     * @throws WrongCriteria
     */
    public function pushCriteria($criteria)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param $criteria
     * @return $this
     */
    public function dropCriteria($criteria)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function skipCriteria($bool = true)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria()
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param CriteriaContract|string $criteria
     * @return Collection|BaseModelContract|LengthAwarePaginator|null|mixed
     */
    public function getByCriteria($criteria, array $crossData = [])
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @return $this
     */
    public function resetModel()
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @return $this
     */
    public function resetBuilder()
    {
        return call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
    }
}
