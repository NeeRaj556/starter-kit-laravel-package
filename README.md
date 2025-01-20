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

### 1. Clone the Repository (HTTPS)

```bash
git clone https://github.com/NeeRaj556/Laravel-StarterKit-RestApi.git
```

### SSH

```bash
git clone git@github.com:NeeRaj556/Laravel-StarterKit-RestApi.git
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

-   Copy `.env.example` to `.env`
-   Update database credentials and other environment variables in `.env`.

```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Seed Database (Optional)

```bash
php artisan db:seed
```

### 6. Storage Symlink Command

```bash
php artisan storage:link
```

### 7. Serve the Application

```bash
php artisan serve
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

## Contributing

### **Bug Fixes and Updates**

-   Identify and fix bugs, then push changes to the `bug` branch for review.
-   Collaboration is encouraged! Your contributions are a big help in improving the project.
-   For new features, create branches with descriptive names, such as `feature-event-name`.
-   For fixes, use branch names like `fix-issue-description`.

We welcome collaboration and are excited to work with you to expand this project further!

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

## Future Improvements

-   Support for more complex query filters.
-   Role and permission-based access.
-   Additional pre-built components for common use cases.
-   Enhanced relational data management to handle associations such as `hasMany`, `belongsTo`, and `many-to-many`. This will streamline building APIs for models with relational dependencies.

