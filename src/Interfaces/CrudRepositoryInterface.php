<?php

namespace catalyst\StarterKitFastApi\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface CrudRepositoryInterface
{
    public function index(Model $model, $paginated = false, $folder = null, $files = [], array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);

    public function getById(Model $model, $id, $folder = null, $files = [], array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);

    public function store(Model $model, $data, $request, $folder = null, $files = [], array $modified_values = [], array $hashing_values = []);

    public function update(Model $model, array $data, $id, $request = [],  $folder = null, $files = [], $modified_values = [],  $hashing_values = null,  array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);
    public function delete(Model $model, $folder,  $id = null, array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);

    public function verify(Model $model, $id, $folder = null, $files = [], array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);

    public function unverify(Model $model, $id, $folder = null, $files = [], array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);

    public function groupBy(Model $model, $groupBy, $paginated = false, $folder = null, $files = [], array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);
    public function getByDate(Model $model, $date, $column, $paginated = false, $folder = null, $files = [], array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);

    public function getBetweenDate(Model $model, $date, $column, $paginated = false, $folder = null, $files = [], array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);

    public function getMoreThan(Model $model, $data, $column, $paginated = false, $folder = null, $files = [], array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);

    public function getLessThan(Model $model, $data, $column, $paginated = false, $folder = null, $files = [], array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);

    public function getMoreThanEqual(Model $model, $data, $column, $paginated = false, $folder = null, $files = [], array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null);
}
