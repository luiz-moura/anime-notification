<?php

namespace Infra\Abstracts;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected EloquentBuilder $model;
    protected $modelClass;

    public function __construct()
    {
        $this->model = $this->resolveModel()->query();
    }

    private function resolveModel(): Model
    {
        return app($this->modelClass);
    }
}
