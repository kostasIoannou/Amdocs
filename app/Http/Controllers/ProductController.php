<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Events\ProductCreated;
use App\Models\Tag;
use App\Events\ProductUpdated;
use App\Helpers\Helper;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve products from the database, supporting category filtering
        $categoryId = $request->query('category_id');

        // Query the products based on the category ID, if provided
        $productsQuery = $categoryId
            ? Product::where('category_id', $categoryId)
            : Product::query();

        // Include the category relationship in the query
        $productsQuery->with('category');

         // Retrieve the products
        $products = $productsQuery->get();

        // Return the products as a JSON response
        return response()->json($products);
    }

    public function show(Product $product)
    {
        // Retrieve a specific product by ID
        return response()->json($product);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'release_date' => 'required|date',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255',
        ]);

        // Generate a unique code for the product
        $code = Product::generateUniqueCode();

        // Add the code to the validated data
        $validatedData['code'] = $code;

        // Create the product
        $product = Product::create($validatedData);

        // Attach tags based on their names
        $tags = $request->input('tags');

        if (!empty($tags)) {
            $tagIds = [];

            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }

            $product->tags()->attach($tagIds);
        }

        //send webhook
        event(new ProductCreated($product));

        return response()->json(['message' => 'Product created successfully']);
    }

    public function update(Request $request, Product $product)
    {
       // Validate the request data
       $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'release_date' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255',
        ]);
        
        if (isset($validatedData['name'])) {
             $product->name = $validatedData['name'];
        }
        
        if (isset($validatedData['release_date'])) {
            $product->release_date = $validatedData['release_date'];
        }

        // Check if the category_id is provided in the request
        if (isset($validatedData['category_id'])) {
            $category = Category::findOrFail($validatedData['category_id']);
            $product->category()->associate($category);
        } else {
            // If the category_id is not provided, keep the existing category
            $product->category_id = $product->category_id;
        }

        // Update the product tags
        $tags = $validatedData['tags'];
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        $product->tags()->sync($tagIds);

        $product->save();

        event(new ProductUpdated($product));

        return response()->json(['message' => 'Product updated successfully']);
    }
}
