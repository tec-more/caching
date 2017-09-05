<?php namespace Tukecx\Base\Caching\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tukecx\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;
use Tukecx\Base\Core\Models\Contracts\BaseModelContract;
use Tukecx\Base\Core\Models\EloquentBase;

abstract class EloquentBaseRepositoryCacheDecorator extends AbstractRepositoryCacheDecorator
{
    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function beforeGet($method, $parameters)
    {
        if ($this->needIgnoreCache()) {
            return call_user_func_array([$this->repository, $method], $parameters);
        }

        $repository = clone $this->repository;

        $model = $repository->getBuilderModel();
        $builder = $repository->getBuilder();

        $relations = [];

        if ($model instanceof EloquentBuilder) {
            $relations = [$model->toSql()];
        }

        if ($model instanceof BaseModelContract || $model instanceof EloquentBuilder) {
            $this->cache->setCacheKey($method, array_merge($parameters, $relations, $builder));
        } else {
            $this->cache->setCacheKey($method, $parameters);
        }

        /**
         * Clear params
         */
        $this->repository->resetModel();

        return $this->cache->retrieveFromCache(function () use ($repository, $method, $parameters) {
            return call_user_func_array([$repository, $method], $parameters);
        });
    }

    public function needIgnoreCache()
    {
        $model = $this->getBuilderModel();

        if ($model instanceof EloquentModel) {
            $relations = $model->getRelations();
        } elseif ($model instanceof EloquentBuilder) {
            $relations = $model->getEagerLoads();
        } else {
            throw  new \Exception('Wrong model');
        }

        if ($relations) {
            return true;
        }

        return false;
    }

    /**
     * @param $field
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function where($field, $operator = null, $value = null)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param $field
     * @param null $type
     * @return $this
     */
    public function orderBy($field, $type = null)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param $id
     * @param array $columns
     * @return EloquentBase|null
     */
    public function find($id, $columns = ['*'])
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $howManyItem
     * @return $this
     */
    public function take($howManyItem)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param array $columns
     * @return Collection
     */
    public function get($columns = ['*'])
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function first($columns = ['*'])
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $perPage
     * @param array $columns
     * @param string $pageName
     * @param null $currentPaged
     * @return LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'], $pageName = 'page', $currentPaged = null)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $fields
     * @return EloquentBase|null
     */
    public function findByFields($fields)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $fields
     * @param null $optionalFields
     * @param bool $forceCreate
     * @return EloquentBase|null
     */
    public function findByFieldsOrCreate($fields, $optionalFields = null, $forceCreate = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @return EloquentBase
     */
    public function findOrNew($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * Create a new item.
     * Only fields listed in $fillable of model can be filled
     * @param array $data
     * @return EloquentBase
     */
    public function create(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Create a new item, no validate
     * @param $data
     * @return EloquentBase
     */
    public function forceCreate(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Validate model then edit
     * @param EloquentBase|int|null $id
     * @param $data
     * @param bool $allowCreateNew
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function editWithValidate($id, array $data, $allowCreateNew = false, $justUpdateSomeFields = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Find items by ids and edit them
     * @param array $ids
     * @param array $data
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function updateMultiple(array $ids, array $data, $justUpdateSomeFields = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Find items by fields and edit them
     * @param array $fields
     * @param $data
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function update(array $data, $justUpdateSomeFields = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Delete items by id
     * @param EloquentBase|int|array|null $id
     * @return mixed
     */
    public function delete($id = null)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
