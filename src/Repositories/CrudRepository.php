<?php

namespace catalyst\StarterKitRestApi\Repositories;

use Classes\ApiResponseClass;
use Interfaces\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Model;


class CrudRepository extends BaseRepository implements CrudRepositoryInterface
{
   public function index(Model $model, $paginated = false, $folder = null, $files = null, $where = [], $whereNot = [], $search = [], $active = null, $verify = null, $relation = [])
   {
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);

      $result = $paginated ? $query->paginate(env('PAGINATE')) : $query->get();

      if (!empty($files) && !empty($folder)) {
         $result->map(function ($item) use ($files, $folder) {
            foreach ($files as $key) {
               $item[$key] = $item[$key] == null ? null : $this->FilePath($folder, $item['id'], $item[$key]);
            }
            return $item;
         });
      }

      return $result;
   }

   public function getById(Model $model, $id, $folder = null, $files = null, $where = [], $whereNot = [], $search = [], $active = null, $verify = null, $relation = [])
   {
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $query->findOrFail($id);
      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);
      $query = $this->ShowFileURl($files, $folder, $id, $query);

      return $query;
   }

   public function store(Model $model, $data, $request, $folder = null, $files = [], array $modified_values = [], array $hashing_values = [], $relation = [])
   {
      $data = $this->updateDatas($data,  $modified_values,  $hashing_values);
      $createdModel = $model->create($data);
      $id = $createdModel->id;
      $data = $this->storeImagesWithNames($data, $folder, $files, $id);
      $createdModel->update($data);
      $data = $this->ShowFileURl($files, $folder, $id, $data);

      // Handle relations
      if (!empty($relation)) {
         foreach ($relation as $rel => $relData) {
            if (method_exists($createdModel, $rel)) {
               $relationType = get_class($createdModel->$rel());
               if ($relationType === 'Illuminate\Database\Eloquent\Relations\HasOne' || $relationType === 'Illuminate\Database\Eloquent\Relations\BelongsTo') {
                  $createdModel->$rel()->create($relData);
               } elseif ($relationType === 'Illuminate\Database\Eloquent\Relations\HasMany') {
                  $createdModel->$rel()->createMany($relData);
               }
            }
         }
      }

      return ApiResponseClass::sendResponse($data,  message: 'Created successfully', code: 200);
   }

   public function update(Model $model, array $data, $id, $request = null,  $folder = null, $files = [], $modified_values = [],  $hashing_values = [],  array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null, $relation = [])
   {
      $data = $this->updateDatas($data,  $modified_values,  $hashing_values);
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $query->whereId($id);
      $oldImages = $query->first()->only($files);

      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);
      $data = $this->storeImagesWithNames($data, $folder, $files, $id, $oldImages);
      $query->update($data);
      $data = $this->ShowFileURl($files, $folder, $id, $data);

      // Handle relations
      if (!empty($relation)) {
         foreach ($relation as $rel => $relData) {
            if (method_exists($model, $rel)) {
               $relationType = get_class($model->$rel());
               if ($relationType === 'Illuminate\Database\Eloquent\Relations\HasOne' || $relationType === 'Illuminate\Database\Eloquent\Relations\BelongsTo') {
                  $model->$rel()->updateOrCreate(['id' => $relData['id'] ?? null], $relData);
               } elseif ($relationType === 'Illuminate\Database\Eloquent\Relations\HasMany') {
                  foreach ($relData as $item) {
                     $model->$rel()->updateOrCreate(['id' => $item['id'] ?? null], $item);
                  }
               }
            }
         }
      }

      return ApiResponseClass::sendResponse($data,  message: 'Updated successfully', code: 200);
   }

   public function delete(Model $model, $folder,  $id = null, array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null, $relation = [])
   {
      try {
         $query = $model->query();
         if (!empty($relation)) {
            $query = $query->with($relation);
         }
         if ($id != null) {
            $query = $query->findOrFail($id);
         }
         $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
         $query = $this->active($query, $active);
         $query = $this->verified($query, $verify);

         $query->delete();
         $this->deleteFolderById($folder, $id);
      } catch (\Exception $e) {
         return response()->json(['error' => $e->getMessage()], 500);
      }
   }

   public function verify(Model $model, $id, $folder = null, $files = null, array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null, $relation = [])
   {
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $query->whereId($id);
      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);

      return $query->update(['verified' => 1]);
   }

   public function unverify(Model $model, $id, $folder = null, $files = null, array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null, $relation = [])
   {
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $query->whereId($id);
      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);

      return $query->update(['verified' => 0]);
   }

   public function groupBy(Model $model, $groupBy, $paginated = false, $folder = null, $files = null, array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null, $relation = [])
   {
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);
      return $query = $this->multipleGroupBy($paginated ? $query->paginate(env('PAGINATE')) : $query->get(), $groupBy);
   }

   public function getByDate(Model $model, $date, $column, $paginated = false, $folder = null, $files = null, array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null, $relation = [])
   {
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $query->whereDate($column, $date);
      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);

      return $paginated ? $query->paginate(env('PAGINATE')) : $query->get();
   }

   public function getBetweenDate(Model $model, $date, $column, $paginated = false, $folder = null, $files = null, array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null, $relation = [])
   {
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $query->whereBetween($column, $date);
      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);

      return $paginated ? $query->paginate(env('PAGINATE')) : $query->get();
   }

   public function getMoreThan(Model $model, $data, $column, $paginated = false, $folder = null, $files = null, array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null, $relation = [])
   {
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $query->where($column, '>', $data);
      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);

      return $paginated ? $query->paginate(env('PAGINATE')) : $query->get();
   }

   public function getLessThan(Model $model, $data, $column, $paginated = false, $folder = null, $files = null, array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null, $relation = [])
   {
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $query->where($column, '<', $data);
      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);

      return $paginated ? $query->paginate(env('PAGINATE')) : $query->get();
   }

   public function getMoreThanEqual(Model $model,  $data, $column, $paginated = false, $folder = null, $files = null, array $where = [], array $whereNot = [], array $search = [], $active = null, $verify = null, $relation = [])
   {
      $query = $model->query();
      if (!empty($relation)) {
         $query = $query->with($relation);
      }
      $query = $query->where($column, '>=', $data);
      $query = $this->whereWhereNotSearch($query, $where, $whereNot, $search);
      $query = $this->active($query, $active);
      $query = $this->verified($query, $verify);

      return $paginated ? $query->paginate(env('PAGINATE')) : $query->get();
   }
}
