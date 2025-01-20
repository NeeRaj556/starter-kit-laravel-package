<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class  BaseRepository
{
   // public Functions
   public function multipleWhere($query, $data)
   {

      if ($query != null && $data == [])
         foreach ($data as $key => $value) {
            $query = $query->where($key, $value);
         }
      return $query;
   }
   public function multipleWhereNot($query, $data)
   {
      if ($query != null && $data == [])
         foreach ($data as $key => $value) {
            $query = $query->whereNot($key, $value);
         }
      return $query;
   }
   public function search($query, $data)
   {
      if ($query != null && $data == [])
         foreach ($data as $key => $value) {
            $query = $query->where($key, 'like', '%' . $value . '%');
         }
      return $query;
   }
   public function whereWhereNotSearch($query, $where, $whereNot, $search)
   {

      $query = $this->multipleWhere($query, $where);
      $query = $this->multipleWhereNot($query, $whereNot);
      $query = $this->search($query, $search);
      return $query;
   }
   public function active($query, $active = null)
   {

      return $active ? $query->active() : $query;
   }
   public function verified($query, $verify)
   {
      if ($query != null && $verify != null) {
         $query = $query->where('active', $verify);
      }
      return $verify ? $query->verified() : $query;
   }
   public function multipleGroupBy($query, $column)
   {
      if ($query != null && $column != null && is_array($column)) {
         foreach ($column as $key => $value) {
            $query = $query->groupBy($value);
         }
      }
      return $query;
   }
   public function storeImages(array &$data, string $folder): ?string
   {

      if (!isset($data['images']) || !is_array($data['images'])) {
         return null; // Return null if no images are provided or invalid
      }

      $storedImages = [];
      foreach ($data['images'] as $image) {
         if ($image instanceof \Illuminate\Http\UploadedFile) {
            // Store each image in the specified folder
            $storedImages[] = $image->store($folder, 'public');
         }
      }

      unset($data['images']); // Remove 'images' key to avoid issues with further processing

      return json_encode($storedImages); // Return JSON-encoded paths
   }
   public function storeImagesWithNames($data, string $folder, $files, int $id, $oldImages = [])
   {
      // Remove old images if provided
      $this->deleteImages($files, $folder, $id, $oldImages);
      $storedImages = $data;

      $folderPath = $folder . DIRECTORY_SEPARATOR . $id; // Create folder path with id
      if ($files != [])

         foreach ($files as $file) {
            if (isset($data[$file]) && $data[$file] instanceof \Illuminate\Http\UploadedFile) {
               $filename = now()->format('Ymd') . '_' . \Illuminate\Support\Str::random(4) . '.' . $data[$file]->getClientOriginalExtension();
               $data[$file]->storeAs($folderPath, $filename, 'public');
               $storedImages[$file] = $filename;
            } else {
               $storedImages[$file] = null;
            }
         }

      return $storedImages;
      // Return JSON-encoded paths with names
   }
   public function deleteImages($images, string $folder, int $id, array $oldImages): void
   {

      if (!isset($oldImages) || !is_array($images)) {
         return; // Return if no images are provided or invalid
      }

      foreach ($oldImages as $key => $imagePath) {
         $fullPath = $imagePath;

         $fullPath = $folder . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $imagePath;
         if (Storage::disk('public')->exists($fullPath)) {
            Storage::disk('public')->delete($fullPath); // Delete the image from storage
         }
      }
   }
   public function deleteFolderById(string $folder, int $id): void
   {
      $folderPath = $folder . DIRECTORY_SEPARATOR . $id; // Create folder path with id
      if (Storage::disk('public')->exists($folderPath)) {
         Storage::disk('public')->deleteDirectory($folderPath); // Delete the folder from storage
      }
   }
   public function updateDatas(array $data, array $modified_values, array $hashing_values): array
   {
      if ($modified_values != null && $modified_values != []) {
         foreach ($modified_values as $key => $value) {
            $data[$key] = $value;
         }
      }
      if ($hashing_values != null) {
         foreach ($hashing_values as $key => $value) {
            $data[$key] = \Illuminate\Support\Facades\Hash::make($value);
         }
      }
      return $data;
   }

   public function FilePath($folder, $id, $file)
   {
      return Storage::url($folder . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $file);
   }
   public function ShowFileURl($files, $folder, $id, $query)
   {

      if (!empty($files) && !empty($folder)) {
         foreach ($files as $key) {
            $query[$key] = $query[$key] == null ? null : $this->FilePath($folder, $id, $query[$key] ?? null);
         }
      }
      return $query;
   }
}
