<?php

namespace App\Queries;

use Exception;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use ReflectionException;

class SyncRelationToModelQuery
{
    private Model $model;

    private array $relationIds;

    private string $relation;

    /**
     * @throws Exception
     */
    public function execute()
    {
        try {
            $relation = (new ReflectionClass($this->model::class))->getMethod($this->relation);
        } catch (ReflectionException $e) {
            throw new Exception($e);
        }

        $this->model->{$relation->getName()}()->sync($this->relationIds);
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function setRelationIds(array $relationIds): self
    {
        $this->relationIds = $relationIds;

        return $this;
    }

    public function setRelation(string $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

}
