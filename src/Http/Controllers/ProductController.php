<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Interfaces\CrudRepositoryInterface;
use App\Models\Product;
use App\Repositories\CrudRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $interface;
    protected $model;
    protected $files = ['image1', 'image2'];

    protected $folder = 'products';

    public function __construct(CrudRepositoryInterface $interface, Product $model)
    {
        $this->interface = $interface;
        $this->model = $model;
    }

    // List all products
    public function index(Request $request)
    {
        $where = $request->has('where') ? $request->get('where')->toArray() : [];
        $whereNot = $request->has('whereNot') ? $request->get('whereNot')->toArray() : [];
        $search = $request->has('search') ? $request->get('search')->toArray() : [];
        $active = $request->has('active') ? $request->get('active') : false;
        $verify = $request->has('verify') ? $request->get('verify') : false;
        $paginated = $request->get('paginated', true); // Default to paginated results
        $products =  $this->interface->index($this->model, $paginated, $this->folder, $this->files,  $where, $whereNot, $search, $active, $verify);
        return response()->json($products, 200);
    }

    // Show a single product
    public function show($id, Request $request)
    {
        $where = $request->has('where') ? $request->get('where')->toArray() : [];
        $whereNot = $request->has('whereNot') ? $request->get('whereNot')->toArray() : [];
        $search = $request->has('search') ? $request->get('search')->toArray() : [];
        $active = $request->has('active') ? $request->get('active')->toArray() : [];
        $verify = $request->has('verify') ? $request->get('verify')->toArray() : [];
        $product =  $this->interface->getById($this->model, $id, $this->folder, $this->files, $where, $whereNot, $search, $active, $verify);
        return response()->json($product, 200);
    }

    // Create a new product
    public function store(StoreProductRequest $request)
    {

        $data = $request->validated();

        $modifiedValues = ['price' => (float) $data['price']]; // Example modification
        $hashingValues = [];

        // Example: keys to hash (none in this case) not need to include 
        $product =  $this->interface->store($this->model, $data, $request, $this->folder, $this->files,  $modifiedValues, $hashingValues);
        return response()->json($product, 201);
    }

    // Update an existing product
    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->validated();
        $modifiedValues = ['price' => (float) $data['price']]; // Example modification
        $hashingValues = []; // Example: keys to hash (none in this case)

        $updated =  $this->interface->update(
            $this->model,
            $data,
            $id,
            $request, // Where conditions
            $this->folder,
            $this->files, // WhereNot conditions
            $modifiedValues,
            $hashingValues,
            // Search

        );

        return response()->json(['success' => $updated], 200);
    }

    // Delete a product
    public function destroy(Request $request, $id)
    {

        $this->interface->delete($this->model, $this->folder, $id);
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
