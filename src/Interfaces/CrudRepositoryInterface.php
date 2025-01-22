<?php

namespace catalyst\StarterKitRestApi\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface CrudRepositoryInterface
{
    public function index(
        Model $model,
        $paginated = false,
        $folder = null,
        $files = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function getById(
        Model $model,
        $id,
        $folder = null,
        $files = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function store(
        Model $model,
        array $data,
        $request,
        $folder = null,
        array $files = [],
        array $modified_values = [],
        array $hashing_values = [],
        array $relation = []
    );

    public function update(
        Model $model,
        array $data,
        $id,
        $request = null,
        $folder = null,
        array $files = [],
        array $modified_values = [],
        array $hashing_values = [],
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function delete(
        Model $model,
        $folder,
        $id = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function verify(
        Model $model,
        $id,
        $folder = null,
        $files = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function unverify(
        Model $model,
        $id,
        $folder = null,
        $files = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function groupBy(
        Model $model,
        $groupBy,
        $paginated = false,
        $folder = null,
        $files = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function getByDate(
        Model $model,
        $date,
        $column,
        $paginated = false,
        $folder = null,
        $files = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function getBetweenDate(
        Model $model,
        array $date,
        $column,
        $paginated = false,
        $folder = null,
        $files = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function getMoreThan(
        Model $model,
        $data,
        $column,
        $paginated = false,
        $folder = null,
        $files = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function getLessThan(
        Model $model,
        $data,
        $column,
        $paginated = false,
        $folder = null,
        $files = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );

    public function getMoreThanEqual(
        Model $model,
        $data,
        $column,
        $paginated = false,
        $folder = null,
        $files = null,
        array $where = [],
        array $whereNot = [],
        array $search = [],
        $active = null,
        $verify = null,
        array $relation = []
    );
 }
