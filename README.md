# Laravel Starter Kit - Authentication and CRUD Repository

A ready-to-use Laravel starter kit featuring authentication and a base CRUD repository. This package is designed to save time and effort by providing a robust foundation for any Laravel-based API application.

---

## Features

### **Authentication**

-   JWT-based authentication for secure API token management.

### **Base CRUD Repository**

-   Centralized CRUD repository pattern to minimize code redundancy and enhance maintainability.

### **Image Uploads**

-   Handles image uploads and storage with automatic naming and folder organization.
-   Supports image uploads for all CRUD features, with files saved according to the model ID.

### **API Ready**

-   Pre-configured routes and controller logic to quickly set up API endpoints.

### **Flexible Parameters**

-   No need to send empty arrays (e.g., `[]`) for parameters unless required.
-   Middleware adjusts functionality based on the presence of data in the parameters.

---

## Installation

Install the package using Composer:

```bash
composer require neeraj/catalyst-starterkit-restapi
```


```bash
php artisan jwt:secret
```
```bash
php artisan migrate
```

---

## Usage

### **Controllers**

-   Example `ProductController` is provided with full CRUD functionality.
-   Extend the `CrudRepository` to add logic for other models.
-   Ensure the image folder is updated dynamically using the `$folder` variable based on model requirements.

### **Routes**

Pre-configured routes for authentication and product management:

```php
// routes/api.php
Route::apiResource('products', ProductController::class);
```

To update a product using a PUT request:

```bash
localhost:8000/api/products/1?_method=PUT
```

### **Requests**

Custom request classes for validation:

-   `StoreProductRequest`
-   `UpdateProductRequest`

### **Environment Variables**

-   Set pagination count with `PAGINATE` in `.env`.
-   Modify as per your requirements.

---

## Folder Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── ProductController.php
│   ├── Requests/
│   │   ├── StoreProductRequest.php
│   │   └── UpdateProductRequest.php
├── Models/
│   └── Product.php
├── Repositories/
│   ├── BaseRepository.php
│   └── CrudRepository.php
```

---

## Image Handling

-   Images are stored in folders named according to the model ID.
-   To allow for multiple images, use the `$file` array to specify fields for the images.
-   Dynamically change the `$folder` variable for different models.

---

## CRUD Repository Overview

The `CrudRepository` implements a centralized pattern for managing CRUD operations, designed to work seamlessly with various models. Below is an explanation of its key methods and usage:

### **index**

```php
$this->interface->index(Model $model, $paginated, $folder, $files, $where, $whereNot, $search, $active, $verify, $relation);
```

-   Fetches records from the database.
-   Supports optional filters for `where`, `whereNot`, `search`, and status (`active`, `verify`).
-   Handles relationships (`$relation`) and dynamically includes image paths if `$files` and `$folder` are provided.

### **getById**

```php
$this->interface->getById(Model $model, $id, $folder, $files, $where, $whereNot, $search, $active, $verify, $relation);
```

-   Fetches a single record by ID.
-   Includes filters and dynamic file URLs, similar to the `index` method.

### **store**

```php
$this->interface->store(Model $model, $data, $request, $folder, $files, $modified_values, $hashing_values, $relation);
```

-   Creates a new record in the database.
-   Supports:
    -   Dynamic image storage.
    -   Relationships: Automatically creates related records for `hasOne`, `hasMany`, and `belongsTo` relations based on the `$relation` parameter.

### **update**

```php
$this->interface->update(Model $model, $data, $id, $request, $folder, $files, $modified_values, $hashing_values, $where, $whereNot, $search, $active, $verify, $relation);
```

-   Updates an existing record by ID.
-   Handles image updates, dynamic relationships, and field modifications.

### **delete**

```php
$this->interface->delete(Model $model, $folder, $id, $where, $whereNot, $search, $active, $verify, $relation);
```

-   Deletes a record by ID, including related images stored in the specified folder.

### **verify / unverify**

```php
$this->interface->verify(Model $model, $id);
$this->interface->unverify(Model $model, $id);
```

-   Toggles the `verified` status of a record.

### **getByDate / getBetweenDate**

-   Fetch records based on specific date criteria.

### **getMoreThan / getLessThan**

-   Fetch records where a field exceeds or is less than a specified value.

---

## Contributing

### **Bug Fixes and Updates**

-   Identify and fix bugs, then push changes to the `bug` branch for review.
-   Collaboration is encouraged! Your contributions are a big help in improving the project.
-   For new features, create branches with descriptive names, such as `feature-event-name`.
-   For fixes, use branch names like `fix-issue-description`.

We welcome collaboration and are excited to work with you to expand this project further! Please collaborate on [GitHub](https://github.com/NeeRaj556/Laravel-StarterKit-RestApi) and leave a star if you find this package useful.

### **Future Features**

-   Role and permission-based access control is in progress and will be updated soon.
-   Improved relational data management, including:
    -   Nested CRUD operations for related models.
    -   Automated handling of pivot tables for many-to-many relationships.
    -   Default eager loading for optimized relational queries.

---

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

---

## Author

Niraj Bajagain (https://github.com/NeeRaj556)

---

