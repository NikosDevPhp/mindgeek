<?php

namespace App\Repositories;

use App\Objects\BaseDTO;
use App\Queries\SyncRelationToModelQuery;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Repository
 *
 * @package App\Repositories\Eloquent
 */
abstract class BaseRepository
{
    /**
     * @var Model|Builder
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct(private SyncRelationToModelQuery $syncRelationToModelQuery)
    {
        $this->model = app()->make($this->model());
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public abstract function model(): string;

    /**
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*'])
    {
        return $this->model->get($columns);
    }

    public function getModelWithRelations(string $attribute, mixed $value, array $relations = [], array $columns = ['*']): Builder
    {
        $query = $this->model->newQuery();
        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->select($columns)->where($attribute, '=', $value);
    }

    public function getMultipleModelsWithRelations(array $relations = [], array $columns = ['*'])
    {
        $query = $this->model->newQuery();
        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->select($columns)->get();
    }

    /**
     * @param string $value
     * @param string $key
     * @return array|\Illuminate\Support\Collection
     */
    public function lists($value, $key = null)
    {
        return $this->model->pluck($value, $key);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate(int $perPage = 1, array $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return Model|mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }


    /**
     * @param array $values
     * @return bool
     */
    public function insert(array $values): bool
    {
        return $this->model->insert($values);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * $filters support for simple where: [['column','operand','value'],[...]](only AND is supported)
     * $filters support for whereIn: [['column','in',['value1','value2']],[...]](only AND is supported)
     *
     * @param array $filters
     * @return mixed|Collection
     * @throws Exception
     */
    public function deleteByFilters(array $filters)
    {
        $query = $this->model->query();
        foreach ($filters as $filter) {
            if ($filter[1] !== 'in') {
                $query->where($filter[0], $filter[1], $filter[2]);
            } else {
                $query->whereIn($filter[0], $filter[2]);
            }
        }

        return $query->delete();
    }

    /**
     * @param $id
     * @param array $columns
     * @return Model
     */
    public function find($id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return Model
     */
    public function findOrFail($id, array $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return Collection|mixed
     */
    public function findBy($attribute, $value, array $columns = ['*'])
    {
        return $this->model->where($attribute, '=', $value)
            ->get($columns);
    }


    /**
     * @param BaseDTO $dto
     * @param string $identifier
     * @return Builder|Model
     */
    public function updateOrCreateByIdentifier(BaseDTO $dto, string $identifier): Model|Builder
    {
        return $this->model->updateOrCreate((array)$dto, [$identifier => $dto->$identifier]);
    }

    /**
     * @param Collection $items
     * @param string $identifier
     * @param array|null $merge
     * @return Collection
     */
    public function updateOrCreateMultipleModelsByIdentifier(Collection $items, string $identifier, array $merge = null): Collection
    {
        $collection = collect();

        foreach ($items as $item) {
            $collection->add($this->updateOrCreateByIdentifier($item, $identifier));
        }

        return $collection;
    }


    /**
     * @param Model $modelClass
     * @param string $relation
     * @param Collection $collection
     * @param string $id
     * @throws Exception
     */
    public function syncCollectionToModel(Model $modelClass, string $relation, Collection $collection, string $id = 'id')
    {
        $this->syncRelationToModelQuery
            ->setModel($modelClass)
            ->setRelation($relation)
            ->setRelationIds($collection->pluck($id)->all())
            ->execute();
    }

}
