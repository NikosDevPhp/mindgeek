<?php

namespace App\Repositories;

use App\Objects\BaseDTO;
use App\Queries\SyncRelationToModelQuery;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Class Repository
 *
 * @package App\Repositories\Eloquent
 */
abstract class BaseRepository
{
    const REPOSITORY_NAME = 'Base_repository';


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
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, string $attribute = 'id')
    {
        // Get model's fillable attributes
        $fillable = $this->model->getFillable();

        // Remove from $data array any key, value pair that isn't a fillable field
        if (!empty($fillable)) { //when fillable is empty we just ignore it
            foreach ($data as $key => $value) {
                if (!in_array($key, $fillable)) {
                    LogExceptions::log(
                        new Exception('Trying to update non fillable field: '.$key.' of model: '.$this->model()),
                        self::REPOSITORY_NAME
                    ); //just a precaution to locate possible bugs in the code
                    Arr::forget($data, $key);
                }
            }
        }

        return $this->model->where($attribute, '=', $id)
            ->update($data);
    }

    /**
     * Mass update given an attribute and an array of values
     *
     * @param array $data
     * @param array $values
     * @param string $attribute
     * @return mixed
     */
    public function updateMass(array $data, array $values = [], string $attribute = 'id')
    {
        // Get model's fillable attributes
        $fillable = $this->model->getFillable();

        // Remove from $data array any key, value pair that isn't a fillable field
        if (!empty($fillable)) { //when fillable is empty we just ignore it
            foreach ($data as $key => $value) {
                if (!in_array($key, $fillable)) {
                    LogExceptions::log(
                        new Exception('Trying to update non fillable field: '.$key.' of model: '.$this->model()),
                        self::REPOSITORY_NAME
                    ); //just a precaution to locate possible bugs in the code
                    Arr::forget($data, $key);
                }
            }
        }

        return $this->model->whereIn($attribute, $values)
            ->update($data);
    }

    /**
     * @param array $data
     * @return bool
     * @throws GuzzleException
     * @throws Throwable
     */
    public function insertMass(array $data): bool
    {
        // Get model's fillable attributes
        $fillable = $this->model->getFillable();
        // Remove from $data array any key, value pair that isn't a fillable field
        if (!empty($fillable)) { //when fillable is empty we just ignore it
            foreach ($data as $key => $value) {
                if (!in_array($key, $fillable)) {
                    LogExceptions::log(
                        new Exception('Trying to insert non fillable field: '.$key.' of model: '.$this->model()),
                        self::REPOSITORY_NAME
                    ); //just a precaution to locate possible bugs in the code
                    Arr::forget($data, $key);
                }
            }
        }

        return $this->model->insert($data);
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
     * @param array $values
     * @param $sequence
     * @return int
     */
    public function insertGetId(array $values, $sequence = null)
    {
        return $this->model->insertGetId($values, $sequence);
    }

    /**
     * @param array $data
     * @param  $id
     * @return mixed
     */
    public function updateRich(array $data, $id)
    {
        if (!($model = $this->model->find($id))) {
            return false;
        }

        return $model->fill($data)
            ->save();
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
     * @param array $filters [['column','operand','value'],[...]](only AND is supported)
     * @param array $columns
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @return mixed|Collection
     */
    public function findByFilters(array $filters, array $columns = ['*'], string $orderBy = null, string $orderDirection = null)
    {
        $query = $this->model->query()
            ->select($columns);
        foreach ($filters as $filter) {
            if ($filter[1] !== 'in') {
                $query->where($filter[0], $filter[1], $filter[2]);
            } else {
                $query->whereIn($filter[0], $filter[2]);
            }
        }
        //$query = $this->model->where($filters);
        if ($orderBy != null && $orderDirection != null) {
            $query->orderBy($orderBy, $orderDirection);
        }

        return $query->get($columns);
    }

    /**
     * $filters: [['column','operand','value'],[...]] else if operand is OR [['column','or',['val1', 'val2']],[...]]
     *
     * @param array $filters
     * @param string $countColumn
     * @return int
     */
    public function countByFilters(array $filters, string $countColumn): int
    {
        $query = $this->model->query();
        foreach ($filters as $filter) {
            if ($filter[1] === 'in') {
                $query->whereIn($filter[0], $filter[2]);
            } elseif ($filter[1] === 'or') {
                $query->where(
                    function ($query) use ($filter) {
                        $i = 0;
                        foreach ($filter[2] as $filterValue) {
                            if ($i == 0) {
                                $query->where($filter[0], $filterValue);
                            } else {
                                $query->orWhere($filter[0], $filterValue);
                            }
                            $i++;
                        }
                    }
                );
            } else {
                $query->where($filter[0], $filter[1], $filter[2]);
            }
        }

        return $query->count($countColumn);
    }

    /**
     * @param array $filters [['column','operand','value'],[...]](only AND is supported)
     * @param array $columns
     * @return Model|mixed
     * @throws ModelNotFoundException
     */
    public function findFirstOrFailByFilters(array $filters, array $columns = ['*'])
    {
        return $this->model->where($filters)
            ->firstOrFail($columns);
    }

    /**
     * @param array $filters [['column','operand','value'],[...]](only AND is supported)
     * @return bool
     */
    public function existsByFilters(array $filters)
    {
        $query = $this->model->query();

        foreach ($filters as $filter) {
            if ($filter[1] !== 'in') {
                $query->where($filter[0], $filter[1], $filter[2]);
            } else {
                $query->whereIn($filter[0], $filter[2]);
            }
        }

        return $query->exists();
    }

    /**
     * @param $attribute
     * @param array $values
     * @param array $columns
     * @return Collection
     */
    public function findByIn($attribute, array $values, array $columns = ['*'])
    {
        return $this->model->whereIn($attribute, $values)
            ->get($columns);
    }

    /**
     * This method searches for relevant rows in database
     * and updates the first of them if any
     * or creates a new row if not
     *
     * @param array $attributes
     * @param array $values
     * @return mixed|static
     */
    public function updateOrCreateByIdentifier(BaseDTO $dto, string $identifier)
    {
        return $this->model->updateOrCreate((array)$dto, [$identifier => $dto->$identifier]);
    }

    public function updateOrCreateMultipleModelsByIdentifier(Collection $items, string $identifier, array $merge = null)
    {
        $collection = collect();

        foreach ($items as $item) {
            $collection->add($this->updateOrCreateByIdentifier($item, $identifier));
        }

        return $collection;
    }

    /**
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

    /**
     * This method will attempt to locate a database record using the given column / value pairs. If the model cannot be found in the
     * database, a record will be inserted with the attributes resulting from merging the first array argument with the optional
     * second array argument.
     *
     * @param array $attributes
     * @param array $values
     * @return mixed|static
     */
    public function firstOrCreate(array $attributes, array $values = [])
    {
        return $this->model->firstOrCreate($attributes, $values);
    }


}
